<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\cartcontroller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\productscontrollers;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\usercontrollers;
use App\Http\Controllers\CouponController;
use Illuminate\Support\Facades\Route;

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


route::get('home',[HomeController::class,'home']);
route::get('shop',[HomeController::class,'shop']);
route::get('contact',[HomeController::class,'contact']);
route::get('shop_categeroy',[HomeController::class,'shop_categeroy']);

route::get('register',[usercontrollers::class,'register']);
route::post('user_register',[usercontrollers::class,'user_register']);


route::get('login',[usercontrollers::class,'login']);
route::post('user_login',[usercontrollers::class,'user_login']);

route::get('products_deatils/{p_id}',[HomeController::class,'products_deatils']);
route::get('user',[usercontrollers::class,'user']);


route::get('wishlists',[WishlistController::class,'index']);
route::post('add',[WishlistController::class,'add']);
route::post('remove/{w_id}',[WishlistController::class,'remove']);
Route::post('/update-wishlist', [WishlistController::class, 'updateWishlist']);


route::get('cart',[cartcontroller::class,'cart']);
route::post('addcart',[cartcontroller::class,'addcart']);
route::post('update-cart/{id}', [cartcontroller::class, 'updateCart']);
route::post('removecart/{id}',[cartcontroller::class,'removecart']);
route::post('removeall',[cartcontroller::class,'removeall']);


// Route::post('apply-coupon', [CouponController::class, 'applyCoupon']);


// Route::resource('coupon', CouponController::class);
// Route::post('apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon');
// Route::post('remove-coupon', [CouponController::class, 'removeCoupon'])->name('remove.coupon');

// Route::post('/apply-shipping', [CouponController::class, 'applyShipping'])->name('apply.shipping');
// Route::post('/apply-coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon');
// Route::post('/remove-coupon', [CouponController::class, 'removeCoupon'])->name('remove.coupon');

route::post('coupon',[CouponController::class ,'coupon']);
