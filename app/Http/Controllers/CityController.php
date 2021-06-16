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
             $resData['message'] = "Something didn't go right. Our engineers have been notified \nabout the issue and
             will look into it. If the issue persists contact support";
             return response()->json($resData, 500);
        }

    }

    public function searchProductByCity(Request $request){
    $cityId = $request->id;
    $city = DB::table('cities')->where('id',$cityId)->first('city_name');
    $products =  DB::table('products')
    ->join('merchant_locations', 'merchant_locations.merchant_organization_id', '=', 'products.merchant_organization_id')
    ->join('cities', 'cities.id', '=', 'merchant_locations.city_id')
    ->select('products.id','products.product_name','products.product_details','products.slug','products.product_color','products.product_size','products.selling_price','products.discount_price','products.video_link','products.image_one_secure_url')
    ->inRandomOrder()->paginate(48);

    $all_cities = DB::table('cities')
    ->join('merchant_locations', 'merchant_locations.city_id', '=', 'cities.id')
    ->join('regions', 'regions.id', '=', 'merchant_locations.region_id')
    ->select('cities.id','regions.region_name','cities.city_name')
    ->get();
    return view('pages.search_product_by_city',compact('products','city','all_cities'));
    }

}
