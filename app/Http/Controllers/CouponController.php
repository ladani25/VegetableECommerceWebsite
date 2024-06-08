<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Cart;
use App\Models\order;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CouponController extends Controller
{
// public function Coupon(Request $request)
//     {
//         // dd($request->all());

//         $request->validate([
//             'coupon_code' => 'required|string',
//         ]);

//         $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();
//         // dd($coupon);
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
//             dd($totalPrice);

//         $discount = $coupon->type == 'percent'
//             ? $totalPrice * ($coupon->amount / 100)
//             : $coupon->amount;
//             // dd($discount);

//         $shipping = 10; 
//         // dd($shipping);
//         Session::put('coupon', [
//             'discount' => $discount,
//             'shipping' => $shipping
//         ]);

//         return back()->with('success', 'Coupon applied successfully.');
    
//     }

public function applyCoupon(Request $request)
{
    $request->validate([
        'coupon_code' => 'required|string',
    ]);

    $coupon = coupon::where('coupon_code', $request->coupon_code)->first();
    if (!$coupon) {
        Session::put('coupon', [
            'discount' => 0,
            'shipping' => 0
        ]);
        return redirect()->back()->with('error', 'Invalid coupon code.');
    }

    $totalPrice = Cart::where('u_id', session('u_id'))
        ->join('products', 'carts.p_id', '=', 'products.p_id')
        ->sum('products.price');

    $discount = $coupon->type == 'percent' ? $totalPrice * ($coupon->amount / 100) : $coupon->amount;
    $shipping = 10; // Assuming a fixed shipping cost

    Session::put('coupon', [
        'discount' => $discount,
        'shipping' => $shipping
    ]);

    return back()->with('success', 'Coupon applied successfully.');
}





//  public function checkout(Request $request) 
// {
//     // Fetch the user based on the session email
//     $user = User::where('email', session('email'))->first();
//     if (!$user) {
//         return  view('home.checkout')->with('error', 'User not found.');
//     }

//     // Retrieve the user ID from the session
//     $userId = session('u_id');
//     if (!$userId) {
//         return  view('home.checkout')->with('error', 'User ID not found in session.');
//     }

//     // Fetch the cart items for the user
//     $cartItems = Cart::where('u_id', $userId)->get();
//     if ($cartItems->isEmpty()) {
//         return view('home.checkout')->with('error', 'Your cart is empty.');
//     }

//     // Calculate the total price of the cart items
//     $totalPrice = $cartItems->sum('total_price');

//     // Retrieve coupon details from the session
//     $coupon = Session::get('coupon', [
//         'discount' => 0,
//         'shipping' => 0
//     ]);

//     $discount = $coupon['discount'];
//     $shipping = $coupon['shipping'];

//     // Calculate the final total price
//     $finalPrice = $totalPrice - $discount + $shipping;

//     // Create an order with the relevant details
//     try {
//         $order = Order::create([
//             'u_id' => $userId,
//             'amount' => $finalPrice, // Use the calculated final price
//             'qty' => $cartItems->sum('quantity'), // Sum of quantities in the cart
//         ]);
//     } catch (\Exception $e) {
//         // Log error or handle exception
//         return  view('home.checkout')->with('error', 'Failed to create order: ' . $e->getMessage());
//     }
//     $cartItems = Cart::where('u_id', $userId)->get();


//     // Insert order details and optionally clear the cart
//     foreach ($cartItems as $item) {
//         DB::table('order_details')->insert([
//             'order_id' => $order->id, // Ensure correct column for order ID
//             'product_id' => $item->product_id, 
//             'qty' => $item->quantity,
//             'price' => $item->price,
//             'u_id' => $userId,
//         ]);
//     }

//     $item->delete(); 
//     return view('home.checkout', compact('cartItems', 'totalPrice', 'discount', 'shipping'));

//         // Optionally clear the cart item
//         // $item->delete(); // Use delete() instead of save() if clearing the cart
// }

public function checkout(Request $request)
{
    $user = User::where('email', session('email'))->first();

    if (!$user) {
        return view('home.checkout')->with('error', 'User not found.');
    }

    $userId = session('u_id');
    if (!$userId) {
        return view('home.checkout')->with('error', 'User ID not found in session.');
    }

    $cartItems = Cart::where('u_id', $userId)->get();
    if ($cartItems->isEmpty()) {
        return view('home.checkout')->with('error', 'Your cart is empty.');
    }

    $totalPrice = $cartItems->sum('price');

    $coupon = Session::get('coupon', [
        'discount' => 0,
        'shipping' => 0
    ]);

    $discount = $coupon['discount'];
    $shipping = $coupon['shipping'];
    $finalPrice = $totalPrice - $discount + $shipping;

    return view('home.checkout', compact('cartItems', 'totalPrice', 'discount', 'shipping', 'finalPrice'));
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


// public function checkout(Request $request) 
// {
//    $user = User::where('email', session('email'))->first();
//     $userId = session('u_id');
//     // dd($user);
    
//     if (!$userId) {
//         // dd($userId);
//         return view('home.checkout')->with('error', 'You need to be logged in to proceed to checkout.');
//     }
//     $cartItems = Cart::where('u_id', $userId)->get();

//     if ($cartItems->isEmpty()) {
//         return view('home.checkout')->with('error', 'Your cart is empty.');
//     }

   
//     $totalPrice = $cartItems->sum(function ($item) {
//         return $item->quantity * $item->product->price;
//     });

    
//     $coupon = session('coupon', [
//         'discount' => 0,
//         'shipping' => 0
//     ]);

//     $discount = $coupon['discount'];
//     $shipping = $coupon['shipping'];

   
//     $finalTotalPrice = $totalPrice - $discount + $shipping;

//     return view('home.checkout', compact('cartItems', 'totalPrice', 'discount', 'shipping', 'finalTotalPrice'));
// }



public function placeorder(Request $request)
{

    $user = User::where('email', session('email'))->first();
    $userId = session('u_id');
    if (!$userId) {
        return view('home.checkout')->with('error', 'You need to be logged in to proceed to checkout.');
    }
    $cartItems = Cart::where('u_id', $userId)->get();

    if ($cartItems->isEmpty()) {
        return view('home.checkout')->with('error', 'Your cart is empty.');
    }

    $totalPrice = $cartItems->sum(function ($item) {
        return $item->quantity * $item->product->price;
    });

    $coupon = session('coupon', [
        'discount' => 0,
        'shipping' => 0
    ]);

    $discount = $coupon['discount'];
    $shipping = $coupon['shipping'];

    $finalTotalPrice = $totalPrice - $discount + $shipping;

    return view('home.checkout', compact('cartItems', 'totalPrice', 'discount', 'shipping', 'finalTotalPrice'));
}


    public function order(Request $request)
    {
        $cart_id = $request->id;

        $cart = Cart::find($cart_id);

        if (!$cart) {
            return redirect()->back()->with('error', 'Cart not found.');
        }

        $user = User::where('email', session('email'))->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        foreach ($cart->items as $item) {
            $order = new Order();
            $order->p_id = $item->product_id;
            $order->qty = $item->quantity;
            $order->amount = $item->price * $item->quantity;
            $order->u_id = $user->u_id;
            $order->save();
        }

        // You might want to clear the cart after placing the order
        // $cart->items()->delete();

        return view('home.checkout')->with('success', 'Order placed successfully.');
    }

}