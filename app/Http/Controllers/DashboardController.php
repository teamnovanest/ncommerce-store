<?php

namespace App\Http\Controllers;

use Cart;
use Cloudinary;
use App\Models\User;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserLenderSelection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\CustomerFinanceOrganizationAffiliation;

class DashboardController extends Controller
{   
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        try {
           $lender_organizations = CustomerFinanceOrganizationAffiliation::where('user_id', Auth::id())->get();
        $selected_organizations = UserLenderSelection::where('user_id', Auth::id())->get();
        
        if($lender_organizations->isNotEmpty() || $selected_organizations->isNotEmpty()) {
            
              $order = DB::table('orders')
              ->join('order_details', 'order_details.order_id', '=', 'orders.id')
              ->leftJoin('status_options', 'order_details.status_id', '=', 'status_options.id')
              ->join('products','order_details.product_id', '=', 'products.id')
              ->join('order_financings', 'orders.id', '=', 'order_financings.order_id')
              ->select('orders.*','order_details.id AS order_detail_id','order_details.status','order_details.status_id','order_details.totalprice','status_options.status_name','products.image_one_secure_url','products.product_name','order_details.product_id','products.slug','order_financings.payment_period','order_financings.percentage')
              ->where('orders.user_id',Auth::id())->orderBy('orders.id','DESC')->limit(10)->paginate(10);
            
              return view('dashboard',compact('order'));
        }else{ 
            $finance_institutions = DB::table('lenders')->get();
            $regions = Region::all();
            return view('pages.select_finance_institution', compact('finance_institutions','regions'));
        }    
        } catch (\Throwable $th) {
            if (app()->environment('production')){
             \Sentry\captureException($th);
             }
             $notification = array(
                 'messege'  => 'An error ocurred. Try again or contact support if issue still persist',
                 'alert-type' => 'error'
             );
             return Redirect()->back()->with($notification);
        }
       
    }

     public function saveFinanceInstitution(Request $request) {
        $finance_institution = $request->selectedInstitutions;
     $affiliation = $request->affiliation;
     $region_id = $request->region_id;
     $city_id = $request->city_id;
     $identification_card = $request->input('identification');
     $identification_number = $request->input('identification_number');
    //  dd($request);

     $data = array();
     if($finance_institution) {
        
         for ($x = 0; $x < sizeof($finance_institution); $x++) { $arr=array(); $arr['user_id']=Auth::user()->id;
             $arr['lender_organization_id'] = $finance_institution[$x];
             $arr['region_id'] = $region_id;
             $arr['city_id'] = $city_id;
             $arr['identification_type'] = $identification_card;
             $arr['identification_number'] = $identification_number;
             $arr['created_at'] = now();
             array_push($data, $arr);
             }
     } else {
             $arr['user_id']=Auth::user()->id;
             $arr['affiliation'] = $affiliation;
             $arr['region_id'] = $region_id;
             $arr['city_id'] = $city_id;
             $arr['identification_type'] = $identification_card;
             $arr['identification_number'] = $identification_number;
             $arr['created_at'] = now();
             array_push($data, $arr);
     }

    UserLenderSelection::insert($data);

    $insertedId = DB::getPdo()->lastInsertId();
    dd($insertedId);
    return response()->json($insertedId);
    }

    public function changePassword(){
    try {
        return view('auth.change_password');
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

    public function resetPassword(Request $request)
    {
    try {
      $password=Auth::user()->password;
    $oldpass=$request->oldpass;
    $newpass=$request->password;
    $confirm=$request->password_confirmation;
    if (Hash::check($oldpass,$password)) {
    if ($newpass === $confirm) {
    $user=User::find(Auth::id());
    $user->password=Hash::make($request->password);
    $user->save();
    Auth::logout();
    $notification=array(
    'messege'=>'Password Changed Successfully ! Now Login with Your New Password',
    'alert-type'=>'success'
    );
    return Redirect()->route('login')->with($notification);
    }else{
    $notification=array(
    'messege'=>'New password and Confirm Password does not match!',
    'alert-type'=>'error'
    );
    return Redirect()->back()->with($notification);
    }
    }else{
    $notification=array(
    'messege'=>'Old Password does not match!',
    'alert-type'=>'error'
    );
    return Redirect()->back()->with($notification);
    }
  
    } catch (\Throwable $th) {
        if (app()->environment('production')){
          \Sentry\captureException($th);
        }
      
       $notification=array(
        'messege'=>'An error occured while resetting password. Try again or contact support if issue still persist',
        'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
    }
    
    }

}
