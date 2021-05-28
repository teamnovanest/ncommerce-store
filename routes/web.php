<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OrderUpdateController;
use App\Http\Controllers\OrderDetailsController;
use App\Http\Controllers\ProductReviewController;
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
Route::get('/user/logout', [LogoutController::class, 'logout'])->name('user.logout');

// Search Route
Route::get('/product/search', [ProductController::class,'search'])->name('product.search');


// Cart
Route::get('/product/cart', [CartController::class,'showCart'])->name('show.cart');
Route::get('/user/checkout/', [PurchaseController::class,'checkout'])->name('user.checkout');
Route::get('/remove/cart/{rowId}', [CartController::class, 'removeCart']);
Route::post('/update/cart/{rowId}', [CartController::class, 'updateCart']);
Route::get('/add/to/cart/{id}', [CartController::class,'AddCart']);

//coupone application routes
Route::post('/user/apply/coupon/', [CouponController::class, 'coupon'])->name('apply.coupon'); 
Route::get('remove/coupon/', [CouponController::class, 'couponRemove'])->name('remove.coupon'); 

// Product 
Route::get('/product/details/{id}/{slug}', [ProductController::class, 'productView']);
Route::post('/cart/product/add/{id}', [ProductController::class, 'addCart']);

// Checkout Routes
Route::get('/user/checkout/process', [CheckoutController::class, 'checkout'])->name('checkout.process');

// Customer Order Details route
Route::get('/order/{id}/status/{orderDetailId}', [OrderDetailsController::class,'viewOrderStatus'])->name('order.status');

// Feature Request Route
Route::get('/feature-request/index', [FeatureRequestController::class,'index'])->name('feature.index');
Route::get('/feature-request/create', [FeatureRequestController::class,'create'])->name('feature.create');
Route::post('/feature-request/save', [FeatureRequestController::class,'save'])->name('feature.save');
Route::post('/feature-request/{id}/like', [FeatureRequestController::class,'requestLike']);
Route::get('/feature-request/{id}/edit', [FeatureRequestController::class,'editFeature'])->name('feature.edit');
Route::post('/feature-request/{id}/update', [FeatureRequestController::class,'updateRequest'])->name('feature.update');
Route::get('/feature-request/{id}/delete', [FeatureRequestController::class,'delete'])->name('feature.delete');
Route::get('/user/likes', [FeatureRequestController::class,'userLikes'])->name('user.likes');


// Contact page routes
Route::get('/contact/page', [ContactController::class, 'contact'])->name('contact.page');
Route::post('/contact/form', [ContactController::class, 'contactForm' ])->name('contact.form');

//  Wishlist
Route::get('/add/wishlist/{id}', [WishlistController::class, 'addWishlist']);
Route::get('/user/wishlist/', [WishlistController::class, 'index'])->name('user.wishlist');
Route::get('/delete/wishlist/{id}', [WishlistController::class, 'deleteWishlist']);


// All Product details Page 
Route::get('/{category}/{id}/{subcategory_name}', [ProductController::class, 'productsView']);
Route::get('/product/category/{id}/{category_name}', [ProductController::class, 'categoryView'])->name('category.name');
Route::get('/product/brand/{id}/{brand_name}', [ProductController::class, 'searchProductByBrand']);


// shop
Route::get('/shop', [HomeController::class, 'shop']);
Route::get('/shop/{id}', [HomeController::class, 'shopView']);


// Selecting finance organizations route
// Route::get('/select/finance-institutions', [HomeController::class, 'selectFinanceInstitution']);
Route::post('/institutions/save', [DashboardController::class,'saveFinanceInstitution'])->name('save-finance_institution');

Route::get('/lender-offerings/{orgId}', [LenderOfferingController::class, 'lenderOfferings']);

// Password Reset route
Route::get('/password/change', [DashboardController::class, 'changePassword'])->name('password.change');
Route::post('/reset/password', [DashboardController::class,'resetPassword'])->name('password.new');

// User profile route
Route::get('/user/profile', [ProfileController::class,'showProfile'])->name('user.profile.show');
Route::post('user/profile/update', [ProfileController::class,'updateProfile'])->name('user.profile.update');

//newsletters
Route::post('/newsletter/create', [NewsletterController::class, 'storeNewsLetter']) ->name('store.newsletter');



//Product Review
Route::get('/product/review', [ProductReviewController::class, 'productReview']);
// City Route
Route::get('/city/{region_id}', [CityController::class, 'cities']);

//order update route
Route::post('/order/{orderId}/{orderDetailId}/update', [OrderUpdateController::class, 'updateOrder']);
