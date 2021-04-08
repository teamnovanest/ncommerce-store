<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Cart;
use Session;
use Response;
use Illuminate\Http\Request;

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
    $lender_organizations = DB::table('customer_finance_organization_affiliations')
    ->join('users','customer_finance_organization_affiliations.user_id','=','users.id')
    ->join('lenders','customer_finance_organization_affiliations.lender_organization_id','=','lenders.id')
    ->select('lenders.id','lenders.registered_name','lenders.trade_name')
    ->where('customer_finance_organization_affiliations.user_id',Auth::id())->get();

    $payment_periods = DB::table('lender_offerings')
    ->where('lender_organization_id',$lender_organizations[0]->id)
    ->distinct()
    ->orderBy('Payment_period','ASC')
    ->get('Payment_period');

    $percentages = DB::table('lender_offerings')
    ->where('lender_organization_id',$lender_organizations[0]->id)
    ->distinct()
    ->orderBy('percentage','ASC')
    ->get('percentage');

    
  	$cart = Cart::content();
    	return view('pages.checkout',compact('cart','lender_organizations','payment_periods','percentages'));

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
