<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use Response;

class ProductController extends Controller
{
    public function productView($id)
    {
        $product = DB::table('products')
    			->join('category','products.category_id','category.id')
    			->join('subcategory','products.subcategory_id','subcategory.id')
    			->join('brand','products.brand_id','brand.id')
    			->select('products.*','category.category_name','subcategory.subcategory_name','brand.brand_name')
    			->where('products.id',$id)
    			->first();

    	$color = $product->product_color;
    	$product_color = explode(',', $color);
    	
    	$size = $product->product_size;
    	$product_size = explode(',', $size);		

		//  return response::json(array(
		// 	'product' => $product,
		// 	'color' => $product_color,
		// 	'size' => $product_size,
		// ));
    	return view('pages.product_details',compact('product','product_color','product_size'));
    }

public function addCart(Request $request, $id){
$product = DB::table('products')->where('id',$id)->first();
  $data = array();
 
 if ($product->discount_price == NULL) {
 	$data['id'] = $product->id;
 	$data['name'] = $product->product_name;
 	$data['qty'] = $request->qty;
 	$data['price'] = $product->selling_price;
 	$data['weight'] = 1;
 	$data['options']['image'] = $product->image_one_secure_url;
 	$data['options']['color'] = $request->color;
 	$data['options']['size'] = $request->size;
	$data['options']['merchant_organization_id'] = $product->merchant_organization_id;
 	 Cart::add($data);
 	$notification=array(
                        'messege'=>'Product Added Successfully ',
                        'alert-type'=>'success'
                         );
                       return Redirect()->back()->with($notification);
 }else{

 	$data['id'] = $product->id;
 	$data['name'] = $product->product_name;
 	$data['qty'] = $request->qty;
 	$data['price'] = $product->discount_price;
 	$data['weight'] = 1;
 	$data['options']['image'] = $product->image_one_secure_url;
 	$data['options']['color'] = $request->color;
 	$data['options']['size'] = $request->size;
	$data['options']['merchant_organization_id'] = $product->merchant_organization_id;
 	 Cart::add($data);
 	 $notification=array(
                        'messege'=>'Product Added Successfully ',
                        'alert-type'=>'success'
                         );
                       return Redirect()->back()->with($notification);

    }   

      }
}
