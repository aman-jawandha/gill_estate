<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use App\Models\Property;
use App\Models\Gallery;
use App\Models\UserBooking;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function set_timezone(Request $request)
    {
        session(['browser_timezone' => $request->timezone]);
        return response()->json(['status' => 'ok']);
    }

    public function home(){
        $faqs = DB::table('faqs')->where('status','Active')->get();
        $properties = Property::orderBy('published_at','DESC')->where('status','!=','Pending')->where('status','!=','Inactive')->where('status','!=','Rejected')->limit(6)->get();
        return view('website.home',compact('faqs','properties'));
    }

    public function about_us(){
        return view('website.about_us');
    }

    public function contact_us(){
        $durations = DB::table('durations')->where('user_id',1)->first();
        $availabilities = DB::table('user_availabilities')->where('user_id',1)->get();
        $days_breaks = DB::table('days_breaks')->where('user_id',1)->where('to_date','>=',date('Y-m-d'))->get();
        return view('website.contact_us',compact('durations','availabilities','days_breaks'));
    }

    public function get_time_slots(Request $req){
    $booking_date = $req->booking_date;
    $user_id = 1;

    // Use browser timezone if user not logged in
    $userTimezone = getUserTimezone();

    // Check full-day leaves (days_breaks) → stored in UTC
    $days_breaks = DB::table('days_breaks')
        ->where('user_id', $user_id)
        ->where('to_date', '>=', date('Y-m-d'))
        ->get();

    foreach ($days_breaks as $break) {
        if ($booking_date >= $break->from_date && $booking_date <= $break->to_date) {
            return response()->json([
                'status' => 'error',
                'msg'    => 'Practitioner is on leave for the selected date.'
            ]);
        }
    }

    // Fetch daily availability
    $dayName = date('l', strtotime($booking_date));
    $availability = DB::table('user_availabilities')
        ->where('user_id', $user_id)
        ->where('day', $dayName)
        ->first();

    if (!$availability || !$availability->punch_in || !$availability->punch_out) {
        return response()->json([
            'status' => 'error',
            'msg'    => 'Practitioner is not available for the selected day.'
        ]);
    }

    // Work in UTC
    $start = strtotime($availability->punch_in);
    $end   = strtotime($availability->punch_out);

    $breakStart = $availability->break_in ? strtotime($availability->break_in) : null;
    $breakEnd   = $availability->break_out ? strtotime($availability->break_out) : null;

    // Fetch date-specific breaks (hours_breaks) → UTC
    $hourBreaks = DB::table('hours_breaks')
        ->where('user_id', $user_id)
        ->where('date', $booking_date)
        ->get();

    // Fetch existing bookings → UTC
    $bookings = DB::table('user_bookings')
        ->where('booking_date', $booking_date)
        ->whereIn('status', ['Active','Rescheduled'])
        ->get();

    $slots = [];
    $nowUtc = time();

    while ($start < $end) {
        $slotStart = $start;
        $slotEnd   = strtotime("+15 minutes", $slotStart);

        // Skip past slots if booking_date is today
        if ($booking_date == gmdate('Y-m-d') && $slotStart <= $nowUtc) {
            $start = $slotEnd;
            continue;
        }

        // Skip if overlaps daily break
        if ($breakStart && $breakEnd && $slotEnd > $breakStart && $slotStart < $breakEnd) {
            $start = $breakEnd;
            continue;
        }

        $skip = false;

        // Skip if overlaps date-specific breaks
        foreach ($hourBreaks as $hb) {
            $hbStart = strtotime($hb->from_time);
            $hbEnd   = strtotime($hb->to_time);

            if ($slotEnd > $hbStart && $slotStart < $hbEnd) {
                $skip = true;
                $start = $hbEnd;
                break;
            }
        }
        if ($skip) continue;

        // Skip if overlaps existing bookings
        foreach ($bookings as $b) {
            $bookStart = strtotime($b->booking_time);
            $bookEnd   = strtotime($b->end_time);

            if ($slotEnd > $bookStart && $slotStart < $bookEnd) {
                $skip = true;
                $start = $bookEnd;
                break;
            }
        }
        if ($skip) continue;

        // Convert to user's/browser's timezone for display
        $displayTime = \Carbon\Carbon::createFromTimestamp($slotStart, 'UTC');
        if ($userTimezone !== 'UTC') {
            $displayTime->setTimezone($userTimezone);
        }

        $slots[] = $displayTime->format('H:i');

        $start = $slotEnd;
    }

    return response()->json([
        'status' => 'success',
        'msg'    => 'Success',
        'slots'  => $slots
    ]);
}

