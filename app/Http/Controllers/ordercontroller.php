<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ordersitems;
use App\Models\Shipping;
use App\Models\User;
use App\Models\Cart;
use App\Models\order_deatils;
use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;



class ordercontroller extends Controller
{
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
            // $order->p_id = $item->product_id;
            $order->qty = $item->quantity;
            $order->amount = $item->price * $item->quantity;
            $order->u_id = $user->u_id;
            $order->save();
        }
    
        // You might want to clear the cart after placing the order
        // $cart->items()->delete();
    
        return view('home.checkout')->with('success', 'Order placed successfully.');
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


    public function order_details(Request $request)
    {
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
    
        try {
            // Fetch cart items for the current user
            $cartItems = Cart::where('u_id', auth()->id())->whereNull('order_id')->get();
            dd($cartItems);
            // Calculate total price of cart items
            $totalPrice = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
    
            // Fetch shipping price from the request (assuming it's submitted via a form)
            $shippingPrice = Shipping::find($request->shipping)->price;
    
            // Fetch coupon from the request
            $coupon = $request->coupon ?? 0;
    
            // Calculate final total amount
            $finalTotal = $totalPrice + $shippingPrice - $coupon;
    
            // Save order details
            $order = new Order();
            $order->order_number = 'ORD-' . strtoupper(uniqid());
            $order->user_id = auth()->id();
            $order->sub_total = $totalPrice;
            $order->quantity = $cartItems->sum('quantity');
            $order->coupon = $coupon;
            $order->total_amount = $finalTotal;
            $order->status = "new";
            // Assuming payment method is submitted via form
            $order->payment_method = $request->payment_method;
            $order->payment_status = 'Unpaid';
            $order->save();
    
            // Insert order details
            $orderDetails = new ordersitems();
            $orderDetails->order_id = $order->id;
            $orderDetails->total_amount = $finalTotal;
            $orderDetails->sub_total = $totalPrice;
            $orderDetails->discount = $coupon;
            $orderDetails->payment_type = $request->payment_method;
            $orderDetails->payment_status = 'Unpaid';
            $orderDetails->order_date = now();
            $orderDetails->u_id = auth()->id();
            $orderDetails->save();
    
            // Update cart with order_id
            Cart::where('u_id', auth()->id())->whereNull('order_id')->update(['order_id' => $order->id]);
    
            // Clear cart and coupon session
            Session::forget('cart');
            Session::forget('coupon');
    
            // Pass necessary data to the view
            return view('home.checkout', compact('cartItems', 'totalPrice', 'coupon', 'shippingPrice', 'finalTotal'))
                ->with('success', 'Your product was successfully placed in the order.');
        } catch (\Exception $e) {
            // Log the error or handle it accordingly
            return view('home.checkout', compact('cartItems', 'totalPrice', 'coupon', 'shippingPrice', 'finalTotal'))->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }
    
    
    public function placeorder(Request $request)
    {
        $order = Order::find($request->o_id);
        $order->status = "process";
        $order->save();
    }

    

    public function orders(Request $request)
    {
        $user = User::where('email', session('email'))->first();
        // dd($user);
        $userId = session('u_id');

        // $cartItems = cart::where('u_id', $userId)->get();
        // $order  = DB::table('order')
        // ->join('carts', 'order.order_id', '=', 'carts.id')
        // // ->join('user', 'wishlists.u_id', '=', 'user.u_id')
        // ->where('order.u_id')
        // ->select('order.*', 'carts.*')
        // ->get();
        $cartItems = Cart::where('u_id', $userId)->get();

        // Assuming you have an Order model and an orders table
        $order = Order::create([
            'u_id' => $userId,
            'amount' => $request->amount,
            'quantity' => $request->quantity,
        ]);

        dd($cartItems);

        // Insert order details
        foreach ($cartItems as $item) {
            DB::table('orde')->insert([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);

            // Optionally, clear the cart after processing the order
            $item->delete();
        }

        return view('home.checkout')->with('success', 'Order placed successfully!');
    }     
   
}
