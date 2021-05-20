<?php

namespace App\Http\Controllers;

use Cart;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

class PurchaseController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

     public function checkout()
     {
       try {
         $credit_offers = DB::table('customer_finance_organization_affiliations')
      ->join('users', 'customer_finance_organization_affiliations.user_id', '=', 'users.id')
      ->join('lenders', 'customer_finance_organization_affiliations.lender_organization_id', '=', 'lenders.id')
      ->join('lender_offerings', 'lender_offerings.lender_organization_id', '=', 'lenders.id')
      ->select('lenders.id as lender_organization_id', 'lender_offerings.id', 'lenders.registered_name',
      'lenders.trade_name', 'lender_offerings.payment_period', 'lender_offerings.percentage',
      'lender_offerings.max_financed')
      ->orderBy('percentage', 'ASC')
      ->where('customer_finance_organization_affiliations.user_id', Auth::id())->get();
      
      if($credit_offers->isNotEmpty()) {
        $amount = DB::table('lender_offerings')
        ->select('max_financed')
        ->where('lender_offerings.lender_organization_id', Auth::user()->lender_organization_id)
        ->first();
  
        $cart = Cart::content();
        return view('pages.checkout', compact('cart','credit_offers', 'amount'));
      } else {
        $finance_institutions = DB::table('lenders')->get();
        $regions = Region::all();
        $notification=array(
        'messege'=>'You need to be affiliated with a lender before you can make a purchase',
        'alert-type'=>'info'
        );
        return redirect()->action([DashboardController::class, 'index'])->with($notification);
      }
       } catch (\Throwable $th) {
          if (app()->environment('production')){
            \Sentry\captureException($th);
        }
        $notification=array(
            'messege'=>'An error occured while accessing checkout page. Try again or contact support if issue still persist',
            'alert-type'=>'error'
        );
        return Redirect()->back()->with($notification);
       }
      
     }
}
