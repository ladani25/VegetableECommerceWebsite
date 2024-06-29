<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\cartcontroller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\productscontrollers;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\usercontrollers;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\histroycontrollers;
use App\Http\Controllers\ordercontroller;
use App\Http\Controllers\PayPalController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
// Route::get('/', function () {
//     return view('welcome');
// });

route::get('/',[AdminController::class,'index']);
route::post('login',[AdminController::class,'login']);
route::get('dashbord',[AdminController::class,'dashbord']);



route::get('add_categeroy',[AdminController::class,'add_categeroy']);
route::get('categeroy',[AdminController::class,'categeroy']);
route::post('get_categeroy',[AdminController::class,'get_categeroy']);

route::post('edit_categeroy/{c_id}',[AdminController::class,'get_categeroy']);
route::post('edit_categeroy',[AdminController::class,'edit_categeroy']);
route::get('c_edit/{c_id}',[AdminController::class,'c_edit']);
route::post('edit_c/{c_id}',[AdminController::class,'edit_c']);
//route::post('edit_c/{c_id}',[AdminController::class,'edit_c']);
// Route::match(['get', 'post'], 'edit_c/{c_id}', [AdminController::class, 'edit_c']);
route::get('c_delete/{c_id}',[AdminController::class,'c_delete']);



route::get('products',[AdminController::class,'products']);
route::get('add_products',[AdminController::class,'add_products']);
route::post('get_products',[productscontrollers::class,'get_products']);
//route::get('categeroy',[productscontrollers::class,'categeroy']);
route::get('p_delete/{p_id}',[productscontrollers::class,'p_delete']);

route::get('p_edit/{p_id}',[productscontrollers::class,'p_edit']);
route::post('edit_p/{p_id}',[productscontrollers::class,'edit_p']);

Route::get('products.category/{c_id}', [HomeController::class, 'showCategory'])->name('products.category');
route::get('products.show/{p_id}',[HomeController::class,'showproducts'])->name('products.details');

route::get('home',[HomeController::class,'home'])->name('home');
route::get('shop',[HomeController::class,'shop']);
// Route::get('/shop', [HomeController::class, 'shop'])->name('shop');

route::get('contact',[HomeController::class,'contact']);
route::get('shop_categeroy',[HomeController::class,'shop_categeroy']);

Route::post('addreview', [HomeController::class, 'addReview'])->name('addreview');



route::get('register',[usercontrollers::class,'register']); 
route::post('user_register',[usercontrollers::class,'user_register']);


route::get('login',[usercontrollers::class,'login']);
route::post('user_login',[usercontrollers::class,'user_login']);
route::get('user_profile/',[usercontrollers::class,'user_profile']);
route::post('edit_profile/{u_id}',[usercontrollers::class,'edit_profile']);
route::get('change_password/{u_id}', [usercontrollers::class, 'change_password'])->name('change_password');
route::post('update_password/{u_id}', [usercontrollers::class, 'update_password'])->name('update_password');

Route::get('password/reset', [usercontrollers::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [usercontrollers::class, 'sendResetLinkEmail'])->name('password.email');

// routes/web.php

Route::get('password/reset', [usercontrollers::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [usercontrollers::class, 'resetPassword']);
Route::get('password/verify', [usercontrollers::class, 'showVerificationForm'])->name('password.verify');
Route::post('password/verify', [usercontrollers::class, 'verifyIdentity']);


route::get('products_details/{p_id}',[HomeController::class,'products_details']);
route::get('user',[usercontrollers::class,'user']);


route::get('wishlists',[WishlistController::class,'index']);
route::post('add',[WishlistController::class,'add']);
route::post('remove/{w_id}',[WishlistController::class,'remove']);
Route::post('/update-wishlist', [WishlistController::class, 'updateWishlist']);
route::post('removeall-wishlist',[WishlistController::class,'removeall']);


route::get('cart',[cartcontroller::class,'cart']);
route::post('addcart',[cartcontroller::class,'addcart']);
route::post('update-cart/{id}', [cartcontroller::class, 'updateCart']);
route::post('removecart/{id}',[cartcontroller::class,'removecart']);
route::post('removeall',[cartcontroller::class,'removeall']);



Route::post('apply-coupon', [CouponController::class, 'applyCoupon']);
Route::post('checkout',[CouponController::class,'checkout']);
// Route::match(['get', 'post'], '/checkout', 'CouponController')->name('checkout');




// route::post('order',[ordercontroller::class,'order']);
// route::post('order_details',[ordercontroller::class,'order_details']);

// route::get('payment',[ordercontroller::class,'payment']);

Route::post('place_order',[ordercontroller::class,'place_order']);
// Route::post('ordrs-pl',[ordercontroller::class,'order_place']);


Route::get('/payment-status', [OrderController::class, 'paymentStatus'])->name('payment.status');

route::get('order_histroy',[histroycontrollers::class,'order_histroy']);
Route::get('/order-details/{id}', [histroycontrollers::class, 'orderDetails'])->name('order.details');

Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/filter-products-by-price', [HomeController::class, 'filterProductsByPrice'])->name('filter.products.by.price');




// Route::get('/test-mail', function () {
//     $details = [
//         'title' => 'Test Mail from Laravel',
//         'body' => 'This is a test mail.'
//     ];

//     Mail::raw('This is a test mail', function($message) {
//         $message->to('your_test_email@example.com')
//                 ->subject('Test Mail');
//     });

//     return 'Email Sent';
// });


