<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ordersitems;
use App\Models\Shipping;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Coupon;
use Notification;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ordercontroller extends Controller
{
       public function order(Request $request)
    {
        // dd($request->all());
        $cart_id = $request->cart_id;
        // dd($cart_id);
        $cart = cart::find($cart_id); // Assuming you have a Cart model and you can retrieve a cart by its ID

        if (!$cart) {
            return redirect()->back()->with('error', 'Cart not found.'); // Corrected error message
        }

        $user = User::where('email', session('email'))->first();
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $order = new Order();

        $user_id = $user->u_id; 
        $products_id = $cart->p_id; 

        
        foreach ($cart->items as $item) {
            // $order->p_id = $item->product_id;
            $order->qty = $item->quantity; // Assuming each item has a quantity
            $order->amount = $item->price * $item->quantity; // Assuming you calculate amount based on price and quantity
            $order->u_id = $user_id;
            $order->save();
        }

        return view('home.checkout')->with('success', 'Order placed successfully.'); // Corrected success message
    }

    // public function order_deatils(Request $request)
    // {
    //     $cart_id = $request->cart_id;

    //     $cart = Cart::find($cart_id); // Assuming you have a Cart model and you can retrieve a cart by its ID

    //     if (!$cart) {
    //         return redirect()->back()->with('error', 'Cart not found.'); // Corrected error message
    //     }

    //     $user = User::where('email', session('email'))->first();
        
    //     if (!$user) {
    //         return redirect()->back()->with('error', 'User not found.');
    //     }

    //     $ordersitems= new ordersitems(); // Corrected object instantiation

    //     $user_id = $user->u_id; // Assuming the user ID column is 'id', adjust if it's 'u_id'
    //     $products_id = $cart->p_id; // Assuming this is how you get product IDs from the cart

    //     // Assuming you need to loop through cart items
    //     foreach ($cart->items as $item) {
    //         // $order->p_id = $item->product_id;
    //         $ordersitems->qty = $item->quantity; // Assuming each item has a quantity
    //         $ordersitems->amount = $item->price * $item->quantity; // Assuming you calculate amount based on price and quantity
    //         $ordersitems->u_id = $user_id;
    //         $->save();
 
    //     }

    // }


    public function order_deatils(Request $request)
    {
        // Validate the request data
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address1' => 'required|string',
            'address2' => 'nullable|string',
            'coupon' => 'nullable|numeric',
            'phone' => 'required|numeric',
            'post_code' => 'nullable|string',
            'email' => 'required|string'
        ]);
    
        // Check if the cart is empty
        if (Cart::where('u_id', auth()->id())->whereNull('order_id')->count() == 0) {
            return redirect()->back()->with('error', 'Cart is Empty !');
        }
    
        // Calculate total price of cart items
        $cartItems = Cart::where('u_id', auth()->id())->whereNull('order_id')->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    
        // Fetch shipping price based on selected shipping method
        $shippingPrice = Shipping::find($request->shipping)->price;
    
        // Create a new order
        $order = new Order();
        $order->order_number = 'ORD-' . strtoupper(uniqid());
        $order->user_id = auth()->id();
        $order->sub_total = $totalPrice;
        $order->quantity = $cartItems->sum('quantity'); // Sum of quantities of all items
        $order->coupon = $request->coupon ?? 0; // Set coupon value if provided
        $order->total_amount = $totalPrice + $shippingPrice - $order->coupon; // Calculate total amount with shipping and discount
        $order->status = "new";
    
        // Determine payment method and status
        if ($request->payment_method == 'paypal') {
            $order->payment_method = 'paypal';
            $order->payment_status = 'paid';
        } else {
            $order->payment_method = 'cod';
            $order->payment_status = 'Unpaid';
        }
    
        $order->save();
    
        // Insert order details
        $orderDetails = new ordersitems();
        $orderDetails->order_id = $order->id;
        $orderDetails->total_amount = $order->total_amount;
        $orderDetails->sub_total = $order->sub_total;
        $orderDetails->discount = $order->coupon;
        $orderDetails->payment_type = $order->payment_method;
        $orderDetails->payment_status = $order->payment_status;
        $orderDetails->order_date = now();
        $orderDetails->u_id = auth()->id();
        $orderDetails->save();
    
        // Handle payment redirection
        if ($request->payment_method == 'paypal') {
            return redirect()->route('payment')->with(['id' => $order->id]);
        } else {
            // Clear cart and coupon session
            Session::forget('cart');
            Session::forget('coupon');
        }
    
        // Update cart with order_id
        Cart::where('u_id', auth()->id())->whereNull('order_id')->update(['order_id' => $order->id]);
    
        return redirect()->route('home')->with('success', 'Your product successfully placed in order');
    }

    public function placeorder(Request $request)
    {
        $order = Order::find($request->o_id);
        $order->status = "process";
        $order->save();
    }

    // public function checkout(Request $request) 
    // {
    //     // dd($request->all());
    //     $userId = auth()->id('u_id');
    //     dd($userId);
    //     $cartItems = cart::where('u_id', $userId)->get();

    //     $totalPrice = $cartItems->sum('total_price');

    //     // Retrieve the current coupon details from the session if they exist
    //     $coupon = Session::get('coupon', [
    //         'discount' => 0,
    //         'shipping' => 0
    //     ]);


    //     $discount = $coupon['discount'];
    //     $shipping = $coupon['shipping'];

    //     // Calculate the final total price
    //     $totalPrice = $totalPrice - $discount + $shipping;

    //     return view('home.checkout', compact('cartItems', 'totalPrice', 'discount', 'shipping', 'totalPrice'));
    // }
    
}