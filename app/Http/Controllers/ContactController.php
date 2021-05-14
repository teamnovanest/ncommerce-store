<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function contact(){
        return view('pages.contact');
    }

    public function contactForm(Request $request){
      
      try {
        $data = array();
  	    $data['name'] = $request->name;
  	    $data['email'] = $request->email;
  	    $data['phone'] = $request->phone;
  	    $data['message'] = $request->message;
  	    DB::table('contacts')->insert($data);
  	    $notification=array(
          'messege'=>'Message  Sent',
          'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification); 
      } catch (\Throwable $th) {
        if (app()->environment('production')){
             \Sentry\captureException($th);
             }
        $notification=array(
          'messege'=>'Something did not go right.Try again or contact for support',
          'alert-type'=>'error'
        );     
        return Redirect()->back()->with($notification);
      }
  	
  }
}
