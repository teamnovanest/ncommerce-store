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

    if ($check && $check->start_date <= date('Y-m-d') && $check->end_date >= date('Y-m-d')) {
      
      $total = [];
      foreach ($content as $row) {
         if ($row->options->merchant_organization_id === $check->merchant_organization_id) {
           $percentage_price = floatval($check->discount / 100 * $row->price * $row->qty);
           array_push($total,$percentage_price);
         }
      }
      
        if (!empty($total)) {
             Session::put('coupon', [
              'name' => $check->coupon_name,
              'discount' => $check->discount,
              'balance' =>   floatval($this->floatvalue(Cart::Subtotal()) - array_sum($total)),
              'percentage_price' => array_sum($total)
            ]);
              $notification = array(
                'messege' => 'Coupon applied successfully',
                'alert-type' => 'success'
              );
              return Redirect()->back()->with($notification);
        } else {
              $notification = array(
                'messege' => 'Coupon application failed,\n Try products from the vendor the coupon belongs to.',
                'alert-type' => 'error'
              );
              return Redirect()->back()->with($notification);
        }
    
      // foreach($content as $row){
      //    if ($row->options->merchant_organization_id === $check->merchant_organization_id) {
      //       // array_push($cart_total,$row->price);
      //       $percentage_price = intval($check->discount / 100 * $row->price * $row->qty);
      //         Session::put('coupon', [
      //           'name' => $check->coupon_name,
      //           'discount' => $check->discount,
      //           'balance' =>   intval($this->floatvalue(Cart::Subtotal()) - $percentage_price),
      //           'percentage_price' => $percentage_price
      //         ]);
               
      //      } 
      //      else {
      //           $notification = array(
      //           'messege' => 'Coupon application failed,\n Try products from the vendor the coupon belongs to.',
      //           'alert-type' => 'error'
      //         );
      //         return Redirect()->back()->with($notification);
      //        }
      //      }
 
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
        'messege'=>'Coupon removed Successfully',
        'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);

 }
}