public function store_appointment(Request $req)
{
    $ran_string = '';

    $slotsResponse = $this->get_time_slots(new Request([
        'booking_date' => $req->booking_date,
    ]));

    $slotsData = $slotsResponse->getData(true);
    if ($slotsData['status'] !== 'success') {
        return back()->withErrors(['error' => $slotsData['msg']]);
    }
    $availableSlots = $slotsData['slots'];

    // Use browser timezone if user not logged in
    $userTz = getUserTimezone();

    $startTimeLocal = Carbon::parse($req->booking_date.' '.$req->booking_time, $userTz);

    $minutes = match ($req->duration) {
        '15 minutes' => 15,
        '30 minutes' => 30,
        '45 minutes' => 45,
        '60 minutes' => 60,
        default => 15,
    };

    $neededSlots = [];
    for ($i = 0; $i < $minutes; $i += 15) {
        $neededSlots[] = $startTimeLocal->copy()->addMinutes($i)->format('H:i');
    }

    foreach ($neededSlots as $slot) {
        if (!in_array($slot, $availableSlots)) {
            return back()->with('error', 'Selected duration is not available from selected time.')->withInput();
        }
    }
    // Create or update user
    $user = User::where('email', $req->email)->first();

    if (!$user) {
        $ran_string = Str::random(8);
        $user = User::create([
            'name'       => $req->name,
            'email'      => $req->email,
            'phone'      => $req->phone,
            'password'   => Hash::make($ran_string),
            'role'       => 'user',
        ]);
        $user->update([
            'created_by'   => $user->id,
        ]);
        $user->assignRole('user');
    } else {
        $ran_string = '';
        $user->name  = $req->name;
        $user->phone = $req->phone;
        $user->save();
    }

    $startTimeUtc = null;
    $endTimeUtc = null;

    // Convert to UTC for storage
    $startTimeUtc = $startTimeLocal->copy()->setTimezone('UTC');
    $endTimeUtc   = $startTimeUtc->copy()->addMinutes($minutes);

    $fees = DB::table('durations')->where('user_id',1)->first();
    if ($req->type === 'Online') {
        $roomName = 'appointment-' . '-' . uniqid();
        $meet_link = "https://meet.jit.si/" . $roomName;
    }else{
        $meet_link = null;
    }

    $amount = $fees->{$req->duration};

    if ($amount == 0) {
    $booking = UserBooking::create([
        'user_id'        => $user->id,
        'type'           => $req->type,
        'meeting_link'   => $meet_link,
        'duration'       => $req->duration,
        'currency_symbol'=> 'CA$',
        'currency_code'  => 'CAD',
        'booking_date'   => ($startTimeUtc) ? $startTimeUtc->format('Y-m-d') : null,
        'booking_time'   => ($startTimeUtc) ? $startTimeUtc->format('H:i:s') : null,
        'end_time'       => ($endTimeUtc) ? $endTimeUtc->format('H:i:s') : null,
        'message'        => $req->message,
        'status'         => 'Active',
    ]);
    }else{
        Stripe::setApiKey(config('services.stripe.secret'));

    $session = Session::create([
        'payment_method_types' => ['card'],
        'mode' => 'payment',
        'line_items' => [[
            'price_data' => [
                'currency' => 'cad',
                'product_data' => [
                    'name' => 'Appointment Booking - '.$req->duration,
                ],
                'unit_amount' => $amount * 100, // cents
            ],
            'quantity' => 1,
        ]],
        'customer_email' => $req->email,
        'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => route('stripe.cancel'),

        // store booking data temporarily
        'metadata' => [
            'user_id' => $user->id,
            'type' => $req->type,
            'duration' => $req->duration,
            'booking_date' => $startTimeUtc->format('Y-m-d'),
            'booking_time' => $startTimeUtc->format('H:i:s'),
            'end_time' => $endTimeUtc->format('H:i:s'),
            'message' => $req->message,
            'meeting_link' => $meet_link,
            'ran_string' => $ran_string,
        ],
    ]);

    return redirect($session->url);
    }

    $details = [
        'title' => 'Appointment Reservation',
        'body'  => "Hello {$req->name},<br><br>
            Your appointment is booked on {$startTimeLocal->format('M d, Y')} at {$startTimeLocal->format('h:i A')} 
            for {$req->duration}.<br><br>"
            . ($ran_string != ''
                ? "<strong>Username:</strong> {$req->email}<br>
                   <strong>Password:</strong> {$ran_string}<br><br>
                   Please log in and update your profile and password for security purposes.<br><br>"
                : "")
            . "<a href='" . url('/login') . "'>Click here to log in</a><br><br>",
    ];

    Mail::to($req->email)->send(new SendMail($details, 'Booked an appointment'));
    return back()->with('success', 'Success! Please check your email.');
}

