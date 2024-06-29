<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\order_deatils;
use App\Models\User;
use App\Models\Product;
use App\Models\order;
use App\Models\cart;
// use Razorpay\Api\Api;
// use Session;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
 
    public function place_Order(Request $request)
    {
        
            $validatedData = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address1' => 'required|string',
            'address2' => 'nullable|string',
            'phone' => 'required|numeric',
            'post_code' => 'nullable|string',
            'email' => 'required|string|email',
            'payment_method' => 'required|string',
            'payment_id' => 'nullable|string'
        ]);

        $user = User::where('email', session('email'))->first();
        $user_id = $user->u_id;
   
        $order = session('order', [
            // 'amount' =>  $totalPrice
            $totalPrice = $request->input('totalPrice')
         ]);
         
        // dd($order);

        $coupon = session('coupon', [
            'discount' => 0,
            'shipping' => 0
        ]);

        $discount = $coupon['discount'];
        $shipping = $coupon['shipping'];
        $totalPrice =  $order['amount'];
        $finalPrice =$totalPrice - $discount + $shipping;

        $orderId = $order->order_id;

        $orderDetails = new order_deatils();
        $orderDetails->order_id = $order->order_id;
        $orderDetails->order_num = '#' . strtoupper(uniqid());
        $orderDetails->totalal_amout = $finalPrice;
        $orderDetails->sub_totale = $totalPrice;
        $orderDetails->discount = $discount;
        $orderDetails->payment_type = $request->payment_method;
        $orderDetails->payment_status = $request->payment_method === 'razorpay' ? 'Paid' : 'Unpaid';
        $orderDetails->order_date = now();
        $orderDetails->u_id = $user->u_id;
        
        if (isset($validatedData['payment_id'])) {
            $orderDetails->payment_id = $validatedData['payment_id'];
        }
        $orderDetails->address = $request->input('first_name') . ', ' . $request->input('last_name') . ', ' . $request->input('phone') . ', ' . $request->input('email') . ', ' . $request->input('address1') . ', ' . $request->input('address2') . ', ' . $request->input('post_code');
        $orderDetails->save();

        // dd($request->id);
        cart::where('u_id',$orderDetails->u_id)->delete();

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