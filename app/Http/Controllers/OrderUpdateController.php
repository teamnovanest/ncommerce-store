<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\LenderOrderUpdate;
use App\Mail\MerchantOrderUpdate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderUpdateController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function updateOrder(Request $request,$orderId,$orderDetailId){
        $status_id = $request->statusId;
        $product_id = $request->productId;

        DB::beginTransaction();
        try {
            $already_existing_status = DB::table('order_status_histories')
            ->where('status_id',$status_id)
            ->where('order_id',$orderId)
            ->where('product_id',$product_id)->first();

        
        if (empty($already_existing_status)) {
                $status_name = DB::table('status_options')->where('id',$status_id)->first('status_name');
                
                    DB::table('order_details')
                    ->where('id',$orderDetailId)
                    ->where('order_id',$orderId)
                    ->where('product_id',$product_id)
                    ->update([
                    'status_id' => $status_id,
                    'status' => $status_name->status_name,
                    'updated_at' => now(),
                    ]);
                    
                    DB::table('order_status_histories')->insert([
                    'user_id' => Auth::user()->id,
                    'order_id'=>$orderId,
                    'status_id' => $status_id,
                    'product_id' => $product_id,
                    'updated_by' => Auth::user()->id,
                    'created_at' => now(),
                    'updated_at' => now()
                    ]);

                     // info: Following are information needed to send email to the lender and merchant
                    $order_summary = DB::table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->select('orders.id AS oid','order_code','subtotal','total','name','email','total_financed','orders.created_at AS order_date')
                    ->where('orders.id', $orderId)
                    ->where('orders.user_id', Auth::user()->id)
                    ->first();

                    $merchant = DB::table('order_details')
                    ->join('merchants','order_details.merchant_organization_id','=','merchants.id')
                    ->join('settings','merchants.id','=','settings.merchant_organization_id')
                    ->select('registered_name','email')
                    ->where('order_details.id',$orderDetailId)
                    ->first();

                    $finance_institution = DB::table('order_details')
                    ->join('order_status_histories','order_details.order_id','=','order_status_histories.order_id')
                    ->join('users','order_status_histories.updated_by','=','users.id')
                    ->join('lenders','users.lender_organization_id','=','lenders.id')
                    ->select('lenders.registered_name as lender','email','name')
                    ->where('order_details.id', $orderDetailId)
                    ->where('order_status_histories.status_id', 5)
                    ->where('order_status_histories.product_id', $product_id)
                    ->first();

                    $order_details = DB::table('order_details')
                    ->join('status_options','order_details.status_id','=','status_options.id')
                    ->join('products', 'order_details.product_id', '=', 'products.id')
                    ->select('image_one_secure_url','products.product_name as product','quantity','totalprice','description','status_id')
                    ->where('order_details.order_id', $orderId)
                    ->where('order_details.product_id', $product_id)
                    ->first();

                    $order_financing = DB::table('order_financings')
                    ->select('payment_period','percentage')
                    ->where('order_id',$orderId)
                    ->first();
                
                    Mail::to($merchant->email)->send(new MerchantOrderUpdate($order_summary,$order_details,$merchant));
                    Mail::to($finance_institution->email)->send(new LenderOrderUpdate($order_summary,$order_details,$finance_institution,$order_financing));

                    DB::commit();      
                    return \response()->json($status_name);
                } else {
                    return \response()->json(['message'=> 'Status already exist']);
                }
            } catch (\Throwable $th) {
                $error = $th->getMessage();
                DB::rollback();
                return response()->json(['error'=>'An error occured. Try again or contact support if issue persist'],500);
            }
        
    }
}
