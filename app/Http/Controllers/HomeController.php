<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserFinanceAffiliation;

class HomeController extends Controller
{

     public function __construct()
     {
     $this->middleware('auth');
     }
     
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

      public function selectFinanceInstitution() {
      $finance_institutions = DB::table('lenders')->get();
    //   dd($finance_institutions);

      return view('pages.finance_institution_select', compact('finance_institutions'));
      }

        public function saveFinanceInstitution(Request $request) {
        $finance_institution = $request->selectedInstitutions;
        $identification_card = $request->input('identification');
        $identification_number = $request->input('identification_number');

        $data = array();
        for ($x = 0; $x < sizeof($finance_institution); $x++) { 
            $arr=array(); 
            $arr['user_id']=Auth::user()->id;
            $arr['lender_organization_id'] = $finance_institution[$x];
            $arr['identification_type'] = $identification_card;
            $arr['identification_number'] = $identification_number;
            $arr['created_at'] = now();
            array_push($data, $arr);
        }

        // dd($data);

        UserFinanceAffiliation::insert($data);

        $insertedId = DB::getPdo()->lastInsertId();
        return response()->json($insertedId);
        }
}
