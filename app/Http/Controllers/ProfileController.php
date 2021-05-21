<?php

namespace App\Http\Controllers;

use App\Models\ProfileImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Cloudinary;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function showProfile() {
      try {
        $user = DB::table('users')
        ->leftJoin('profile_images','users.id','=','profile_images.user_id')
        ->select('users.name','users.phone','users.email','profile_images.profile_secure_url')
        ->where('users.id',Auth::id())->first();

        return view('pages.user_profile',compact('user'));
      } catch (\Throwable $th) {
         if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while accessing your profile. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
      }
        
    }

    public function updateProfile(Request $request) {
      try {  
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
            DB::table('profile_images')->insert($imageData);
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
            DB::table('profile_images')->where('user_id',Auth::id())->update($imageData);
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
      } catch (\Throwable $th) {
         if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while updating profile. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
      }
      }
}
