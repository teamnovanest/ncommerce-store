<?php

namespace App\Http\Controllers;

use Response;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\LenderOffering;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;



class ProductController extends Controller
{
    public function productView($id)
    {
      try {
    
				$product = Product::whereId($id)->first();

        $product_seo = DB::table('product_seos')
        ->where('product_id',$id)
        ->first();
        
        $color = $product->product_color;
        
        $product_color = explode(',', $color);
    	
        $size = $product->product_size;
        
    	$product_size = explode(',', $size);		
      
      $product_quantity = $product->product_quantity;

      $location = DB::table('merchant_locations')
      ->leftJoin('cities', 'merchant_locations.city_id', '=', 'cities.id')
      ->leftJoin('regions', 'merchant_locations.region_id', '=', 'regions.id')
      ->select('cities.city_name','regions.region_name')
      ->where('merchant_locations.merchant_organization_id',$product->merchant_organization_id)
      ->first();

    	return view('pages.product_details',compact('product','product_color','product_size','product_quantity','product_seo','location'));      
      } catch (\Throwable $th) {
         if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while accessing product detail page. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
      }
    }

public function addCart(Request $request, $id){
  try {
    $product = DB::table('products')->where('id',$id)->first();
  
     $data = array();
  
     $data['id'] = $product->id;
     $data['name'] = $product->product_name;
     $data['qty'] = $request->input('qty');
     $data['price'] = (!$product->discount_price) ? $product->selling_price / 100 :
     ($product->selling_price - $product->discount_price) /100;
     $data['weight'] = 1;
     $data['options']['image'] = $product->image_one_secure_url;
     $data['options']['color'] = $request->input('color');
     $data['options']['size'] = $request->input('size');
     $data['options']['merchant_organization_id'] = $product->merchant_organization_id;
     
     Cart::add($data);
      $notification=array(
      'messege'=>'Product Added Successfully ',
      'alert-type'=>'success'
      );
      return Redirect()->back()->with($notification);
  } catch (\Throwable $th) {
     if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while adding product to cart. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
  }

}


public function productsView(Request $request){

  try {
    $subcategoryId = $request->id;
        $products = DB::table('products')
        ->leftJoin('merchant_locations', 'merchant_locations.merchant_organization_id', '=', 'products.merchant_organization_id')
        ->leftJoin('regions','merchant_locations.region_id','=','regions.id')
        ->leftJoin('cities','merchant_locations.city_id','=','cities.id')
        ->select('products.id','products.slug','products.image_one_secure_url','products.category_id','products.product_name','products.selling_price','products.discount_price','regions.region_name','cities.city_name')
        ->where('subcategory_id',$subcategoryId)->paginate(5);
        $categorys = DB::table('category_options')->inRandomOrder()->get();
	   
       $brands = DB::table('products')->where('subcategory_id',$subcategoryId)->select('brand_id')->groupBy('brand_id')->get();

       return view('pages.all_products',compact('products','categorys','brands')); 
  } catch (\Throwable $th) {
     if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while accessing product page. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
  }
	  
	   
	   
	}

	public function categoryView(Request $request){
    try {
      $categoryId = $request->id;   
      $category_all =  DB::table('products')
      ->leftJoin('merchant_locations', 'merchant_locations.merchant_organization_id', '=', 'products.merchant_organization_id')
      ->leftJoin('regions','merchant_locations.region_id','=','regions.id')
      ->leftJoin('cities','merchant_locations.city_id','=','cities.id')
      ->select('products.id','products.slug','products.image_one_secure_url','products.category_id','products.product_name','products.selling_price','products.discount_price','regions.region_name','cities.city_name')
      ->where('category_id',$categoryId)->paginate(10);
    return view('pages.all_category',compact('category_all'));
    } catch (\Throwable $th) {
       if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while accessing product page. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
    }
    

  }
  
	public function searchProductByBrand(Request $request){
    try {
    $brandId = $request->id;
    $products =  DB::table('products')
    ->leftJoin('merchant_locations', 'merchant_locations.merchant_organization_id', '=', 'products.merchant_organization_id')
    ->leftJoin('regions','merchant_locations.region_id','=','regions.id')
    ->leftJoin('cities','merchant_locations.city_id','=','cities.id')
    ->select('products.id','products.slug','products.image_one_secure_url','products.category_id','products.product_name','products.selling_price','products.discount_price','regions.region_name','cities.city_name')
    ->where('brand_id',$brandId)->paginate(50);
    return view('pages.search_product_by_brand',compact('products'));
    } catch (\Throwable $th) {
       if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while accessing brand products. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
    }
    

  }

  

    public function search(Request $request){
      try {
        $item = $request->search;
        
        //Apply  filter and  display only products with status code 1. 
        // Do not include products the merchant does  not want to dispay in the store in the results
        $products =  Product::search($item)->where('status', 1)->paginate(50); 
      
    return view('pages.search',compact('products'));  

      } catch (\Throwable $th) {
         if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while accessing searched products. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
      }
     
    }
}
