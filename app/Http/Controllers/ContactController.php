<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact(){
        return view('pages.contact');
    }


      public function contactForm(Request $request){

  	$data = array();
  	$data['name'] = $request->name;
  	$data['email'] = $request->email;
  	$data['phone'] = $request->phone;
  	$data['message'] = $request->message;
  	DB::table('contact')->insert($data);
  	$notification=array(
            'messege'=>'Message  Sent',
            'alert-type'=>'success'
             );
           return Redirect()->back()->with($notification); 
  }
}
