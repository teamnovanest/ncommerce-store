<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FeatureRequestController extends Controller
{
    public function index(){
          try {
            $requests = DB::table('feature_requests')->where('tag','user')->paginate(10);

            return view('feature_request.index', compact('requests')); 
          } catch (\Throwable $th) {
            if (app()->environment('production')){
            \Sentry\captureException($th);
          }
         $notification=array(
            'messege'=>'An error occured while viewing feature requests. Try again or contact support if issue still persist',
            'alert-type'=>'error'
         );
            return Redirect()->back()->with($notification);
        }
    
    }

    public function create(){
        try {
            return view('feature_request.create');
        } catch (\Throwable $th) {
            if (app()->environment('production')){
          \Sentry\captureException($th);
        }
      
       $notification=array(
        'messege'=>'An error occured. Try again or contact support if issue still persist',
        'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
        }
    } 

     public function save (Request $request){
         try {         
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
                 'messege'=>'Feature request sent successfully',
                 'alert-type'=>'success'
                  );
     
             return redirect()->route('feature.index')->with($notification);
             
         } catch (\Throwable $th) {
             if (app()->environment('production')){
          \Sentry\captureException($th);
        }
      
       $notification=array(
        'messege'=>'An error occured while sending request. Try again or contact support if issue still persist',
        'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
         }
    }
    
    public function requestLike(Request $request,$id){
        try {
            #if the status  === 0,liking the request
            $status = $request->status;
            if ($status === '0') {
                $check = DB::table('feature_request_likes')->where('request_id',$id)->where('user_id',Auth::id())->first();
                if (empty($check)) {
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
                   return response()->json(['status'=>'liked_already']);
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
            if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        //   return response()->json(['error'=> $th->getMessage()],500);
          return response()->json(['error'=>'An error occured while sending request. Try again or contact support if issue still persist'],500);
        }
    }

    public function editFeature($id){
        try {     
            $request = DB::table('feature_requests')->where('id',$id)->first();
            return view('feature_request.edit',compact('request'));       
        } catch (\Throwable $th) {
            if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
        'messege'=>'An error occured while trying to access the edit page. Try again or contact support if issue still persist',
        'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
        }
    }


    public function updateRequest(Request $request,$id){
        try {
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
        } catch (\Throwable $th) {
            if (app()->environment('production')){
            \Sentry\captureException($th);
        }
            $notification=array(
            'messege'=>'An error occured while updating request. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
        }
    }

    public function delete($id){
        try {
            DB::table('feature_requests')->where('id',$id)->where('user_id',Auth::id())->delete();
            DB::table('feature_request_likes')->where('request_id',$id)->where('user_id',Auth::id())->delete();
    
            $notification=array(
            'messege'=>'Request deleted successfully',
            'alert-type'=>'success'
            );
    
            return redirect()->route('feature.index')->with($notification);            
        } catch (\Throwable $th) {
            if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while deleting request. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
        }
    }

    public function userLikes(){
        $likes = DB::table('feature_requests')
        ->join('feature_request_likes','feature_requests.id','=','feature_request_likes.request_id')
        ->select('feature_requests.id','feature_requests.title','feature_requests.description')
        ->where('feature_request_likes.user_id',Auth::id())->paginate(10);
    
        return view('feature_request.user_likes',\compact('likes'));
    }
}
