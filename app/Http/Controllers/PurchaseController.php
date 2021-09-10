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
		   #special offers for associaitons if the current logged in customer is with an association
          $special_association_offers = DB::table('customer_finance_organization_affiliations')
          ->join('users', 'customer_finance_organization_affiliations.user_id', '=', 'users.id')
          ->join('lenders', 'customer_finance_organization_affiliations.lender_organization_id', '=', 'lenders.id')
          ->join('finance_unions', 'customer_finance_organization_affiliations.union_id', '=', 'finance_unions.union_id')
          ->join('unions', 'finance_unions.union_id', '=', 'unions.id')
          ->join('lender_offerings', 'lender_offerings.finance_union_id', '=', 'finance_unions.id')
          ->select('lenders.id as lender_organization_id', 'unions.union_name', 'unions.union_common_name','lenders.registered_name',
          'lenders.trade_name', 'lender_offerings.id','lender_offerings.payment_period', 'lender_offerings.percentage',
          'lender_offerings.max_financed')
          ->distinct()
          ->orderBy('percentage', 'ASC')
          ->where('customer_finance_organization_affiliations.user_id', Auth::id())->get();

		  #finance normal offers for customers without an association
          $credit_offers = DB::table('customer_finance_organization_affiliations')
          ->join('users', 'customer_finance_organization_affiliations.user_id', '=', 'users.id')
          ->join('lenders', 'customer_finance_organization_affiliations.lender_organization_id', '=', 'lenders.id')
          ->join('lender_offerings', 'lender_offerings.lender_organization_id', '=', 'lenders.id')
          ->select('lenders.id as lender_organization_id', 'lender_offerings.id', 'lenders.registered_name',
          'lenders.trade_name', 'lender_offerings.payment_period', 'lender_offerings.percentage',
          'lender_offerings.max_financed')
          ->distinct()
          ->orderBy('percentage', 'ASC')
		  ->where('lender_offerings.finance_union_id', null)
          ->where('customer_finance_organization_affiliations.user_id', Auth::id())->get();
                if(sizeof($special_association_offers) > 0){
                    $cart = Cart::content();
                    return view('pages.checkout', compact('cart','special_association_offers'));
                }elseif($credit_offers->isNotEmpty()) {
                    $amount = DB::table('lender_offerings')
                    ->select('max_financed')
                    ->where('lender_offerings.lender_organization_id', Auth::user()->lender_organization_id)
                    ->first();
              
                    $cart = Cart::content();
                    return view('pages.checkout', compact('cart','credit_offers', 'amount'));
                } else {
                    $cart = Cart::content();
                    return view('pages.checkout', compact('cart'));
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
