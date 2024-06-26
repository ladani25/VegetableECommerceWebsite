<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Cart;
use App\Models\order;
use App\Models\User;
use App\Models\Product;
use App\Models\wishlist;
use App\Models\user_orders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class CouponController extends Controller
{


    public function applyCoupon(Request $request)
    {
        $validatedData = $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = Coupon::where('coupon_code', $validatedData['coupon_code'])->first();

        if (!$coupon) {
            Session::put('coupon', [
                'discount' => 00,
                'shipping' => 00
            ]);
                return redirect()->back()->with('error', 'Invalid coupon code.');
            
            }

        $user_id = auth()->id(); // Assuming you have user authentication

        // Calculate the total price of items in the cart
        $cartItems = Cart::where('u_id', $user_id)->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        // Calculate the discount
        $discount = $coupon->type == 'percent' ? $totalPrice * ($coupon->amount / 100) : $coupon->amount;
        $shipping = 10; // Assuming a fixed shipping cost

        // Store coupon details in session
        Session::put('coupon', [
            'code' => $validatedData['coupon_code'],
            'discount' => $discount,
            'shipping' => $shipping
        ]);
        return back()->with('success', 'Coupon applied successfully.');
    }


  

    public function checkout(Request $request)
    {
    //     // Retrieve cart items for the user
    //     // dd($request->all());dd()
        // dd(session('email'));
        $user = User::where('email', session('email'))->first();
        $user_id = $user->u_id;
        $cartItems = Cart::where('u_id', $user_id)->get();
        // dd($cartItems);
        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Your cart is empty.');
        }
        $totalQuantity = $cartItems->sum('quantity');
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        $coupon = session('coupon', [
            'discount' => 0,
            'hipping' => 0
        ]);
        $discount = $coupon['discount'];
        $shipping = $coupon['shipping'];
        $finalPrice = $totalPrice - $discount + $shipping;
        // Optionally, save order items or any other order-related data here
        $user = auth()->user();
        $totalQuantity = $request->input('totalQuantity');
        $totalPrice = $request->input('totalPrice');
    
    
        $user = User::where('email', session('email'))->first();
        $user_id = $user->u_id;
    
        // Retrieve the user's ID
        // Create the order
        $order = new order();
        $order->u_id = $user->u_id;
        $order->qty = $totalQuantity;
        $order->amount = $totalPrice;
        $order->save();
    
        // Save data to orders table
        $orderId = $order->id;
        // dd($orderId);
        // Save data to user_orders table
          foreach ($cartItems as $item) {
                
                $userOrder = new user_orders();
                $userOrder->order_id = $order->id; // Use the ID of the saved order
                $userOrder->u_id = $user->u_id;
                $userOrder->p_id = $item->p_id;
                $userOrder->u_qty = $item->quantity;
                $userOrder->save();
            }

 
        Session::put('order', [
            'amount' => $totalPrice
        ]);

        $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
        $cartCount = Cart::where('u_id', auth()->id())->count();
        return view('home.checkout', compact('cartItems',  'shipping', 'totalQuantity', 'totalPrice', 'discount', 'finalPrice', 'wishlistCount', 'cartCount'));
    }


    // public function checkout(Request $request)
    // {
    //     // Retrieve cart items for the user
    //     // dd($request->all());dd()
    //     // dd(session('email'));
    //     $user = User::where('email', session('email'))->first();
    //     $user_id = $user->u_id;
    //     $cartItems = Cart::where('u_id', $user_id)->get();
    //     // dd($cartItems);
    //     if ($cartItems->isEmpty()) {
    //         return redirect()->route('home')->with('error', 'Your cart is empty.');
    //     }

    //     // Calculate total quantity and total price
    //     $totalQuantity = $cartItems->sum('quantity');
    //     $totalPrice = $cartItems->sum(function ($item) {
    //         return $item->quantity * $item->price;
    //     });

    //     // Retrieve coupon data from session
    //     $coupon = session('coupon', [
    //         'discount' => 0,
    //         'shipping' => 0
    //     ]);

    //     $discount = $coupon['discount'];
    //     $shipping = $coupon['shipping'];
    //     $finalPrice = $totalPrice - $discount + $shipping;

    //     // Retrieve the authenticated user
    //     $user = auth()->user();
    //     if (!$user) {
    //         return redirect()->route('login')->with('error', 'You need to login first.');
    //     }

    //     // Create the order
    //     $order = new Order();
    //     $order->u_id = $user->u_id;
    //     $order->qty = $totalQuantity;
    //     $order->amount = $totalPrice; // Use the final price
    //     $order->save();
    //     // dd($cartItems);
    //         // Save each cart item as an order item
    //         foreach ($cartItems as $item) {
                
    //             $userOrder = new user_orders();
    //             $userOrder->order_id = $order->id; // Use the ID of the saved order
    //             $userOrder->u_id = $user->u_id;
    //             $userOrder->p_id = $item->p_id;
    //             $userOrder->u_qty = $item->quantity;
    //             $userOrder->save();
    //         }


    //         // Clear the cart after checkout
    //         Cart::where('u_id', $user->u_id)->delete();

    //         // Retrieve wishlist and cart count
    //         $wishlistCount = Wishlist::where('u_id', $user->u_id)->count();
    //         $cartCount = Cart::where('u_id', $user->u_id)->count();

    //         // Return the checkout view with necessary data
    //         return view('home.checkout', compact('cartItems', 'totalPrice', 'discount', 'shipping', 'finalPrice', 'wishlistCount', 'cartCount'));
    // }


}

    


