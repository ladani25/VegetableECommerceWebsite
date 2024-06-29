<?php

use App\Http\Controllers\api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


route::post('register', [ApiController::class,'register']);
route::post('login',[apicontroller::class,'login']);
route::post('edit-profile',[ApiController::class,'editprofile']);

route::post('cart',[ApiController::class,'cart']);
route::post('remove',[ApiController::class,'removecart']);
route::post('removeall',[ApiController::class,'removeallcart']);


route::post('wishlist',[ApiController::class,'wishlist']);
route::post('remove-wishlist',[ApiController::class,'removewishlist']);
route::post('removeall-wishlist',[ApiController::class,'removeallwishlist']);
route::post('filter',[ApiController::class,'fillter']);
route::post('search',[ApiController::class,'search']);
route::post('coupon',[ApiController::class,'coupon']);
route::post('checkout',[ApiController::class,'checkout']);
route::post('checkout-payment',[ApiController::class,'checkout_payment']);
route::post('Review',[ApiController::class,'Review']);

Route::post('forgot-password', [ApiController::class, 'forgetPassword']);
route::post('verify-otp',[ApiController::class,'verifyOtp']);
route::post('reset-password',[ApiController::class,'resetPassword']);   
route::post('order-history',[ApiController::class,'orderhistrory']);

route::post('order-details',[ApiController::class,'orderDetails']);