<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Property;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function admin_dashboard(){
        return view('admin.dashboard');
    }

    public function dashboard(){
        if(Auth::user()->role == 'seller' || Auth::user()->role == 'user'){
            return redirect('profile');
            // return view('seller.dashboard');
        }elseif(Auth::user()->role == 'buyer'){
            return redirect('profile');
            // return view('buyer.dashboard');
        }else{
            $buyers = User::where('role','buyer')->count();
            $sellers = User::where('role','seller')->count();
            $sold_proprts = Property::where('status','Sold')->count();
            return view('admin.dashboard',compact('buyers','sellers','sold_proprts'));
        }
    }

    public function profile(){
        $user = User::where('id',auth()->user()->id)->first();
        $countries = DB::table('countries')->get();
        if(Auth::user()->role == 'seller' || Auth::user()->role == 'buyer' || Auth::user()->role == 'user') {
            return view('auth.profile',compact('user','countries'));
        }else{
            return view('admin.profile',compact('user','countries'));
        }
    }

    public function profile_update(Request $request){
        $user = User::where('id',$request->user_id)->first();
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles'), $filename);
            $user->profile_pic = $filename;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->street = $request->street;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->zip_code = $request->zip_code;
        $user->save();
        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function password_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|max:15|confirmed',
        ]);

        if ($validator->fails()) {
        $firstError = $validator->errors()->first();
        return back()->with('error', $firstError)->withInput();
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with(['error' => 'The Current Password Is Incorrect'])->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password Changed Successfully!');
    }

    public function availability(){
        $availabilities = DB::table('user_availabilities')->where('user_id',1)->get();
        return view('admin.availability',compact('availabilities'));
    }

