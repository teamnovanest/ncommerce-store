<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FeatureRequestController extends Controller
{
      public function index(){
    $requests = DB::table('feature_requests')->paginate(10);
    return view('feature_request.index', compact('requests'));
    }

    public function create(){
        return view('feature_request.create');
    } 

     public function save (Request $request){
        $title = $request->input('title');
        $description = $request->input('description');
        DB::table('feature_requests')->insert([
            'user_id' => Auth::user()->id,
            'phone_number' => Auth::user()->phone,
            'email' => Auth::user()->email,
            'title' => $title,
            'description' => $description,
            'tag' => 'user',
            'likes' => 1,
            'created_at' => now(),
        ]);
          	$notification=array(
            'messege'=>'Request Sent',
            'alert-type'=>'success'
             );

        return redirect()->route('feature.index')->with($notification);
    }
    
    public function requestLike($requestId){
       $likes = DB::table('feature_requests')->where('id',$requestId)->first('likes');
       
        $results = DB::table('feature_requests')
        ->where('id',$requestId)
        ->update([
          'likes' => $likes->likes + 1,
          'updated_at' => now()
        ]);
         
        return response()->json($results);
    }

     public function editFeature($id){
    $request = DB::table('feature_requests')->where('id',$id)->first();
    return view('feature_request.edit',compact('request'));
    }


    public function updateRequest(Request $request,$id){
        $tittle = $request->input('title');
        $description = $request->input('description');
        DB::table('feature_requests')
        ->where('id',$id)
        ->where('user_id',Auth::id())->update([
            'title' => $tittle,
            'description' => $description,
            'updated_at' => now(),
        ]);
        $notification=array(
        'messege'=>'Request updated Successfully',
        'alert-type'=>'success'
        );
        return redirect()->route('feature.index')->with($notification);
    }
}
