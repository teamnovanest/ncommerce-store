<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function cities($region_id) {
        try {
              $cities = DB::table('cities')->where('region_id',$region_id)->get();
              return response()->json($cities);
        } catch (\Throwable $th) {
            //throw $th;
             if (app()->environment('production')){
             \Sentry\captureException($th);
             }
             $resData['message'] = "Something didn't go right. Our engineers have been notified about the issue and
             will look into it. If the issue persists contact support";
             return response()->json($resData, 500);
        }

    }
}
