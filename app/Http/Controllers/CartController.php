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

   $product = DB::table('products')->where('id',$id)->first();

   $data = array();

   if ($product->discount_price == NULL) {
   $data['id'] = $product->id;
   $data['name'] = $product->product_name;
   $data['qty'] = 1;
   $data['price'] = $product->selling_price / 100;
   $data['weight'] = 1;
   $data['options']['image'] = $product->image_one_secure_url;
   $data['options']['color'] = '';
   $data['options']['size'] = '';
   $data['options']['merchant_organization_id'] = $product->merchant_organization_id;
   Cart::add($data);
   return \Response::json(['success' => 'Successfully Added To Cart']);
   }else{

   $data['id'] = $product->id;
   $data['name'] = $product->product_name;
   $data['qty'] = 1;
   $data['price'] = $product->discount_price / 100;
   $data['weight'] = 1;
   $data['options']['image'] = $product->image_one_secure_url;
   $data['options']['color'] = '';
   $data['options']['size'] = '';
   $data['options']['merchant_organization_id'] = $product->merchant_organization_id;
   Cart::add($data);
   return \Response::json(['success' => 'Successfully Added To Cart']);

   }

   }

    public function search(Request $request){
      $item = $request->search;
      $products = DB::table('products')
        ->where('product_name','LIKE',"%$item%")
        ->paginate(20);

    return view('pages.search',compact('products'));  
    }
  

  public function showCart()
  {
    $cart = Cart::content();
    //dd($cart);
    // Credit offers 
    $credit_offers = LenderOffering::with(['lender'])
      ->where('lender_organization_id', '=', Auth::user()->lender_organization_id)
      ->orderBy('percentage', 'ASC')->get();

    //$product = Product::whereId($id)->first();

    return view('pages.cart', compact('credit_offers', 'cart'));
  }


  public function checkout()
  {
    if (Auth::check()) {
      $credit_offers = DB::table('customer_finance_organization_affiliations')
        ->join('users', 'customer_finance_organization_affiliations.user_id', '=', 'users.id')
        ->join('lenders', 'customer_finance_organization_affiliations.lender_organization_id', '=', 'lenders.id')
        ->join('lender_offerings', 'lender_offerings.lender_organization_id', '=', 'lenders.id')
        ->select('lenders.id as lender_organization_id', 'lender_offerings.id', 'lenders.registered_name', 'lenders.trade_name', 'lender_offerings.payment_period', 'lender_offerings.percentage', 'lender_offerings.max_financed')
        ->orderBy('percentage', 'ASC')
        ->where('customer_finance_organization_affiliations.user_id', Auth::id())->get();

      $cart = Cart::content();

      return view('pages.checkout', compact('cart', 'credit_offers'));
    } else {
      $notification = array(
        'messege' => 'At first Login Your Account',
        'alert-type' => 'success'
      );
      return Redirect()->route('login')->with($notification);
    }
  }

  public function removeCart($rowId)
  {
    Cart::remove($rowId);
    $notification = array(
      'messege' => 'Product Remove from Cart',
      'alert-type' => 'success'
    );
    return Redirect()->back()->with($notification);
  }


  public function updateCart(Request $request)
  {
    $rowId = $request->productid;
    $qty = $request->qty;
    Cart::update($rowId, $qty);
    $notification = array(
      'messege' => 'Product Quantity Updated',
      'alert-type' => 'success'
    );
    return Redirect()->back()->with($notification);
  }
}
