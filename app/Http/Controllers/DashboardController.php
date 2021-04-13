<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UserFinanceAffiliation;
use App\Models\CustomerFinanceOrganizationAffiliation;
use Cloudinary;

class DashboardController extends Controller
{   
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $lender_organizations = CustomerFinanceOrganizationAffiliation::where('user_id', Auth::id())->get();
        $selected_organizations = UserFinanceAffiliation::where('user_id', Auth::id())->get();
        
        if($lender_organizations->isNotEmpty() || $selected_organizations->isNotEmpty()) {
            
              $order = DB::table('orders')
              ->leftJoin('status_options', 'orders.status_id', '=', 'status_options.id')
              ->join('order_details', 'order_details.order_id', '=', 'orders.id')
              ->join('products','order_details.product_id', '=', 'products.id')
              ->select('orders.*','status_options.status_name','products.image_one_secure_url','order_details.product_id')
              ->where('orders.user_id',Auth::id())->orderBy('orders.id','DESC')->limit(10)->paginate(10);

              return view('dashboard',compact('order'));
        }else{ 
            $finance_institutions = DB::table('lenders')->get();
            return view('pages.select_finance_institution', compact('finance_institutions'));
        }  
    }

     public function saveFinanceInstitution(Request $request) {
     $finance_institution = $request->selectedInstitutions;
     $identification_card = $request->input('identification');
     $identification_number = $request->input('identification_number');

     $data = array();
     for ($x = 0; $x < sizeof($finance_institution); $x++) { $arr=array(); $arr['user_id']=Auth::user()->id;
         $arr['lender_organization_id'] = $finance_institution[$x];
         $arr['identification_type'] = $identification_card;
         $arr['identification_number'] = $identification_number;
         $arr['created_at'] = now();
         array_push($data, $arr);
         }

    UserFinanceAffiliation::insert($data);

    $insertedId = DB::getPdo()->lastInsertId();
    return response()->json($insertedId);
    }

    public function changePassword(){
    return view('auth.change_password');
    }

    public function resetPassword(Request $request)
    {
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

    }

     public function showProfile() {
     $user = DB::table('users')
     ->leftJoin('profile_images','users.id','=','profile_images.user_id')
     ->select('users.name','users.phone','users.email','profile_images.profile_secure_url')
     ->where('users.id',Auth::id())->first();

     return view('pages.user_profile',compact('user'));
     }

      public function updateProfile(Request $request) {
      $full_name = $request->input('full_name');
      $email = $request->input('email');
      $phone = $request->input('phone_number');
      $image = $request->image;

      $profileImageCheck = DB::table('profile_images')->where('user_id',Auth::id())->first(); //can be null

      $data = array();
      $imageData = array();

      if($image){
      if (empty($profileImageCheck)) {
      $uploadImage = Cloudinary::upload($image->getRealPath(),
      [
      'folder' => 'ncommerce/profile',
      'transformation' => [
      'width' => 200,
      'height' => 200,
      'crop' => 'fill',
      'radius'=> 'max'
      ]
      ]);
      $public_id = $uploadImage->getPublicId();
      $secure_url = $uploadImage->getSecurePath();
      $imageData['profile_public_id'] = $public_id;
      $imageData['profile_secure_url'] = $secure_url;
      $imageData['user_id'] = Auth::id();
      $imageData['created_at'] = now();

      $data['name'] = $full_name;
      $data['phone'] = $phone;
      $data['email'] = $email;
      $data['updated_at'] = now();
      DB::table('profile')->insert($imageData);
      DB::table('users')->where('id',Auth::id())->update($data);
      }else{
      $publicId = $profileImageCheck->profile_public_id;// picking the profile public id from the variable
      //delete the old image from cloudinary
      $result = Cloudinary::destroy($publicId);
      if ($result) {
      $uploadImage = Cloudinary::upload($image->getRealPath(),
      [
      'folder' => 'ncommerce/profile',
      'transformation' => [
      'width' => 200,
      'height' => 200,
      'crop' => 'fill',
      'radius'=> 'max'
      ]
      ]);
      $public_id = $uploadImage->getPublicId();
      $secure_url = $uploadImage->getSecurePath();
      $imageData['profile_public_id'] = $public_id;
      $imageData['profile_secure_url'] = $secure_url;

      $data['name'] = $full_name;
      $data['phone'] = $phone;
      $data['email'] = $email;
      $data['updated_at'] = now();
      DB::table('profile')->where('user_id',Auth::id())->update($imageData);
      DB::table('users')->where('id',Auth::id())->update($data);
      }
      }

      }else{
      $data['name'] = $full_name;
      $data['phone'] = $phone;
      $data['email'] = $email;
      $data['updated_at'] = now();
      DB::table('users')->where('id',Auth::id())->update($data);
      }


      $notification=array('messege'=>'Profile Updated successfully','alert-type'=>'success');

      return Redirect()->back()->with($notification);

      }

}
