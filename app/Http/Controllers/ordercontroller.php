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
        // $request->validate([
                $validatedData = $request->validate([
        // 'first_name' => 'required|string|
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

        
        $order = session('order', [
            'amount' =>  $totalPrice
         ]);

        $orderDetails = new order_deatils();
        $orderDetails->order_id = '#' . strtoupper(uniqid());
        $orderDetails->totalal_amout = $finalPrice;
        $orderDetails->sub_totale = $totalPrice;
        $orderDetails->discount = $discount;
        $orderDetails->payment_type = $request->payment_method;
        $orderDetails->payment_status = $request->payment_method === 'razorpay' ? 'Paid' : 'Unpaid';
        $orderDetails->order_date = now();
        $orderDetails->u_id = $user->u_id;
        // $order->payment_id = $validatedData['payment_id'] ?? null;;
        // $orderDetails->payment_id = $request->input('payment_id');

        if (isset($validatedData['payment_id'])) {
            $orderDetails->payment_id = $validatedData['payment_id'];
        }
        $orderDetails->address = $request->input('first_name') . ', ' . $request->input('last_name') . ', ' . $request->input('phone') . ', ' . $request->input('email') . ', ' . $request->input('address1') . ', ' . $request->input('address2') . ', ' . $request->input('post_code');
        $orderDetails->save();

        // cart::where('u_id', session('u_id'))->delete();

        // $this->updateProductQuantities($request->id);
        
        // dd($request->id);

        cart::where('u_id',$orderDetails->u_id)->delete();

        // session()->forget('cart');
        // session()->forget('coupon');

        return redirect()->route('payment.status')->with('success', 'Your order was successfully placed.');
    }



//     public function place_Order(Request $request)
// {
//     // Validate the request data
//     $validatedData = $request->validate([
//         'first_name' => 'required|string|max:255',
//         'last_name' => 'required|string|max:255',
//         'phone' => 'required|string|max:20',
//         'email' => 'required|email|max:255',
//         'address1' => 'required|string|max:255',
//         'address2' => 'nullable|string|max:255',
//         'post_code' => 'nullable|string|max:20',
//         'payment_method' => 'required|string|in:razorpay,cheque',
//         'payment_id' => 'nullable|string'  // Ensure payment_id is nullable
//     ]);

//     try {
//         // Create a new Order instance
//         $order = new order_deatils;
//         $order->order_id = Session::get('order_id');
//         $order->totalal_amout = 15; // Replace with actual value or calculate accordingly
//         $order->sub_totale = 25; // Replace with actual value or calculate accordingly
//         $order->discount = 20.00; // Replace with actual value or calculate accordingly
//         $order->payment_type = $validatedData['payment_method'];
//         $order->payment_status = 'Paid';
//         $order->order_date = now();
//         $order->u_id = auth()->user()->id; // Example user ID
//         $order->payment_id = $validatedData['payment_id'] ?? null; // Use null coalescing operator to handle potential null value
//         $order->address = $request->input('first_name') . ', ' . $request->input('last_name') . ', ' . $request->input('phone') . ', ' . $request->input('email') . ', ' . $request->input('address1') . ', ' . $request->input('address2') . ', ' . $request->input('post_code');
//         $order->updated_at = now();
//         $order->created_at = now();
        
//         $order->save();

//         return redirect()->route('order-success')->with('success', 'Order placed successfully!');
//     } catch (\Exception $e) {
//         return redirect()->back()->with('error', 'Failed to place order: ' . $e->getMessage());
//     }
// }


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


   
    // public function updateProductQuantities($order_id)
    // {
    //     $orderItems = cart::where('id', $order_id)->get();
    //     dd($orderItems);

    //     foreach ($orderItems as $orderItem) {
    //         $product = Product::find($orderItem->p_id);
    //         // dd($product);

    //         if ($product) {
    //             $product->p_quantity -= $orderItem->quantity;
    //             $product->save();
    //         }
    //     }
    // }
    

}