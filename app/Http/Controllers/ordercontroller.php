<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use App\Models\order_deatils;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
class ordercontroller extends Controller
{
   


    // public function  place_order(Request $request)
    // {

    //     // Validate the request
    //     $request->validate([
    //         'first_name' => 'required|string',
    //         'last_name' => 'required|string',
    //         'address1' => 'required|string',
    //         'address2' => 'nullable|string',
    //         'coupon' => 'nullable|numeric',
    //         'phone' => 'required|numeric',
    //         'post_code' => 'nullable|string',
    //         'email' => 'required|string',
    //         'payment_method' => 'required|string',
    //     ]);

    //     $cartItems = Cart::where('u_id', session('u_id'))->get();

    //     if ($cartItems->isEmpty()) {
    //     }

    //     $totalQuantity = $cartItems->sum('quantity');
    //     $totalPrice = $cartItems->sum(function ($item) {
    //         return $item->quantity * $item->price;
    //     });

    //     $coupon = session('coupon', [
    //         'discount' => 0,
    //         'shipping' => 0
    //     ]);

    //     $discount = $coupon['discount'];
    //     $shipping = $coupon['shipping'];
    //     $finalPrice = $totalPrice - $discount + $shipping;

    //     // Optionally, save order items or any other order-related data here


    //     $user = auth()->user();
    //     $totalQuantity = $request->input('totalQuantity');
    //     $totalPrice = $request->input('totalPrice');
        

    //     $user = User::where('email', session('email'))->first();
    //     $user_id = $user->u_id;

    //         $order_deatils =  new order_deatils();
    //         // $order_deatils->order_id = $request->order_id;
    //         // $order_deatils->order_number = 'ORD-' . strtoupper(uniqid());
    //         $order_deatils->totalal_amout=  $finalPrice;
    //         $order_deatils->sub_totale= $totalPrice;
    //         $order_deatils->discount = $discount;
    //         $order_deatils->payment_type = $request->payment_method;
    //         $order_deatils->payment_status = 'Unpaid';
    //         $order_deatils->order_date = now();
    //         $order_deatils->u_id =  $user_id ->u_id;

    //         $order_deatils->save();

    //         return view('payment', compact('totalQuantity', 'totalPrice', 'discount', 'shipping', 'finalPrice'));

    // }

    public function  place_order(Request $request)
    {
        // Validate the request
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address1' => 'required|string',
            'address2' => 'nullable|string',
            'coupon' => 'nullable|numeric',
            'phone' => 'required|numeric',
            'post_code' => 'nullable|string',
            'email' => 'required|string|email',
            'payment_method' => 'required|string',
        ]);
    
        //Fetch cart items for the current user
        $cartItems = Cart::where('u_id', session('u_id'))->get();
    
        if ($cartItems->isEmpty()) {
            // return redirect()->route('home')->with('error', 'Your cart is empty.');
        }
    
        $totalQuantity = $cartItems->sum('quantity');
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    
        $coupon = session('coupon', [
            'discount' => 0,
            'shipping' => 0
        ]);
    
        $discount = $coupon['discount'];
        $shipping = $coupon['shipping'];
        $finalPrice = $totalPrice - $discount + $shipping;
    
        // Save order details
        $user = User::where('email', session('email'))->first();
        $user_id = $user->u_id;
    
        $orderDetails = new order_deatils();
        $orderDetails->order_id	 = '#' . strtoupper(uniqid());
        $orderDetails->totalal_amout = $finalPrice; // Correctly bind final price
        $orderDetails->sub_totale = $totalPrice;
        $orderDetails->discount	 = $discount;
        $orderDetails->payment_type = $request->payment_method;
        $orderDetails->payment_status = 'Unpaid';
        $orderDetails->order_date = now();
        $orderDetails->u_id = $user->u_id;
        $orderDetails->address = $request->input('first_name') . ', '. $request->input('last_name') . ', '. $request->input('phone') . ', '.$request->input('email') . ', '. $request->input('address1') . ', ' . $request->input('address2'). ', '. $request->input('post_code');

        $orderDetails->save();
        // Clear cart and coupon session
        // Session::forget('cart');
        // Session::forget('coupon');
    
        return view('home.payment')->with('success', 'Your order was successfully placed.');
    }
    


    public function payment(Request $request)
    {
        // Validate the payment request
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'contact_number' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Initialize Razorpay API with your API key and secret
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        // Create an order
        $order = $api->order->create([
            'amount' => $request->amount * 100, // Amount in paisa
            'currency' => $request->currency,
            'receipt' => uniqid(),
            'payment_capture' => 1, // Auto capture payment
        ]);

        // Return the order details and Razorpay key to the payment form
        return view('razorpay.payment', [
            'order' => $order,
            'key' => env('RAZORPAY_KEY'),
            'name' => $request->name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'description' => $request->description,
        ]);
    }

    public function success(Request $request)
    {
        // Handle successful payment
        return view('razorpay.success', ['payment' => $request->all()]);
    }

    public function failure(Request $request)
    {
        // Handle failed payment
        return view('razorpay.failure', ['payment' => $request->all()]);
    }


}
