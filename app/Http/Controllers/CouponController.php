<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Cart;
use App\Models\order;
use App\Models\User;
use App\Models\Product;
use App\Models\user_orders;
use Illuminate\Support\Facades\DB;
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


     
    // public function checkout(Request $request)
    // {
    //     // dd($request->all());
    //     $cartItems = Cart::where('u_id', session('u_id'))->get();

    //     if ($cartItems->isEmpty()) {
    //         // return redirect()->route('home')->with('error', 'Your cart is empty.');
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
    
    //         // Retrieve the user's ID

    //         // $user_orders = new user_orders();
    //         // // $user_orders->order_id = $order_id;
    //         // $user_orders->p_id = $products_id;
    //         // $user_orders->u_id = $user_id;
    //         // $user_orders->u_quantity = $totalQuantity;
    //         // $user_orders->save();

    //     // Create the order
    //     $order = new order();
    //     $order->u_id = $user->u_id;
    //     $order->qty = $totalQuantity;
    //     $order->amount = $totalPrice;
    //     $order->save();

    //     foreach ($cartItems as $item) {
    //         $userOrder = new user_orders;
    //         $userOrder->order_id = $order_id;
    //         $userOrder->p_id = $item->p_id;
    //         $userOrder->u_id = $item->u_id;
    //         $userOrder->u_quantity = $item->quantity;
    //         $userOrder->save();

    //         // dd($userOrder);
    //     }

    //     // $this->updateProductQuantities($request->id);
    //     // $this->updateProductQuantities($order->id);
    //     $this->addUserOrders($cartItems, $order->id);
    //     // dd($cartItems);
    //     // $this->user_orders($request);

    //    Session::put('order', [
    //        'amount' => $totalPrice
    //    ]);
    //     return view('home.checkout', compact('cartItems', 'totalPrice', 'discount', 'shipping', 'finalPrice'));
    // }


    // private function addUserOrders($cartItems, $order_id)
    // {
    //     foreach ($cartItems as $item) {
    //         $userOrder = new  user_orders();
    //         $userOrder->order_id = $order_id;
    //         $userOrder->p_id = $item->p_id;
    //         $userOrder->u_id = $item->u_id;
    //         $userOrder->u_quantity = $item->quantity;
    //         $userOrder->save();
    //         // dd($userOrder);
    //     }
    // }

    
    // public function user_orders(Request $request)
    // {
    //     $user = User::where('email', session('email'))->first();
    //     if (!$user) {
    //         // return redirect()->back()->with('error', 'User not found.');
    //     }

    //     $user_id = $user->u_id;
    //     $user_orders = DB::table('user_orders')
    //         ->join('products', 'user_orders.p_id', '=', 'products.p_id')
    //         ->where('user_orders.u_id', $user_id)
    //         ->select('user_orders.*', 'products.*', DB::raw('user_orders.u_quantity * products.price as total_price'))
    //         ->get();
    //     // dd($user_orders); 
    //     $totalQuantity = $user_orders->sum('u_quantity');

    //     $products_id = $request->product_id;
    //     if (Product::find($products_id)) {
    //         $userOrder = new  user_orders();
    //         $userOrder->order_id = $request->order_id;
    //         $userOrder->p_id = $products_id;
    //         $userOrder->u_id = $user_id;
    //         $userOrder->u_quantity = $totalQuantity;
    //         $userOrder->save();
 
    //         return redirect()->back()->with('success', 'Product added to cart.');
    //     } else {
    //         return redirect()->back()->with('error', 'Product not found.');
    //     }
    // }
  

    public function checkout(Request $request)
    {
        $cartItems = Cart::where('u_id', session('u_id'))->get();
        // dd($cartItems);
        if ($cartItems->isEmpty()) {
            // Handle empty cart scenario
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
        if (!$user) {
            // return redirect()->route('home')->with('error', 'User not found.');
        }

        // Create the order
        $order = new Order();
        $order->u_id = $user->u_id;
        $order->qty = $totalQuantity;
        $order->amount = $finalPrice; // Use final price after applying discount and shipping
        $order->save();

        // Add items to user_orders table
        foreach ($cartItems as $item) {
            $userOrder = new user_orders();
            $userOrder->order_id = $order->id; // Assuming order_id is the foreign key in user_orders table
            $userOrder->p_id = $item->p_id;
            $userOrder->u_id = $item->u_id;
            $userOrder->u_quantity = $item->quantity;
            $userOrder->save();
        }

        // Optionally, update product quantities or perform any other tasks here

        // Clear cart after checkout
        Cart::where('u_id', session('u_id'))->delete();

        Session::put('order', [
            'amount' => $finalPrice
        ]);

        return view('home.checkout', compact('cartItems', 'totalPrice', 'discount', 'shipping', 'finalPrice'));
    }


}