<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Cart;
use Session;
use Mail;
use App\Mail\InvoiceMail;

class CheckoutController extends Controller
{
     public function checkout(Request $request){
     DB::begintransaction();
     try {
       //code...
       $content = Cart::content();
       $data = array();
       $data['user_id'] = Auth::id();
       $data['total'] = floatval(Cart::Subtotal()) * 100;
       $data['status_code'] = mt_rand(100000,999999);
       $data['order_code'] = rand();
       $data['status_id'] = 0;
       
       if (Session::has('coupon')) {
           $data['subtotal'] = Session::get('coupon')['balance'];
        }else{
            $data['subtotal'] = floatval(Cart::Subtotal()) * 100;
        }
        $data['status'] = 'ORDER PENDING';
        $data['date'] = date('d-m-y');
        $data['month'] = date('F');
        $data['year'] = date('Y');
        $data['created_at'] = \Carbon\Carbon::now();
        foreach ($content as $item) {
          $data['merchant_organization_id'] = $item->options->merchant_organization_id;
        }
        
    $order_id = DB::table('orders')->insertGetId($data);

   //TO DO FIX ISSUE WITH MAIL SEND
    // Mail send to user for Invoice
  //   $email = Auth::user()->email;
  //  Mail::to($email)->send(new invoiceMail($data));

    // Insert Order Details Table
       
    $details = array();
    foreach ($content as $row) {
    $details['order_id'] = $order_id;
    $details['product_id'] = $row->id;
    $details['product_name'] = $row->name;
    $details['color'] = $row->options->color;
    $details['size'] = $row->options->size;
    $details['quantity'] = $row->qty;
    $details['singleprice'] = $row->price;
    $details['totalprice'] = $row->qty*$row->price;
    $details['merchant_organization_id'] = $row->options->merchant_organization_id;
    $data['created_at'] = \Carbon\Carbon::now();
    DB::table('order_details')->insert($details); 

    }

    $status = array();
    foreach ($content as $row) {
      $status['user_id'] = Auth::id();
      $status['order_id'] = $order_id;
      $status['status_id'] = 0;
      $status['merchant_organization_id'] = $row->options->merchant_organization_id;
      $status['updated_by'] = Auth::id();
      $status['created_at'] = \Carbon\Carbon::now();
      DB::table('order_status_histories')->insert($status);
    }

    Cart::destroy();
    if (Session::has('coupon')) {
    	Session::forget('coupon');
    }
    DB::commit();
    $notification=array(
                        'messege'=>'Order Processed Successfully',
                        'alert-type'=>'success'
                         );
                       return Redirect()->to('/dashboard')->with($notification);
  
       } catch (\Throwable $th) {
         DB::rollback();
         throw $th;
       }
      
  }
}
