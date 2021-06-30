<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Gloudemans\Shoppingcart\Facades\Cart;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sendOrderConfirmationEmail($orderId){
        // info: Generating information to send order confirmation
      $order_summary = DB::table('orders')
      ->join('users', 'orders.user_id', '=', 'users.id')
      ->select('orders.id AS oid','order_code','subtotal','total','name','email','total_financed','orders.created_at as created_at')
      ->where('orders.id', $orderId)
      ->where('orders.user_id', Auth::user()->id)
      ->first();

      $order_details = DB::table('order_details')
      ->join('products', 'order_details.product_id', '=', 'products.id')
      ->select('image_one_secure_url','products.product_name as product','quantity','totalprice')
      ->where('order_id', $orderId)
      ->get();

      $order_financing = DB::table('order_financings')
      ->select('payment_period','percentage')
      ->where('order_id',$orderId)
      ->where('user_id',Auth::user()->id)
      ->first();

      $url = URL::to('/dashboard');

      $results = Mail::to($order_summary->email)->send(new OrderConfirmation($order_summary,$order_details,$order_financing,$url));
      return $results;
    }

    /**
     *  verify paystack payment done on the client side as recomended in the docs
     */
    public function verify($transactionref){
    // TODO:
    // Insert order & customer details in to tables
    // product and quantity orderd is nin the metadata
    // user product id to find the merchant id
    // check if the sum of the items purchased is the same as the amount paid before accepting order and redirecting the user
    // check also the test or prod env

        $url = "https://api.paystack.co/transaction/verify/" . $transactionref;
        $res = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYMENT_SECRET_KEY'),
        ])->get($url); 
    
        if($res->failed()){
           return  $res->failed();
        }else{
            $res_data = $res->json();
                        $totalamount = [];
                        foreach ($res_data['data']['metadata']['order'] as  $value) {
                           array_push($totalamount,$value['totalprice']);
                        }
                        $sum_of_totalprices_in_order = array_sum($totalamount) * 100;

                if ($res_data['data']['domain'] === env('APP_STATE')  && $res_data['data']['amount'] === $sum_of_totalprices_in_order) {
                    try {
                        DB::beginTransaction();
                        // insert into orders table
                        $orderId = DB::table('orders')->insertGetId([
                            'user_id' => $res_data['data']['metadata']['customerId'],
                            'order_code' => crc32(time()),
                            'subtotal' => $res_data['data']['amount'],
                            'total' => $res_data['data']['amount'],
                            'status_code' => crc32(uniqid()),
                            'created_at' => now(),
                        ]);
        
                        //insert into order details table
                        foreach ($res_data['data']['metadata']['order'] as  $value) {
                            DB::table('order_details')->insert([
                                'order_id' => $orderId,
                                'product_id' => $value['product_id'],
                                'status_id' => 1,
                                'status' => 'ORDER_PENDING',
                                'merchant_organization_id' => $value['merchant_id'],
                                'product_name' => $value['product_name'],
                                'color' => $value['color'],
                                'size' => $value['size'],
                                'quantity' => $value['quantity'],
                                'singleprice' => floatval($value['price']) * 100,
                                'totalprice' => floatval($value['totalprice']) * 100,
                                'created_at' => now(),
                            ]);
                        }

                        //insert into order_status_histories
                        foreach ($res_data['data']['metadata']['order'] as $item) {
                            DB::table('order_status_histories')->insert([
                                    'order_id' => $orderId,
                                    'user_id' => $res_data['data']['metadata']['customerId'],
                                    'product_id' => $item['product_id'],
                                    'status_id' => 1,
                                    'status' => 'ORDER_PENDING',
                                    'merchant_organization_id' => $item['merchant_id'],
                                    'updated_by' => $res_data['data']['metadata']['customerId'],
                                    'created_at' => now(),
                            ]);
                        }
        
                        // insert into payment info table
                        DB::table('payment_information')->insert([
                            'order_id' => $orderId,
                            'status' => $res_data['data']['status'],
                            'reference' => $res_data['data']['reference'],
                            'amount' => $res_data['data']['amount'],
                            'fees' => $res_data['data']['fees'],
                            'channel' => $res_data['data']['channel'],
                            'message' => $res_data['data']['message'],
                            'auth_code' => $res_data['data']['authorization']['authorization_code'],
                            'customer_code' => $res_data['data']['customer']['customer_code'],
                            'created_at' => now()
                        ]);
                        //send order confirmation email to the user
                        $result = $this->sendOrderConfirmationEmail($orderId);

                            Cart::destroy();
                            if (Session::has('coupon')) {
                                Session::forget('coupon');
                            }
                        DB::commit();
                        return response()->json(['status' => 'success']);
                        } catch (\Throwable $th) {
                            DB::rollback();
                            if (app()->environment('production')){
                                \Sentry\captureException($th);
                            }
                            return response()->json(['status'=> 'error'],500);
                        }
                }else{
                  return response()->json(['status'=> error],500);
                }
        }

    
       
    }
}
