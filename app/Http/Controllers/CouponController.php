<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class CouponController extends Controller
{
    public function floatvalue($val){
            $val = str_replace(",",".",$val);
            $val = preg_replace('/\.(?=.*\.)/', '', $val);
            return floatval($val);
    }

  public function coupon(Request $request)
  {
    try {
    $coupon = $request->coupon;
    $check = DB::table('coupons')->where('coupon_name', $coupon)->first(); //first

    $content = Cart::content();
  
    if ($check) {
      
      foreach($content as $row){
         if ($row->options->merchant_organization_id === $check->merchant_organization_id) {
            $percentage_price = intval($check->discount / 100 * $this->floatvalue(Cart::Subtotal()));
            Session::put('coupon', [
                'name' => $check->coupon_name,
                'discount' => $check->discount,
                'balance' =>   intval($this->floatvalue(Cart::Subtotal()) - $percentage_price)
              ]);
              $notification = array(
                'messege' => 'Successfully Coupon Applied',
                'alert-type' => 'success'
              );
              return Redirect()->back()->with($notification);
           } 
           else {
                $notification = array(
                'messege' => 'Coupon code do not match this Product(s) . Try a different \nproduct or contact support if issue still persist',
                'alert-type' => 'error'
              );
              return Redirect()->back()->with($notification);
             }
          }
    } else {
      $notification = array(
        'messege' => 'Invalid Coupon',
        'alert-type' => 'error'
      );
      return Redirect()->back()->with($notification);
    }
    } catch (\Throwable $th) {
      DB::rollback();
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

   public function couponRemove(){
 	Session::forget('coupon');
 	$notification=array(
        'messege'=>'Coupon remove Successfully',
        'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);

 }
}
