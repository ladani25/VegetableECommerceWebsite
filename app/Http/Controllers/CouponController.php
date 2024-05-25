<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\cart;

class CouponController extends Controller
{
    // Existing methods...

    // public function coupon(Request $request)
    //     {
    //         // Validate the request data
    //         $request->validate([
    //             'coupon_code' => 'required|string',
    //         ]);

    //         // Retrieve the coupon with the provided code from the database
    //         $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();

    //         // Check if the coupon exists
    //         if ($coupon) {
    //             // session(['coupon' => [
    //             //     'discount' => $coupon->discount,
    //             //     // 'shipping' => $coupon->shipping,
    //             // ]]);
        
    //             // If the coupon exists, display a success message or perform any other actions
    //             return redirect()->back()->with('success', 'Coupon code is valid.');
    //         } else {
    //             // If the coupon doesn't exist, display an error message
    //             return redirect()->back()->with('error', 'Invalid coupon code.');
    //         }
    //     }


    public function coupon(Request $request)
{
    // Validate the request data
    $request->validate([
        'coupon_code' => 'required|string',
    ]);

    // Retrieve the coupon with the provided code from the database
    $coupon = Coupon::findByCode($request->coupon_code);

    // Check if the coupon exists
    if ($coupon) {
        // Calculate the discount based on the total price by joining with the products table
        $totalPrice = \App\Models\Cart::where('u_id', session('u_id'))
            ->join('products', 'carts.p_id', '=', 'products.p_id')
            ->sum('products.price');

        $discount = $coupon->discount($totalPrice);

        // Store coupon details in the session
        session(['coupon' => [
            'discount' => $discount,
            'shipping' => 0, // Assuming no additional shipping cost for now
        ]]);

        // Redirect back with the updated discount value
        return redirect()->back()->with('success', 'Coupon code is valid.')->with(compact('discount'));
    } else {
        // If the coupon doesn't exist, display an error message
        return redirect()->back()->with('error', 'Invalid coupon code.');
    }
}

    
   


    

}