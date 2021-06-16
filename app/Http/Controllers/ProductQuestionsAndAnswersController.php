<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductQuestionsAndAnswersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function productQuestions(Request $request){
    if(Auth::id()){ 
        $product_id = $request->product_id;
        $question = $request->question;
        $merchant_organization_id = $request->merchant_organization_id;
        try {
            $insertedId = DB::table('product_questions')->insertGetId([
            'user_id' => Auth::id(),
            'product_id' =>$product_id,
            'merchant_organization_id' => $merchant_organization_id,
            'question' => $question,
            'created_at' => now()
            ]);

            $question = DB::table('product_questions')
                ->join('users','users.id','=','product_questions.user_id')
                ->leftJoin('profile_images','product_questions.user_id','=','profile_images.user_id')
                ->select('product_questions.question','product_questions.answer','product_questions.created_at','users.name','profile_images.profile_secure_url')
                ->where('product_questions.id',$insertedId)
                ->first();
            
            return response()->json($question);
        } catch (\Throwable $th) {
            //throw $th;
            if (app()->environment('production')){
                \Sentry\captureException($th);
            }
            return response()->json(['error' => 'Oops an error occured, please try again or contact support if issue persist.'],500);
        }
    }else{
        return response()->setStatusCode(401);
    }

    }

    public function getProductsQA($product_id){
        if(Auth::id()){
            try {
                $question = DB::table('product_questions')
                        ->join('users','users.id','=','product_questions.user_id')
                        ->leftJoin('profile_images','product_questions.user_id','=','profile_images.user_id')
                        ->select('product_questions.question','product_questions.answer','product_questions.created_at','users.name','profile_images.profile_secure_url')
                        ->where('product_questions.product_id',$product_id)
                        ->get();
    
                return response()->json($question);
            } catch (\Throwable $th) {
                 if (app()->environment('production')){
                \Sentry\captureException($th);
            }
                 return \response()->setStatusCode(500);
            }

        }else{
        return \response()->setStatusCode(401);
        }
    }
}
