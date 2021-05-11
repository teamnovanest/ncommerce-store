<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    
  public function coupon(Request $request)
  {
    $coupon = $request->coupon;
    
    $check = DB::table('coupons')->where('coupon_name', $coupon)->first();
    
    if ($check) {
      Session::put('coupon', [
        'name' => $check->coupon_name,
        'discount' => $check->discount,
        'balance' => Cart::Subtotal() - $check->discount
      ]);
      $notification = array(
        'messege' => 'Successfully Coupon Applied',
        'alert-type' => 'success'
      );
      return Redirect()->back()->with($notification);
    } else {
      $notification = array(
        'messege' => 'Invalid Coupon',
        'alert-type' => 'error'
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