public function store_availability(Request $req)
{
    $userTimezone = auth()->user()->timezone ?? 'UTC';

    // Parse raw inputs in user timezone (for validation)
    $punchInLocal  = $req->punch_in  ? \Carbon\Carbon::parse($req->punch_in, $userTimezone) : null;
    $punchOutLocal = $req->punch_out ? \Carbon\Carbon::parse($req->punch_out, $userTimezone) : null;
    $breakInLocal  = $req->break_in  ? \Carbon\Carbon::parse($req->break_in, $userTimezone) : null;
    $breakOutLocal = $req->break_out ? \Carbon\Carbon::parse($req->break_out, $userTimezone) : null;

    // Validation happens in local timezone
    if (($breakInLocal && !$punchInLocal) || ($breakOutLocal && !$punchOutLocal)) {
        return back()->with('error', 'Punch in and punch out times are required if break times are set.');
    }
    if ($punchInLocal && $punchOutLocal && $punchInLocal->gte($punchOutLocal)) {
        return back()->with('error', 'Punch in time must be earlier than punch out time.');
    }
    if ($breakInLocal && $breakOutLocal && $breakInLocal->gte($breakOutLocal)) {
        return back()->with('error', 'Break in time must be earlier than break out time.');
    }
    if ($breakInLocal && $punchInLocal && $breakInLocal->lt($punchInLocal)) {
        return back()->with('error', 'Break in time must be between punch in and punch out time.');
    }
    if ($breakOutLocal && $punchOutLocal && $breakOutLocal->gt($punchOutLocal)) {
        return back()->with('error', 'Break out time must be between punch in and punch out time.');
    }

    // Convert to UTC only after validation
    $convertToUtc = function($time) use ($userTimezone) {
        if (!$time) return null;
        if ($userTimezone === 'UTC') {
            return $time->format('H:i:s');
        }
        return $time->copy()->timezone('UTC')->format('H:i:s');
    };

    $punchIn  = $convertToUtc($punchInLocal);
    $punchOut = $convertToUtc($punchOutLocal);
    $breakIn  = $convertToUtc($breakInLocal);
    $breakOut = $convertToUtc($breakOutLocal);

    // Save in DB
    DB::table('user_availabilities')
        ->where('user_id', 1)
        ->where('day', $req->day)
        ->update([
            'punch_in'  => $punchIn,
            'punch_out' => $punchOut,
            'break_in'  => $breakIn,
            'break_out' => $breakOut,
        ]);

    return back()->with('success', 'Availability updated successfully');
}

    public function hours_breaks(){
        $hour_breaks = DB::table('hours_breaks')->where('user_id',1)->get();
        return view('admin.hours_breaks',compact('hour_breaks'));
    }

    public function store_hours_break(Request $req)
{
    $userTimezone = auth()->user()->timezone ?? 'UTC';

    // Parse inputs in user's timezone
    $fromLocal = $req->from_time ? \Carbon\Carbon::parse($req->from_time, $userTimezone) : null;
    $toLocal   = $req->to_time   ? \Carbon\Carbon::parse($req->to_time, $userTimezone)   : null;

    // Validation in local timezone
    if ($fromLocal && $toLocal && $fromLocal->gte($toLocal)) {
        return back()->with('error', 'From time must be earlier than to time.');
    }

    // Convert to UTC only after validation
    $convertToUtc = function ($time) use ($userTimezone) {
        if (!$time) return null;
        if ($userTimezone === 'UTC') {
            return $time->format('H:i:s');
        }
        return $time->copy()->timezone('UTC')->format('H:i:s');
    };

    $fromTimeUtc = $convertToUtc($fromLocal);
    $toTimeUtc   = $convertToUtc($toLocal);

    // Store break in UTC
    DB::table('hours_breaks')->insert([
        'user_id'   => 1,
        'date'      => $req->date, // consider also normalizing date to UTC if it's time-sensitive
        'from_time' => $fromTimeUtc,
        'to_time'   => $toTimeUtc,
    ]);

    return back()->with('success', 'Hours break added successfully.');
}

    public function delete_hours_break($id){
        $hours_break = DB::table('hours_breaks')->where('id',$id)->delete();
        return back()->with('success','Hours break deleted successfully');
    }

    public function days_breaks(){
        $days_breaks = DB::table('days_breaks')->where('user_id',1)->get();
        return view('admin.days_breaks',compact('days_breaks'));
    }

    public function store_days_break(Request $req){
        if ($req->from_date && $req->to_date && $req->from_date > $req->to_date) {
            return back()->with('error', 'From date must be earlier than to date.');
        }
        $days_break = DB::table('days_breaks')->insert([
            'user_id' => 1,
            'from_date' => $req->from_date,
            'to_date' => $req->to_date,
        ]);
        return back()->with('success','Days break added successfully.');
    }

    public function delete_days_break($id){
        $days_break = DB::table('days_breaks')->where('id',$id)->delete();
        return back()->with('success','Days break deleted successfully');
    }

    public function settings(){
        $durations = DB::table('durations')->where('user_id',1)->first();
        return view('admin.settings',compact('durations'));
    }

    public function store_settings(Request $req){
            DB::table('durations')->where('user_id', 1)->update([
                'fifteen_minutes' => $req->fifteen_minutes,
                'thiry_minutes' => $req->thiry_minutes,
                'fortyfive_minutes' => $req->fortyfive_minutes,
                'sixty_minutes' => $req->sixty_minutes,
                '15 minutes' => $req->fifteen_mints,
                '30 minutes' => $req->thirty_mints,
                '45 minutes' => $req->forty_five_mints,
                '60 minutes' => $req->sixty_mints,
                'available'  => $req->available,
                'online_booking'  => $req->online_booking,
                'face_to_face'  => $req->face_to_face,
                'updated_at' => now(),
            ]);
        return back()->with('success','Settings updated successfully');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function contact_us_msgs(){
        $type = 'Contact Us Message';
        $feedbacks = DB::table('feedbacks')->where('type','contact_us')->get();
        return view('admin.feedbacks',compact('feedbacks','type'));
    }

    public function queries(){
        $type = 'Querie';
        $feedbacks = DB::table('feedbacks')->where('type','query')->get();
        return view('admin.feedbacks',compact('feedbacks','type'));
    }

    public function delete_feedback($id){
        $feedback = DB::table('feedbacks')->where('id',$id)->delete();
        return back()->with('success', 'Message Deleted Successfully');
    }
}
