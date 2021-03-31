<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// All routes that needs to be protected by the customer roles goes inside this function

Route::group(['middleware' => ['role:customer']], function () {

    // Dashboard
    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
});

Route::get("/", "App\Http\Controllers\HomeController@index");

// Search Route
Route::get('/product/search', ["CartController::class","search"])->name('product.search');


// Cart
Route::get('/product/cart', ['CartController::class','showCart'])->name('show.cart');
Route::get('/user/checkout/', ['CartController::class','checkout'])->name('user.checkout');

