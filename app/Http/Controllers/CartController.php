<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use Response;
use Auth;
use Session;

class CartController extends Controller
{
    public function search(Request $request){
      $item = $request->search;
      $products = DB::table('products')
        ->where('product_name','LIKE',"%$item%")
        ->paginate(20);

    return view('pages.search',compact('products'));  
    }


    public function showCart(){
        $cart = Cart::content();
    	  return view('pages.cart',compact('cart'));
    }


    public function checkout(){
         if (Auth::check()) {

  	$cart = Cart::content();
    	return view('pages.checkout',compact('cart'));

  }else{
  	$notification=array(
        'messege'=>'At first Login Your Account',
        'alert-type'=>'success'
            );
        return Redirect()->route('login')->with($notification);
  } 
    }



     public function coupon(Request $request){
   	$coupon = $request->coupon;

    $check = DB::table('coupons')->where('coupon',$coupon)->first();
    if ($check) {
    Session::put('coupon',[
    'name' => $check->coupon,
    'discount' => $check->discount,
    'balance' => Cart::Subtotal()-$check->discount 
    ]);
    	$notification=array(
                        'messege'=>'Successfully Coupon Applied',
                        'alert-type'=>'success'
                         );
                       return Redirect()->back()->with($notification);


    }else{
    	$notification=array(
                        'messege'=>'Invalid Coupon',
                        'alert-type'=>'success'
                         );
                       return Redirect()->back()->with($notification);
    }

   }


   public function removeCart($rowId){
     Cart::remove($rowId);
    	$notification=array(
                        'messege'=>'Product Remove from Cart',
                        'alert-type'=>'success'
                         );
                       return Redirect()->back()->with($notification);
   }
}
