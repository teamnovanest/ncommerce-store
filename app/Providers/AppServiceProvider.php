<?php

namespace App\Providers;

use DB;
use Auth;
use Cart;
use View;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         //check that app is local
         if (!$this->app->isLocal()) {
           
            URL::forceScheme('https'); // use https in production
            
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        try {
            View::composer('*', function ($view) {
          if (Auth::user()) {
              $profile = DB::table('profile_images')->where('user_id',Auth::id())->first();
              $profileImage = !is_null($profile) ? $profile->profile_secure_url:"";
              $cart = Cart::content();
              $view->with(['cart'=>$cart,'profileImage'=>$profileImage]);
          }else{
              $cart = Cart::content();
              $view->with('cart',$cart);
          }
        });
        } catch (\Throwable $th) {
            $cart = null;
            $profileImage = null;
            return $th->getMessage();
        };

        Paginator::useBootstrap();

    }
}
