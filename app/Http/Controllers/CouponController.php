<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
// public function Coupon(Request $request)
//     {
//         $request->validate([
//             'coupon_code' => 'required|string',
//         ]);

//         $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();

//         if (!$coupon) {
            
//         Session::put('coupon', [
//             'discount' => 00,
//             'shipping' => 00
//         ]);
//             return redirect()->back()->with('error', 'Invalid coupon code.');
          
//         }

//         $totalPrice = Cart::where('u_id', session('u_id'))
//             ->join('products', 'carts.p_id', '=', 'products.p_id')
//             ->sum('products.price');
//             // dd($totalPrice);

//         $discount = $coupon->type == 'percent'
//             ? $totalPrice * ($coupon->amount / 100)
//             : $coupon->amount;

//         $shipping = 10; // Assuming a fixed shipping cost

//         Session::put('coupon', [
//             'discount' => $discount,
//             'shipping' => $shipping
//         ]);

//         return back()->with('success', 'Coupon applied successfully.');
    
//     }
public function Coupon(Request $request)
{
    // dd($request->all());
    $request->validate([
        'coupon_code' => 'required|string',
    ]);

    $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();

    if (!$coupon) {
        Session::put('coupon', [
            'discount' => 0,
            'shipping' => 0
        ]);
        return redirect()->back()->with('error', 'Invalid coupon code.');
    }

    $userId = auth()->id();
    $cartItems = Cart::where('u_id', $userId)->get();

    $totalPrice = $cartItems->sum('total_price');

    $discount = $coupon->type == 'percent'
        ? $totalPrice * ($coupon->amount / 100)
        : $coupon->amount;

    $shipping = 10; // Assuming a fixed shipping cost

    Session::put('coupon', [
        'discount' => $discount,
        'shipping' => $shipping
    ]);

    // Recalculate total price after applying the coupon
    $totalPriceAfterCoupon = $totalPrice - $discount + $shipping;

    // Redirect back with success message and the recalculated total price
    return redirect()->back()->with('success', 'Coupon applied successfully.')->with('totalPriceAfterCoupon', $totalPriceAfterCoupon);
}


    public function checkout(Request $request) 
{
    $userId = auth()->id();
    $cartItems = Cart::where('u_id', $userId)->get();

    $totalPrice = $cartItems->sum('total_price');

    // Retrieve the current coupon details from the session if they exist
    $coupon = Session::get('coupon', [
        'discount' => 0,
        'shipping' => 0
    ]);


    $discount = $coupon['discount'];
    $shipping = $coupon['shipping'];

    // Calculate the final total price
    $totalPrice = $totalPrice - $discount + $shipping;

    return view('home.checkout', compact('cartItems', 'totalPrice', 'discount', 'shipping', 'totalPrice'));
}

// public function updateCart(Request $request, $itemId)
// {
//     dd($request->all());
//     // Validate the incoming request data
//     $validatedData = $request->validate([
//         'qty' => 'required|integer|min:1|max:100',
//         'coupon_code' => 'nullable|string', // Allow coupon code to be nullable
//     ]);

//     // Find the cart item by ID
//     $cartItem = Cart::find($itemId);

//     if ($cartItem) {
//         // Update the quantity
//         $cartItem->quantity = $validatedData['qty'];
//         $cartItem->save();

//         // Recalculate total quantity and total price of all items in the cart for the user
//         $user_id = $cartItem->u_id;
//         $cartItems = Cart::where('u_id', $user_id)->get();
//         $totalQuantity = $cartItems->sum('quantity');
//         $totalPrice = $cartItems->sum(function ($item) {
//             return $item->quantity * $item->product->price;
//         });

//         // Apply coupon logic if a coupon code is provided
//         $discount = 0;
//         dd($discount);
//         if ($validatedData['coupon_code']) {
//             // Find the coupon
//             $coupon = Coupon::where('coupon_code', $validatedData['coupon_code'])->first();

//             if ($coupon) {
//                 // Calculate discount based on coupon type and amount
//                 $discount = $coupon->type == 'percent'
//                     ? $totalPrice * ($coupon->amount / 100)
//                     : $coupon->amount;
//             } else {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Invalid coupon code.'
//                 ]);
//             }
//         }

//         // Recalculate total price after applying the coupon
//         $totalPrice -= $discount;

//         $itemTotalPrice = $cartItem->quantity * $cartItem->product->price;

//         // Return a JSON response indicating success
//         return response()->json([
//             'success' => true,
//             'itemTotalPrice' => $itemTotalPrice,
//             'totalQuantity' => $totalQuantity,
//             'totalPrice' => $totalPrice,
//             'discount' => $discount, // Include discount information in the response
//         ]);
//     } else {
//         // Handle the case where the cart item is not found
//         return response()->json([
//             'success' => false,
//             'message' => 'Cart item not found.'
//         ]);
//     }
// }
// public function applyCoupon(Request $request)
// {
//     $request->validate([
//         'coupon_code' => 'required|string',
//     ]);

//     $couponCode = $request->input('coupon_code');

//     $coupon = Coupon::where('coupon_code', $couponCode)->first();

//     if ($coupon) {
//         // Store coupon details in session
//         Session::put('coupon', [
//             'discount' => $coupon->amount, // Assuming 'amount' represents the discount
//             'shipping' => 10, // Assuming a fixed shipping cost
//         ]);

//         return response()->json([
//             'success' => true,
//             'coupon' => $coupon,
//         ]);
//     } else {
//         return response()->json([
//             'success' => false,
//             'error' => 'Coupon not found',
//         ]);
//     }
// }
     
}