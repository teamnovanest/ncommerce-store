<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderDetailsController extends Controller
{
    public function viewOrderStatus($order_id) {
    $order_codes = DB::table('orders')->where('id',$order_id)->get('order_code');
    [$order_code] = $order_codes;
    
    $current_status = DB::table('orders')
    ->join('status', 'orders.status_id', '=', 'status.id')
    ->where('orders.id', $order_id)->first();
     
    $order_status = DB::table('orders')
    ->join('order_status_histories', 'order_status_histories.order_id','=', 'orders.id')
    ->leftJoin('status', 'order_status_histories.status_id', '=', 'status.id')
    ->select('status.status_name', 'status.description','order_status_histories.updated_at','orders.created_at')
    ->where('orders.id',$order_id)->where('order_status_histories.user_id', Auth::id())->get();
    
    return view('pages.order_status',compact('order_status','order_code','current_status'));

    }
}
