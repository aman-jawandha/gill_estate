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
        if(Auth::user()->role == 'seller'){
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
        if(Auth::user()->role == 'seller' || Auth::user()->role == 'buyer') {
            return view('auth.profile',compact('user'));
        }else{
            return view('admin.profile',compact('user'));
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
