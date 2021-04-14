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
        Auth::logout();
        Cart::destroy();
        $notification=array(
        'messege'=>'Successfully Logout',
        'alert-type'=>'success'
        );
        return Redirect()->route('login')->with($notification);
    }
}
