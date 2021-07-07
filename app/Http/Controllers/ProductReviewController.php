<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{  public function __construct(){
    $this->middleware('auth');
}
    public function productReview(Request $request){
    try {
        $data = array();
        $data['user_id'] = Auth::id();
        $data['product_id'] = $request->product_id;
        $data ['reviews'] = $request->review;  
        $data ['rating'] = $request->selected_rating; 
        $data['created_at'] = now();
        $id = DB::table('product_reviews')->insertGetId($data);
        if ($id) {
            $review = DB::table('product_reviews')
            ->join('users','product_reviews.user_id','=','users.id')
            ->leftJoin('profile_images','users.id','=','profile_images.user_id')
            ->select('product_reviews.reviews','product_reviews.rating','product_reviews.created_at','users.name','profile_images.profile_secure_url')
            ->where('product_reviews.id',$id)
            ->where('users.id',Auth::id())->first();
          return response()->json($review);
        }else{
             return response()->json(['error'=>'An error occured while sending your review, please try again or contact support if issue persist.']);
        }
       
    } catch (\Throwable $th) {
        if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        return response()->json(['error'=>'An error occured while sending your review, please try again or contact support if issue persist.'],500);
    }
    }

}
