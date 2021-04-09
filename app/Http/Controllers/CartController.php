<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Cart;
use Session;
use Response;
use Illuminate\Http\Request;
use App\Models\LenderOffering;

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
    $credit_offers = DB::table('customer_finance_organization_affiliations')
    ->join('users','customer_finance_organization_affiliations.user_id','=','users.id')
    ->join('lenders','customer_finance_organization_affiliations.lender_organization_id','=','lenders.id')
    ->join('lender_offerings','lender_offerings.lender_organization_id','=','lenders.id')
    ->select('lenders.id as lender_organization_gId','lender_offerings.id','lenders.registered_name','lenders.trade_name','lender_offerings.payment_period','lender_offerings.percentage')
    ->orderBy('percentage', 'ASC')
    ->where('customer_finance_organization_affiliations.user_id',Auth::id())->get();
    
  	$cart = Cart::content();
  
    return view('pages.checkout',compact('cart','credit_offers'));

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
