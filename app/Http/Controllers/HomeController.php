<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cart;
use App\Models\Product;


class HomeController extends Controller
{

    public function index(){
        try {
            //$featured = DB::table('products')->where('status',1)->orderBy('id','desc')->limit(100)->paginate(12);
            $featured = Product::leftjoin('merchant_locations', 'merchant_locations.merchant_organization_id', '=', 'products.merchant_organization_id')
            ->leftJoin('regions','merchant_locations.region_id','=','regions.id')
            ->leftJoin('cities','merchant_locations.city_id','=','cities.id')
            ->select('products.id','products.slug','products.image_one_secure_url','products.category_id','products.product_name','products.selling_price','products.discount_price','regions.region_name','cities.city_name')
            ->where('products.status','=',1)->inRandomOrder()->paginate(12);
            //  $featured = Product::with(['brand'])->where('status','=',1)->inRandomOrder()->paginate(12);
            $trend = Product::where('status','=',1)->where('trend',1)->inRandomOrder()->limit(8);
            $best = Product::where('status','=',1)->where('best_rated',1)->inRandomOrder()->limit(8);
            //$trend = DB::table('products')->where('status',1)->where('trend',1)->orderBy('id','desc')->limit(8)->get();
            //$best = DB::table('products')->where('status',1)->where('best_rated',1)->orderBy('id','desc')->limit(8)->get();
            $hot = DB::table('products')
                ->join('brand_options','products.brand_id','brand_options.id')
                ->select('products.*','brand_options.brand_name')
                ->where('products.status',1)->where('hot_new',1)->orderBy('id','desc')->limit(3)
                ->get();

            $category = DB::table('category_options')->where('deleted_at', NULL)->get();
            // $subcategory = DB::table('subcategory')->where('category_id',$cat->id)->get();

            $publicity = DB::table('publicity')
            ->where('start_date','<=',date('Y-m-d'))
            ->where('end_date','>=',date('Y-m-d'))
            ->select('start_date','end_date','image_secure_url')
            ->inRandomOrder()->limit(10)->get();
    
            return view('home', compact('featured', 'trend' , 'best', 'hot', 'category', 'publicity'));
        } catch (\Throwable $th) {
             if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while accessing homepage. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
        }
    }


     public function shop(){
         try {
           $allProducts = DB::table('products')
           ->leftJoin('merchant_locations', 'merchant_locations.merchant_organization_id', '=', 'products.merchant_organization_id')
           ->leftJoin('regions','merchant_locations.region_id','=','regions.id')
           ->leftJoin('cities','merchant_locations.city_id','=','cities.id')
           ->select('products.id','products.slug','products.image_one_secure_url','products.category_id','products.product_name','products.selling_price','products.discount_price','regions.region_name','cities.city_name')
           ->where('products.status',1)->inRandomOrder()->paginate(50);
           $category = DB::table('category_options')->get();
           
       return view('pages.shop',compact('category', 'allProducts'));  
         } catch (\Throwable $th) {
             if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while accessing shop page. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
         }
        
    }

    public function shopView($id){
        try {
           $allProducts = DB::table('products')
           ->leftJoin('merchant_locations', 'merchant_locations.merchant_organization_id', '=', 'products.merchant_organization_id')
           ->leftJoin('regions','merchant_locations.region_id','=','regions.id')
           ->leftJoin('cities','merchant_locations.city_id','=','cities.id')
           ->select('products.id','products.slug','products.image_one_secure_url','products.category_id','products.product_name','products.selling_price','products.discount_price','regions.region_name','cities.city_name')
           ->where('status',1)->where('category_id',$id)->inRandomOrder()->paginate(50);
           
           $category = DB::table('category_options')
           ->get();

           $cat_name = DB::table('category_options')
           ->where('id', $id)
           ->first();

       return view('pages.shop',compact('category', 'allProducts','cat_name')); 
        } catch (\Throwable $th) {
             if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while viewing category products. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
        }
	}
}
