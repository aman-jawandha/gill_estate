<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\UserBooking;
use App\Models\User;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function my_appointments(){
        $appointments = UserBooking::where('user_id',auth()->user()->id)->orderBy('id','DESC')->paginate(12);
        return view('bookings.my_appointments',compact('appointments'));
    }

    public function my_bookings(){
        $bookings = UserBooking::orderBy('id','DESC')->get();
        return view('admin.my_bookings',compact('bookings'));
    }

    public function reschedule_apoointment($id){
        $booking = UserBooking::where('id',$id)->first();
        $durations = DB::table('durations')->where('user_id',1)->first();
        return view('admin.reschedule_booking',compact('booking','durations'));
    }

    public function store_rescheduled_apoointment(Request $req){
        $booking = UserBooking::where('id',$req->booking_id)->first();

        $userTz = getUserTimezone();
        $startTimeLocal = Carbon::parse($req->booking_date.' '.$req->booking_time, $userTz);
        $startTimeUtc = $startTimeLocal->copy()->setTimezone('UTC');
        $minutes = match ($booking->duration) {
            '15 minutes' => 15,
            '30 minutes' => 30,
            '45 minutes' => 45,
            '60 minutes' => 60,
            default => 15,
        };
        $endTimeUtc   = $startTimeUtc->copy()->addMinutes($minutes);

        $booking->booking_date = $startTimeUtc->format('Y-m-d');
        $booking->booking_time = $startTimeUtc->format('H:i:s');
        $booking->end_time = $endTimeUtc->format('H:i:s');
        $booking->status = 'Rescheduled';
        $booking->save();

        $details = [
        'title' => 'Appointment Rescheduled',
        'body'  => "Hello {$booking->user->name},<br><br>
            Your appointment is rescheduled to {$startTimeLocal->format('M d, Y')} at {$startTimeLocal->format('h:i A')}.
            If this time does not work for you, please contact us as soon as possible.<br><br>
            Thank you for your understanding and patience.<br><br>",
        ];

        Mail::to($booking->user->email)->send(new SendMail($details, 'Rescheduled an appointment'));
        return back()->with('success','Appointment Rescheduled Successfully');
    }

    public function change_role($role){
        $user = User::where('id',auth()->user()->id)->first();
        $user->assignRole($role);
        $user->role = $role;
        $user->save();
        return back()->with('success','Role changed successfully');
    }
}
