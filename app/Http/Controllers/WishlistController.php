<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $userid = Auth::id();
   $product = DB::table('wishlists')
           ->join('products','wishlists.product_id','products.id')
           ->select('products.*','wishlists.user_id')
           ->where('wishlists.user_id',$userid)
           ->get();
          // return response()->json($product);
           return view('pages.wishlist',compact('product'));
 
   }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
   public function addWishlist($id){

    $userid = Auth::id();
    $check = DB::table('wishlists')->where('user_id',$userid)->where('product_id',$id)->first();

    $data = array(
    'user_id' => $userid,
    'product_id' => $id,

    );

			  if (Auth::Check()) {
             
             if ($check) {
              return \Response::json(['error' => 'Product Already Added To Wishlist']);	 
             }else{
             	DB::table('wishlists')->insert($data);
          return \Response::json(['success' => 'Product Added To wishlist']);
 
             }
             
			  	 
			  }else{
          return \Response::json(['error' => 'At first login your account']);      

			  } 

   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
        //
    }
}
