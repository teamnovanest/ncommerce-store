<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  verify paystack payment done on the client side as recomended in the docs
     */
    public function verify($transactionref){
       
    // TODO:
    // Insert order & customer details in to tables
    // product and quantity orderd is nin the metadata
    // user product id to find the merchant id
    // check if the sum of the items purchased is the same as the amount paid before accepting order and redirecting the user
    // check also the test or prod env 

        $url = "https://api.paystack.co/transaction/verify/" . $transactionref;
         $res = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYMENT_SECRET_KEY'),
        ])->get($url); 
    
        if($res->failed()){
           return  $res->failed();
        }else{
            return $res->json();
        }

    
       
    }
}
