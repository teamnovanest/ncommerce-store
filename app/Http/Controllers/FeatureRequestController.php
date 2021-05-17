<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FeatureRequestController extends Controller
{
      public function index(){
    $requests = DB::table('feature_requests')->where('tag','user')->paginate(10);
    $user_likes = DB::table('feature_request_likes')->get();
    return view('feature_request.index', compact('requests','user_likes'));
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
    
    public function requestLike(Request $request,$id){
        #if the status  === 0,liking the request
        try {
            $status = $request->status;
            if ($status === '0') {
                DB::table('feature_request_likes')->insert([
                    'request_id' => $id,
                    'user_id' => Auth::id(),
                    'likes' => 1,
                    'created_at' => now(),
                    ]);
                    
                $likes = DB::table('feature_requests')->where('id',$id)->first('likes');
                $update = DB::table('feature_requests')
                ->where('id',$id)
                ->update([
                    'likes' => $likes->likes + 1,
                    'updated_at' => now()
                ]);
                if ($update) {
                    $results = DB::table('feature_requests')->where('id',$id)->first('likes');
                    return response()->json(['status'=>'liked','results'=>$results]);
                }
    
            } else {
               #disliking the request
                DB::table('feature_request_likes')->where('request_id',$id)->where('user_id',Auth::id())->delete();
                    
                $likes = DB::table('feature_requests')->where('id',$id)->first('likes');
                $update = DB::table('feature_requests')
                ->where('id',$id)
                ->update([
                    'likes' => $likes->likes - 1,
                    'updated_at' => now()
                ]);
                if ($update) {
                    $results = DB::table('feature_requests')->where('id',$id)->first('likes');
                    return response()->json(['status'=>'disliked','results'=>$results]);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['message'=>"Opps something went wrong, Try again"],500);
        }
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

    public function delete($id){
        DB::table('feature_requests')->where('id',$id)->where('user_id',Auth::id())->delete();
        DB::table('feature_request_likes')->where('request_id',$id)->where('user_id',Auth::id())->delete();

        $notification=array(
        'messege'=>'Request deleted successfully',
        'alert-type'=>'success'
        );

        return redirect()->route('feature.index')->with($notification);
    }
}
