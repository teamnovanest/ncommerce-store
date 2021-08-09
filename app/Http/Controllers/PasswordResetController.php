<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function changePassword(){
    try {
        return view('auth.change_password');
    } catch (\Throwable $th) {
        if (app()->environment('production')){
          \Sentry\captureException($th);
        }
      
       $notification=array(
        'messege'=>'An error occured. Try again or contact support if issue still persist',
        'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
    }
    }

    public function resetPassword(Request $request)
    {
    try {
      $password=Auth::user()->password;
    $oldpass=$request->oldpass;
    $newpass=$request->password;
    $confirm=$request->password_confirmation;
    if (Hash::check($oldpass,$password)) {
    if ($newpass === $confirm) {
    $user=User::find(Auth::id());
    $user->password=Hash::make($request->password);
    $user->save();
    Auth::logout();
    $notification=array(
    'messege'=>'Password Changed Successfully ! Now Login with Your New Password',
    'alert-type'=>'success'
    );
    return Redirect()->route('login')->with($notification);
    }else{
    $notification=array(
    'messege'=>'New password and Confirm Password does not match!',
    'alert-type'=>'error'
    );
    return Redirect()->back()->with($notification);
    }
    }else{
    $notification=array(
    'messege'=>'Old Password does not match!',
    'alert-type'=>'error'
    );
    return Redirect()->back()->with($notification);
    }
  
    } catch (\Throwable $th) {
        if (app()->environment('production')){
          \Sentry\captureException($th);
        }
      
       $notification=array(
        'messege'=>'An error occured while resetting password. Try again or contact support if issue still persist',
        'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
    }
    
    }
}
