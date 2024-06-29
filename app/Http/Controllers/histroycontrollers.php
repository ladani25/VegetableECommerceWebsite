<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\order_deatils;
use App\Models\Wishlist;
use App\Models\cart;
use App\Models\User; 
use App\Models\order;
use App\Models\user_orders;

class histroycontrollers extends Controller
{
    public function order_histroy()
    {
        $user = User::where('email', session('email'))->first();
        $user_id = $user->u_id;
        $orderDetails = order_deatils::where('u_id', $user_id)->latest()->get();
        

        $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
        $cartCount = cart::where('u_id', auth()->id())->count();
        //$orderDetails = order_deatils::all();
        return view('home.order_histroy', compact('orderDetails' , 'wishlistCount' , 'cartCount'));

        
    }

    // public function orderDetails($id)
    // {
    //     $order = order_deatils::where('id', $id)->first();
    //     if (!$order) {
    //         return redirect()->route('order.history')->with('error', 'Order not found.');
    //     }
    //     // dd($order);

    //     $user = User::where('email', session('email'))->first();
    //     $user_id = $user->u_id;

    //     // dd($user_id);
    //     $userOrders = user_orders::where('u_id', $request->input('u_id'))
    //     ->where('order_id', $request->input('order_id'))
    //     ->with('Product')  // Assuming there's a relationship defined to fetch related product details
    //     ->get();

    //     return view('home.order_details', compact('order', 'orderProducts','wishlistCount' , 'cartCount'));
    // }

    public function  orderDetails($id)
    {
        // Fetch the order details based on the provided ID
        $order = order_deatils::where('id', $id)->first();
        if (!$order) {
            return redirect()->route('order.history')->with('error', 'Order not found.');
        }

        // Fetch the user details based on the session email
        $user = User::where('email', session('email'))->first();
        if (!$user) {
            return redirect()->route('order.history')->with('error', 'User not found.');
        }
        $user_id = $user->u_id;

        // Fetch user orders based on the user ID and order ID
        $orderProducts = user_orders::where('u_id', $user_id)
            ->where('order_id', $order->id)
            ->with('product')  // Assuming there's a relationship defined to fetch related product details
            ->get();

        // Fetch wishlist and cart counts
        $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
        $cartCount = Cart::where('u_id', auth()->id())->count();

        // Return the view with the necessary data
        return view('home.order_details', compact('order', 'orderProducts', 'wishlistCount', 'cartCount'));
    }

    


}
