<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\User;

class UserController extends Controller
{
    public function staff(){
        $users = User::where('role','!=','admin')->where('role','!=','buyer')->where('role','!=','seller')->get();
        return view('admin.users.staff',compact('users'));
    }

    public function sellers(){
        $users = User::where('role','seller')->get();
        return view('admin.users.sellers',compact('users'));
    }

    public function buyers(){
        $users = User::where('role','buyer')->get();
        return view('admin.users.buyers',compact('users'));
    }

    public function create(){
        $roles = Role::where('name','!=','admin')->where('name','!=','seller')->where('name','!=','buyer')->get();
        return view('admin.users.create',compact('roles'));
    }

    public function store(Request $req){
        $ran_string = Str::random(8);
        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'role' => $req->role,
            'status' => $req->status,
            'password' => Hash::make($ran_string),
            'created_by' => auth()->id(),
        ]);
        $user->assignRole($req->role);
        $details = [
        'title' => 'Welcome to the Gill Estate',
        'body' => "Hello $req->name,<br><br>
        Your account has been created for the $req->role role.<br><br>
        You can now log in and check your activity using the following credentials:<br><br>
        <strong>Username:</strong> $req->email<br>
        <strong>Password:</strong> $ran_string<br><br>
        Please log in and update your profile and password for security purposes.<br><br>
        <a href='" . url('/login') . "'>Click here to log in</a><br><br>",
        ];

        $subject = 'Welcome To Gill Estate';

        Mail::to($req->email)->send(new SendMail($details, $subject));
        return redirect()->route('staff')->with('success','User created successfully.');
    }

    public function edit($id){
        $user = User::where('id',$id)->first();
        $roles = Role::where('name','!=','admin')->where('name','!=','seller')->where('name','!=','buyer')->get();
        return view('admin.users.update',compact('user','roles'));
    }

    public function update(Request $req){
        $user = User::where('id',$req->user_id)->first();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->role = $req->role;
        $user->status = $req->status;
        $user->save();
        $user->syncRoles($req->role);
        return redirect()->route('staff')->with('success','User updated successfully.');
    }

    public function delete($id){
        $user = User::where('id',$id)->delete();
        return redirect()->route('staff')->with('success','User deleted successfully.');
    }

    public function delete_buyer($id){
        $user = User::where('id',$id)->first();
        if($user->status == 'Active'){
            $user->status = 'Inactive';
        }else{
            $user->status = 'Active';
        }
        $user->save();
        return redirect()->route('buyers')->with('success','Status changed successfully.');
    }

    public function delete_seller($id){
        $user = User::where('id',$id)->first();
        if($user->status == 'Active'){
            $user->status = 'Inactive';
        }else{
            $user->status = 'Active';
        }
        $user->save();
        return redirect()->route('sellers')->with('success','Status changed successfully.');
    }
}
