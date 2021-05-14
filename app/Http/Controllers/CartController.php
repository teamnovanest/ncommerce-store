<?php

namespace App\Http\Controllers;


use Auth;
use Session;
use Response;
use Cart;
use Illuminate\Http\Request;
use App\Models\LenderOffering;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
   public function AddCart($id){

      try {
        // throw new Exception();
        $product = DB::table('products')->where('id',$id)->first();

        $data = array();
     
        $data['id'] = $product->id;
        $data['name'] = $product->product_name;
        $data['qty'] = 1;
        $data['price'] = (!$product->discount_price) ? $product->selling_price / 100 :
        ($product->selling_price - $product->discount_price) /100;
        $data['weight'] = 1;
        $data['options']['image'] = $product->image_one_secure_url;
        $data['options']['color'] = '';
        $data['options']['size'] = '';
        $data['options']['merchant_organization_id'] = $product->merchant_organization_id;
        Cart::add($data);
        return \Response::json(['success' => 'Successfully Added To Cart']);
     
      } catch (\Throwable $th) {
        if (app()->environment('production')){
          \Sentry\captureException($th);
        }
       
        // TODO Send response to user there was an error
      
         return \Response::json(['error' => 'Item was not added. Try again or contact support if issue still persist'],500);
      }
   }
  

  public function showCart()
  {
    try { 
      $cart = Cart::content();
      return view('pages.cart', compact('cart'));
    } catch (\Throwable $th) {
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


  // public function checkout()
  // {
  //   if (Auth::check()) {
  //     $credit_offers = DB::table('customer_finance_organization_affiliations')
  //       ->join('users', 'customer_finance_organization_affiliations.user_id', '=', 'users.id')
  //       ->join('lenders', 'customer_finance_organization_affiliations.lender_organization_id', '=', 'lenders.id')
  //       ->join('lender_offerings', 'lender_offerings.lender_organization_id', '=', 'lenders.id')
  //       ->select('lenders.id as lender_organization_id', 'lender_offerings.id', 'lenders.registered_name', 'lenders.trade_name', 'lender_offerings.payment_period', 'lender_offerings.percentage', 'lender_offerings.max_financed')
  //       ->orderBy('percentage', 'ASC')
  //       ->where('customer_finance_organization_affiliations.user_id', Auth::id())->get();

  //     $amount = DB::table('lender_offerings')
  //     ->select('max_financed')
  //     ->where('lender_offerings.lender_organization_id', Auth::user()->lender_organization_id)
  //     ->first();
  //     // dd($max_financed);
     
  //     $cart = Cart::content();
  //     return view('pages.checkout', compact('cart','credit_offers', 'amount'));
  //   } else {
  //     $notification = array(
  //       'messege' => 'At first Login Your Account',
  //       'alert-type' => 'success'
  //     );
  //     return Redirect()->route('login')->with($notification);
  //   }
  // }

  public function removeCart($rowId)
  {
    try {      
      Cart::remove($rowId);
      $notification = array(
      'messege' => 'Product removed from cart',
      'alert-type' => 'success'
    );
    return Redirect()->back()->with($notification);
    } catch (\Throwable $th) {
      if (app()->environment('production')){
          \Sentry\captureException($th);
        }

    $notification = array(
      'messege' => 'An error occured while removing item from your cart.',
      'alert-type' => 'error'
    );
    return Redirect()->back()->with($notification);
    }
    
  }


  public function updateCart(Request $request)
  {
    try {
    $rowId = $request->productid;
    $qty = $request->qty;
    Cart::update($rowId, $qty);
    $notification = array(
      'messege' => 'Product quantity updated',
      'alert-type' => 'success'
    );
    return Redirect()->back()->with($notification); 
    } catch (\Throwable $th) {
      if (app()->environment('production')){
          \Sentry\captureException($th);
        }
        
      $notification = array(
      'messege' => 'An error occured while updating your Product quantity',
      'alert-type' => 'error'
    );
    return Redirect()->back()->with($notification); 
    }
    
  }
}
