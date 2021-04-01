<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
         $order = DB::table('orders')
        ->leftJoin('status', 'orders.status_id', '=', 'status.id')
        ->join('orders_details', 'orders_details.order_id', '=', 'orders.id')
        ->join('products','orders_details.product_id', '=', 'products.id')
        ->select('orders.*','status.status_name','products.image_one_secure_url','orders_details.product_id')
        ->where('orders.user_id',Auth::id())->orderBy('orders.id','DESC')->limit(10)->get();

        return view('dashboard',compact('order'));
    }
}
