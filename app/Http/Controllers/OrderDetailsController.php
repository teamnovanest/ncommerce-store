<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderDetailsController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }
    
    public function viewOrderStatus($order_id,$orderDetailId) {
        try {
            $order_codes = DB::table('orders')->where('id',$order_id)->get('order_code');
            [$order_code] = $order_codes;
            
            $current_status = DB::table('order_details')
            ->leftjoin('status_options', 'order_details.status_id', '=', 'status_options.id')
            ->where('order_details.id', $orderDetailId)
            ->where('order_details.order_id', $order_id)->first();
            
            $reason = DB::table('order_details')
            ->select('reason_for_rejection')
            ->where('id', $orderDetailId)
            ->where('order_id',$order_id)->first();

            $product_id = DB::table('order_details')
            ->select('product_id AS pid')
            ->where('order_details.id', $orderDetailId)
            ->first();
           
            $order_status = DB::table('order_details')
            ->join('order_status_histories', 'order_status_histories.order_id','=', 'order_details.order_id')
            ->leftJoin('status_options', 'order_status_histories.status_id', '=', 'status_options.id')
            ->select('status_options.status_name', 'status_options.description',
            'order_status_histories.status_id','order_status_histories.updated_at','order_details.created_at')
            ->where('order_details.id', $orderDetailId)
            ->where('order_status_histories.product_id',$product_id->pid)
            ->where('order_status_histories.user_id', Auth::id())
            ->get();

            $merchant = DB::table('order_details')->where('id', $orderDetailId)->first('merchant_organization_id');


            $settings = DB::table('settings')
            ->join('merchant_locations','settings.id','=','merchant_locations.setting_id')
            ->join('regions','merchant_locations.region_id','=','regions.id')
            ->join('cities','merchant_locations.city_id','=','cities.id')
            ->select('settings.phone','settings.alt_phone','settings.address','regions.region_name','cities.city_name')
            ->where('settings.merchant_organization_id', $merchant->merchant_organization_id)
            ->first();
            
            return view('pages.order_status',compact('order_status','order_code','current_status','reason','settings'));       
        } catch (\Throwable $th) {
             if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while accessing order detail page. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
        }

    }
}
