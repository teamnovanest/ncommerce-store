<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $featured = DB::table('products')->where('status',1)->orderBy('id','desc')->limit(100)->get();
        $trend = DB::table('products')->where('status',1)->where('trend',1)->orderBy('id','desc')->limit(8)->get();
        $best = DB::table('products')->where('status',1)->where('best_rated',1)->orderBy('id','desc')->limit(8)->get();
        $hot = DB::table('products')
            ->join('brand_options','products.brand_id','brand_options.id')
            ->select('products.*','brand_options.brand_name')
            ->where('products.status',1)->where('hot_new',1)->orderBy('id','desc')->limit(3)
            ->get();
        // $slider = DB::table('products')
        //     ->join('brand','products.brand_id','brand.id')
        //     ->select('products.*','brand.brand_name')
        //     ->where('main_slider',1)->orderBy('id','DESC')->first();
        $category = DB::table('category_options')->get();
        // $subcategory = DB::table('subcategory')->where('category_id',$cat->id)->get();




        return view('home', compact('featured', 'trend' , 'best', 'hot', 'category'));
    }

     public function Logout()
    {
        Auth::logout();
        $notification=array(
        'messege'=>'Successfully Logout',
        'alert-type'=>'success'
            );
        return Redirect()->route('login')->with($notification);
    }
}
