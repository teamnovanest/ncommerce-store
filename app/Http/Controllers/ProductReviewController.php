<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReviewController extends Controller
{
    public function productReviewCreate(Request $request){
        
     $data = array();
     $data ['name'] = $request->name;
     $data ['email'] = $request->email;
     $data ['reviews'] = $request->reviews;  
     DB::table('product_reviews')->insert($data);
     $notification=array(
        'messege'=>'Your review is added successfully',
        'alert-type'=>'success'
     );
     return Redirect()->back()->with($notification);
    }
}
