<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\SendMail;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthController extends Controller
{
    public function login_form(){
        return view('auth.login');
    }

    public function register_form(){
        return view('auth.register');
    }

    public function login(Request $request){
        if(!$request->email){
            return back()->with(['error' => 'Email is required!'])->withInput();
        }
        if(!$request->password){
            return back()->with(['error' => 'Password is required!'])->withInput();
        }
        $exists = User::where('email',$request->email)->first();
        if(!$exists){
            return back()->with(['error' => 'Email does not exist!'])->withInput();
        }
        if($exists->status == 'Inactive'){
            return back()->with(['error' => 'Your account has been deactivated. Please connect with admin for more information.'])->withInput();
        }
        if (!Hash::check($request->password, $exists->password)) {
        return back()->with('error', 'Invalid credentials.')->withInput();
        }

        $login = Auth::login($exists);

    if (Auth::user()->id) {
        return redirect()->route('dashboard');
    }
        return back()->withErrors(['error' => 'Something went wrong! Please try again later.'])->withInput();
    }

    public function register(Request $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if($request->role == 'seller'){
            $user->assignRole('seller');
        }elseif($request->role == 'buyer'){
            $user->assignRole('buyer');
        }
        

        $details = [
        'title' => 'Welcome To Gill Estate',
        'body' => "Hello $request->name,<br><br>
        Thanks For Joining Us, We're excited to have you join our community!<br><br>
        You can now log in and check your activity using the following credentials:<br><br>
        <strong>Username:</strong> $request->email<br>
        <strong>Password:</strong> $request->password<br><br>
        <a href='" . url('/login') . "'>Click here to log in</a><br><br>",
        ];

        $subject = 'Welcome to Gill Estate';

        // Mail::to($request->email)->send(new SendMail($details, $subject));

        return redirect()->route('login');
    }

    public function forgot_pswd(){
        return view('auth.forgot_password');
    }

    public function send_reset_pswd_mail(Request $request){
         if(!$request->email){
            return back()->with(['error' => 'Email is required!'])->withInput();
        }
        $user = User::where('email',$request->email)->first();
        if(!$user){
            return back()->with(['error' => 'Email not found in database!'])->withInput();
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        $resetLink = url('/reset-password/' . $token);

        $details = [
        'title' => 'Let’s get you back into your account',
        'body' => "Hello $user->name,<br><br>
        Click the link below to reset your password:<br><br>
        <a href='" . url('/reset-password/'.$token) . "'>$resetLink</a><br><br>
        This link will expire in 60 minutes.<br><br>",
        ];

        $subject = 'Reset Password Link';

        Mail::to($request->email)->send(new SendMail($details, $subject));

        return back()->with('success','Reset Password Link sent to your provided email');
    }

    public function reset_pswd_form($token)
    {
        return view('auth.reset_password', ['token' => $token]);
    }

    public function reset_pswd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|min:8|max:30',
            'new_password' => 'required|min:8|max:20|confirmed',
        ]);

        if ($validator->fails()) {
        $firstError = $validator->errors()->first();
        return back()->with('error', $firstError)->withInput();
        }

        $user = User::where('email',$request->email)->first();
        if(!$user){
            return back()->with(['error' => 'Email does not exist!'])->withInput();
        }

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();
        
        if(!$record){
            return back()->with(['error' => 'No link requested for this email!'])->withInput();
        }

        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return back()->with(['error' => 'Invalid or expired token.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        
        return redirect()->back()->with('success', 'Password has been reset!');
    }

    public function check_email(Request $request)
    {
        $email = $request->input('email');
        $query = User::where('email', $email);
        if ($request->has('user_id')) {
            $query->where('id', '!=', $request->input('user_id'));
        }
        $emailExists = $query->exists();
        return response()->json(!$emailExists);
    }
}
