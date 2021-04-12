<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderDetailsController;
use App\Http\Controllers\FeatureRequestController;
use App\Http\Controllers\LenderOfferingController;


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
    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
});

Route::get("/", "App\Http\Controllers\HomeController@index");
Route::get('/user/logout', [HomeController::class, 'logout'])->name('user.logout');

// Search Route
Route::get('/product/search', [CartController::class,'search'])->name('product.search');


// Cart
Route::get('/product/cart', [CartController::class,'showCart'])->name('show.cart');
Route::get('/user/checkout/', [CartController::class,'checkout'])->name('user.checkout');
Route::post('/user/apply/coupon/', [CartController::class, 'coupon'])->name('apply.coupon');
Route::get('/remove/cart/{rowId}', [CartController::class, 'removeCart']);
Route::post('/update/cart/{rowId}', [CartController::class, 'updateCart']);


// Product 
Route::get('/product/details/{id}', [ProductController::class, 'productView']);
Route::post('/cart/product/add/{id}', [ProductController::class, 'addCart']);

// Checkout Routes
Route::get('/user/checkout/process/', [CheckoutController::class, 'checkout'])->name('checkout.process');

// Customer Order Details route
Route::get('/order/{id}/status', [OrderDetailsController::class,'viewOrderStatus'])->name('order.status');

// Feature Request Route
Route::get('/feature-request/index', [FeatureRequestController::class,'index'])->name('feature.index');
Route::get('/feature-request/create', [FeatureRequestController::class,'create'])->name('feature.create');
Route::post('/feature-request/save', [FeatureRequestController::class,'save'])->name('feature.save');
Route::post('/feature-request/{requestId}/save', [FeatureRequestController::class,'requestLike']);
Route::get('/feature-request/{id}/edit', [FeatureRequestController::class,'editFeature'])->name('feature.edit');
Route::post('/feature-request/{id}/update', [FeatureRequestController::class,'updateRequest'])->name('feature.update');


// Contact page routes
Route::get('/contact/page', [ContactController::class, 'contact'])->name('contact.page');
Route::post('/contact/form', [ContactController::class, 'contactForm' ])->name('contact.form');

//  Wishlist
Route::get('/add/wishlist/{id}', [WishlistController::class, 'addWishlist']);
Route::get('/user/wishlist/', [WishlistController::class, 'index'])->name('user.wishlist');


// All Product details Page 
Route::get('/products/{id}', [ProductController::class, 'productsView']);
Route::get('/allcategory/{id}', [ProductController::class, 'categoryView']);


// shop
Route::get('/shop', [HomeController::class, 'shop']);
Route::get('/shop/{id}', [HomeController::class, 'shopView']);


// Selecting finance organizations route
// Route::get('/select/finance-institutions', [HomeController::class, 'selectFinanceInstitution']);
Route::post('/institutions/save', [DashboardController::class,'saveFinanceInstitution'])->name('save-finance_institution');

Route::get('/lender-offerings/{orgId}', [LenderOfferingController::class, 'lenderOfferings']);

// Password Reset route
Route::get('/password/change', [DashboardController::class, 'changePassword'])->name('password.change');
Route::post('/password/update', [DashboardController::class,'updatePassword'])->name('password.update');

// User profile route
Route::get('/user/profile', [DashboardController::class,'showProfile'])->name('user.profile.show');
Route::post('user/profile/update', [DashboardController::class,'updateProfile'])->name('user.profile.update');
