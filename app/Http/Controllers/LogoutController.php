<?php

namespace App\Http\Controllers;

use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function Logout()
    {
        try {
          Auth::logout();
        Cart::destroy();
        $notification=array(
        'messege'=>'Successfully Logout',
        'alert-type'=>'success'
        );
        return Redirect()->route('login')->with($notification);  
        } catch (\Throwable $th) {
             if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while Loging out. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
        }
        
    }
}
