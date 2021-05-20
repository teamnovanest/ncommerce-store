<?php

namespace App\Http\Controllers;

use Auth;
use Cart;
use Mail;
use Session;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
  public function floatvalue($val){
            $val = str_replace(",",".",$val);
            $val = preg_replace('/\.(?=.*\.)/', '', $val);
            return floatval($val);
}

  public function checkout(Request $request)
  {
    
    $selectedOfferId = $request->selectedOfferId;
    #select the payment period and percentag from the lender offering table
    $lenderOffering = DB::table('lender_offerings')->select('payment_period', 'percentage', 'max_financed', 'lender_organization_id')->where('id', $selectedOfferId)->first();
    // $rate = $lenderOffering->percentage;
    // $time = $lenderOffering->payment_period;
   
    DB::begintransaction();
    try {
        // throw new \Exception();
      $content = Cart::content();

       //info: Removing product in wishlist when a customer finally purchase a product
      foreach ($content as $row) {
        $wishlistedProduct = DB::table('wishlists')
          ->where('wishlists.user_id', Auth::user()->id)
          ->where('wishlists.product_id', $row->id)
          ->first();
        if ($wishlistedProduct !== NULL) {
          DB::table('wishlists')->where('wishlists.product_id', $row->id)->delete();
        }
      }
      
      $data = array();
      $data['user_id'] = Auth::id();
      $data['status_code'] = crc32(uniqid()); 
      $data['order_code'] = crc32(time());
      if (Session::has('coupon')) {
        $data['subtotal'] = Session::get('coupon')['balance'] * 100;
        $data['total'] = Session::get('coupon')['balance'] * 100;
      } else {
          $data['subtotal'] = intval($this->floatvalue(Cart::Subtotal()) * 100);
          $data['total'] = intval($this->floatvalue(Cart::Subtotal()) * 100);
      } 
      $data['created_at'] = now();
      $data['total'] = intval($this->floatvalue(Cart::Subtotal()) * 100);
      // $data['total_financed'] = (intval($this->floatvalue(Cart::Subtotal()) * $rate /12 * $time /100) + intval($this->floatvalue(Cart::Subtotal())) * 100) ;
      // dd($data);
      $order_id = DB::table('orders')->insertGetId($data);

      // Insert Order Details Table
      $details = array();
      foreach ($content as $row) {
        $details['order_id'] = $order_id;
        $details['product_id'] = $row->id;
        $details['product_name'] = $row->name;
        $details['status_id'] = 1;
        $details['status'] = 'ORDER_PENDING';
        $details['color'] = $row->options->color;
        $details['size'] = $row->options->size;
        $details['quantity'] = $row->qty;
        $details['singleprice'] = floatval($row->price) * 100;
        $details['totalprice'] = floatval($row->price) * $row->qty * 100;
        $details['merchant_organization_id'] = $row->options->merchant_organization_id;
        $details['lender_organization_id'] = $lenderOffering->lender_organization_id;
        $details['created_at'] = now();
        DB::table('order_details')->insert($details);
      }

      $status = array();
      foreach ($content as $row) {
        $status['user_id'] = Auth::id();
        $status['order_id'] = $order_id;
        $status['status_id'] = 1;
        $status['product_id'] = $row->id;
        $status['merchant_organization_id'] = $row->options->merchant_organization_id;
        $status['lender_organization_id'] = $lenderOffering->lender_organization_id;
        $status['updated_by'] = Auth::id();
        $status['created_at'] = now();
      DB::table('order_status_histories')->insert($status);
      }

      #inserting into the order financing table with the offer the user selected
      $offerdetail = array();
      $offerdetail['user_id'] = Auth::id();
      $offerdetail['order_id'] = $order_id;
      $offerdetail['percentage'] = $lenderOffering->percentage;
      $offerdetail['payment_period'] = $lenderOffering->payment_period;
      $offerdetail['lender_organization_id'] = $lenderOffering->lender_organization_id;
      $offerdetail['created_at'] = now();
      DB::table('order_financings')->insert($offerdetail);

      Cart::destroy();
      if (Session::has('coupon')) {
        Session::forget('coupon');
      }
      DB::commit();

      return response()->json(['message' => 'You have successfully placed your order']);
    } catch (\Throwable $th) {
      DB::rollback();
         if (app()->environment('production')){
            \Sentry\captureException($th);
        }
      // $resData['message'] = $th->getMessage();
      $resData['message'] = "Something didn't go right. Our engineers have been notified \nabout the issue and will look into it. If the issue persists contact support";
      return response()->json($resData, 500);
    }
  }
}
