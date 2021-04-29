<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsletterController extends Controller
{
    public function storeNewsLetter(Request $request)
    {
        $email = $request->input('email');
        $checks = DB::table('newsletters')->where('email', $email)->first();

        $data = array();
        $data ['email'] = $email;
        if ($checks) {
        $notification=array(
                'messege'=>'Email already exist',
                'alert-type'=>'error'
                );
            return Redirect()->back()->with($notification);
        } else {
            DB::table('newsletters')->insert($data);
            $notification=array(
            'messege'=>'Thanks for Subscribing',
            'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification); 	
        }
    
    }
}