public function stripe_success(Request $request)
{
    Stripe::setApiKey(config('services.stripe.secret'));

    $session = Session::retrieve($request->session_id);

    if ($session->payment_status !== 'paid') {
        return back()->with('error', 'Payment not completed, please try again later.');
    }

    $meta = $session->metadata;

    UserBooking::create([
        'user_id'        => $meta->user_id,
        'type'           => $meta->type,
        'meeting_link'   => $meta->meeting_link,
        'duration'       => $meta->duration,
        'currency_symbol'=> 'CA$',
        'currency_code'  => 'CAD',
        'booking_date'   => $meta->booking_date,
        'booking_time'   => $meta->booking_time,
        'end_time'       => $meta->end_time,
        'message'        => $meta->message,
        'status'         => 'Active',
        'payment_status' => 'paid',
        'payment_amount' => $session->amount_total / 100,
        'payment_id'     => $session->payment_intent,
        'payment_time'   => now(),
    ]);

    $user = User::find($meta->user_id);

    $startTimeLocal = Carbon::parse(
        $meta->booking_date . ' ' . $meta->booking_time,
        'UTC'
    )->setTimezone(getUserTimezone());

    $details = [
        'title' => 'Appointment Reservation',
        'body'  => "Hello {$user->name},<br><br>
            Your appointment is booked on {$startTimeLocal->format('M d, Y')} at {$startTimeLocal->format('h:i A')} 
            for {$meta->duration}.<br><br>"
            . ($meta->ran_string != ''
                ? "<strong>Username:</strong> {$user->email}<br>
                   <strong>Password:</strong> {$meta->ran_string}<br><br>
                   Please log in and update your profile and password for security purposes.<br><br>"
                : "")
            . "<a href='" . url('/login') . "'>Click here to log in</a><br><br>",
    ];

    Mail::to($user->email)->send(new SendMail($details, 'Booked an appointment'));

    return back()->with('success', 'Success! Please check your email.');
}

    public function properties(){
        $countries = DB::table('countries')->get();
        $types = DB::table('property_types')->get();
        $properties = Property::orderBy('published_at','DESC')->where('status','!=','Pending')->where('status','!=','Inactive')->where('status','!=','Rejected')->paginate(9);
        return view('website.properties',compact('properties','countries','types'));
    }

    public function search_properties(Request $request)
{
    $query = Property::query();

    // Status filter
    $query->whereNotIn('status', ['Pending', 'Inactive', 'Rejected']);

    // Filters
    if ($request->filled('country')) {
        $query->where('country', $request->country);
    }

    if ($request->filled('state')) {
        $query->where('state', $request->state);
    }

    if ($request->filled('city')) {
        $query->where('city', $request->city);
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Price filter
    if ($request->filled('max_price')) {
        if ($request->max_price == '5000000+') {
            $query->where('price', '>=', 5000000);
        } else {
            $query->where('price', '<=', (int) $request->max_price);
        }
    }
    // Order by logic
    if ($request->filled('order_by')) {
        switch ($request->order_by) {
            case 'high_to_low':
                $query->orderBy('price', 'desc');
                break;
            case 'low_to_high':
                $query->orderBy('price', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('published_at', 'desc');
                break;
        }
    } else {
        // No order_by selected
        if ($request->filled('max_price')) {
            $query->orderBy('price', 'desc'); // default if price range selected
        } else {
            $query->orderBy('published_at', 'desc'); // default
        }
    }

    $properties = $query->paginate(9)->appends($request->all());
    $countries = DB::table('countries')->get();
    $types = DB::table('property_types')->get();
    return view('website.properties', compact('properties', 'countries', 'types'));
}

    public function get_states(Request $req){
        $states = DB::table('states')->where('country_id',$req->country_id)->get();
        return response()->json(['data' => $states]);
    }

    public function get_cities(Request $req)
    {
        $cities = DB::table('cities')->where('state_id',$req->state_id)->get();
        return response()->json(['data' => $cities]);
    }

    public function property_detail($id){
        $property = Property::where('id',$id)->first();
        $images = Gallery::where('property_id',$property->id)->where('file_type','Image')->get();
        $videos = Gallery::where('property_id',$property->id)->where('file_type','Video')->get();
        return view('website.property_detail',compact('property','images','videos'));
    }

    public function store_contact_us(Request $req){
        $data = DB::table('feedbacks')->insert([
            'name' => $req->name,
            'email' => $req->email,
            'phone' => $req->phone,
            'type' => $req->type,
            'message' => $req->message,
        ]);
        return redirect()->back()->with('success','Message submitted successfully! We will get back to you soon.');
    }
}
