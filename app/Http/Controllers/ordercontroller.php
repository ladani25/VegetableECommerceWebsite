<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order_deatils;
use App\Models\User;
use App\Models\Cart;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    // public function showCheckoutForm(Request $request)
    // {
    //     $cartItems = Cart::where('u_id', session('u_id'))->get();
    //     $totalPrice = $cartItems->sum(function ($item) {
    //         return $item->quantity * $item->product->price;
    //     });

    //     return view('home.checkout', compact('cartItems', 'totalPrice'));
    // }

    public function place_Order(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address1' => 'required|string',
            'address2' => 'nullable|string',
            'phone' => 'required|numeric',
            'post_code' => 'nullable|string',
            'email' => 'required|string|email',
            'payment_method' => 'required|string',
        ]);

        

        $cartItems = Cart::where('u_id', session('u_id'))->get();
        if ($cartItems->isEmpty()) {
            // return redirect()->route('home')->with('error', 'Your cart is empty.');
        }

        $totalQuantity = $cartItems->sum('quantity');
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $coupon = session('coupon', [
            'discount' => 0,
            'shipping' => 0
        ]);

        $discount = $coupon['discount'];
        $shipping = $coupon['shipping'];
        $finalPrice = $totalPrice - $discount + $shipping;

        $user = User::where('email', session('email'))->first();
        $user_id = $user->u_id;


        $orderDetails = new order_deatils();
        $orderDetails->order_id = '#' . strtoupper(uniqid());
        $orderDetails->totalal_amout = $finalPrice;
        $orderDetails->sub_totale = $totalPrice;
        $orderDetails->discount = $discount;
        $orderDetails->payment_type = $request->payment_method;
        $orderDetails->payment_status = $request->payment_method === 'paypal' ? 'Paid' : 'Unpaid';
        $orderDetails->order_date = now();
        $orderDetails->u_id = $user->u_id;
        $orderDetails->address = $request->input('first_name') . ', ' . $request->input('last_name') . ', ' . $request->input('phone') . ', ' . $request->input('email') . ', ' . $request->input('address1') . ', ' . $request->input('address2') . ', ' . $request->input('post_code');
        $orderDetails->save();

        Cart::where('u_id', session('u_id'))->delete();

        session()->forget('cart');
        session()->forget('coupon');

        return redirect()->route('payment.status')->with('success', 'Your order was successfully placed.');
    }

    public function paymentStatus(Request $request)
    {
        $user = User::where('email', session('email'))->first();
        if (!$user) {
            // return redirect()->route('home')->with('error', 'User not found.');
        }
        $user_id = $user->u_id;
        $orderDetails = order_deatils::where('u_id', $user_id)->latest()->first();
        if (!$orderDetails) {
            // return redirect()->route('home')->with('error', 'No orders found for this user.');
        }
        $order_id = $orderDetails->order_id;
        $payment_status = $orderDetails->payment_status;

        if ($payment_status == 'Paid') {
            $message = 'Payment successfully completed.';
        } elseif ($payment_status == 'Cancelled') {
            $message = 'Payment was cancelled.';
        } else {
            $message = 'Payment status unknown.';
        }

        return view('home.payment', compact('order_id', 'message'));
    }
}
