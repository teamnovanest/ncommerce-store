<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
