<?php

namespace App\Http\Controllers;
use App\Models\cart;
use App\Models\product;

use App\Models\wishlist;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cartcontroller extends Controller
{
    public function cart()
    {
        // Fetch the user
        $user = User::where('email', session('email'))->first();
    
        if ($user) {
            // Retrieve the user's ID
            $user_id = $user->u_id;
    
            // Fetch cart items with product details and calculate total price for each item
            $cartItems = DB::table('carts')
                ->join('products', 'carts.p_id', '=', 'products.p_id')
                ->where('carts.u_id', $user_id)
                ->select('carts.*', 'products.*', DB::raw('carts.quantity * products.price as total_price'))
                ->get();
    
            // Calculate total quantity and total price
            $totalQuantity = $cartItems->sum('quantity');
            $totalPrice = $cartItems->sum('total_price');
    
            // Pass the cart items, total quantity, and total price to the view
            return view('home.cart', compact('cartItems', 'totalQuantity', 'totalPrice'));
        } else {
            // Handle the case where the user is not found
            return redirect()->back()->with('error', 'User not found.');
        }
    }

    public function addcart(Request $request)
    {
        // dd($request->all());
              
        $products_id = $request->product_id;
        
        if(Product::find($products_id)) {
            $user = User::where('email', session('email'))->first();
            if($user) {
                $user_id = $user->u_id; // Assuming the primary key of the user table is 'id'
                $cart = new Cart();
                $cart->p_id = $products_id;
                $cart->u_id = $user_id;
                $cart->save();
                return redirect()->back()->with('success', 'Product added to cart.');
            } else {
                return redirect()->back()->with('error', 'User not found.');
            }
        } else {
            return redirect()->back()->with('error', 'Product not found.');
        }
    }
    
    public function removecart($id)
    {
        $cart = cart::find($id);
        if ($cart) {
            $cart->delete();
            return redirect()->back()->with('success', 'Product removed from cart.');
        }
        return redirect()->back()->with('error', 'Product not found in cart.');
    }
   
   
    public function removeall()
    {
        $carts = cart::all();
        foreach ($carts as $cart) {
            $cart->delete();
        }
        return redirect()->back()->with('success', 'All products removed from cart.');
    }


    // public function updateCart(Request $request, $itemId)
    // {
    //     // Validate the incoming request data
    //     $validatedData = $request->validate([
    //         'qty' => 'required|integer|min:1|max:100',
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

    //         $itemTotalPrice = $cartItem->quantity * $cartItem->product->price;

    //         // Return a JSON response indicating success
    //         return response()->json([
    //             'success' => true,
    //             'itemTotalPrice' => $itemTotalPrice,
    //             'totalQuantity' => $totalQuantity,
    //             'totalPrice' => $totalPrice,
    //         ]);
    //     } else {
    //         // Handle the case where the cart item is not found
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Cart item not found.'
    //         ]);
    //     }
    // }

// public function updateCart(Request $request, $itemId)
// {
//     $validatedData = $request->validate([
//         'qty' => 'required|integer|min:1|max:100',
//     ]);

//     $cartItem = Cart::find($itemId);

//     if ($cartItem) {
//         $cartItem->quantity = $validatedData['qty'];
//         $cartItem->save();

//         $user_id = $cartItem->u_id;
//         $cartItems = Cart::where('u_id', $user_id)->get();
//         $totalQuantity = $cartItems->sum('quantity');
//         $totalPrice = $cartItems->sum(function ($item) {
//             return $item->quantity * $item->product->price;
//         });

//         $itemTotalPrice = $cartItem->quantity * $cartItem->product->price;

//         // $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();
//         // if (!$coupon) {
//         //     Session::put('coupon', [
//         //         'discount' => 0,
//         //         'shipping' => 0
//         //     ]);
        
//         // }

//         // $coupon = Session::get('coupon');
    
//         // $totalPrice = Cart::where('u_id', session('u_id'))
//         //     ->join('products', 'carts.p_id', '=', 'products.p_id')
//         //     ->sum('products.price');
    
//         // $discount = $coupon->type == 'percent' ? $totalPrice * ($coupon->amount / 100) : $coupon->amount;
//         // $shipping = 10; 
    

//         return response()->json([
//             'success' => true,
//             'itemTotalPrice' => $itemTotalPrice,
//             'totalQuantity' => $totalQuantity,
//             // 'discount' => $discount,
//             // 'shipping' => $shipping,
//             'totalPrice' => $totalPrice,
//         ]);
//     } else {
//         return response()->json([
//             'success' => false,
//             // 'discount' => 0,
//             // 'shipping' => 0,
//             'message' => 'Cart item not found.'
//         ]);
//     }
// }


public function aaupdateCart(Request $request, $itemId)
{
    $validatedData = $request->validate([
        'qty' => 'required|integer|min:1|max:100',
    ]);

    $cartItem = Cart::find($itemId);

    if ($cartItem) {
        $cartItem->quantity = $validatedData['qty'];
        $cartItem->save();

        $user_id = $cartItem->u_id;
        $cartItems = Cart::where('u_id', $user_id)->get();
        $totalQuantity = $cartItems->sum('quantity');
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $itemTotalPrice = $cartItem->quantity * $cartItem->product->price;

        $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();
        if (!$coupon) {
            $discount = 0;
            $shipping = 0
            ;
        } else {
            $discount = $coupon->type == 'percent' ? $totalPrice * ($coupon->amount / 100) : $coupon->amount;
            $shipping = 10; // Set shipping to a fixed value for now.
        }

        $finalTotal = $totalPrice - $discount + $shipping;

        return response()->json([
            'success' => true,
            'itemTotalPrice' => $itemTotalPrice,
            'totalQuantity' => $totalQuantity,
            'discount' => $discount,
            'shipping' => $shipping,
            'totalPrice' => $finalTotal,
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Cart item not found.'
        ]);
    }
}

public function updateCart(Request $request, $itemId)
{
    $validatedData = $request->validate([
        'qty' => 'required|integer|min:1|max:100',
    ]);

    $cartItem = Cart::find($itemId);

    if ($cartItem) {
        $cartItem->quantity = $validatedData['qty'];
        $cartItem->save();

        $user_id = $cartItem->u_id;
        $cartItems = Cart::where('u_id', $user_id)->get();
        $totalQuantity = $cartItems->sum('quantity');
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $itemTotalPrice = $cartItem->quantity * $cartItem->product->price;

        // Calculate the discount if a coupon is provided
        $discount = 0;
        $shipping = 0; // Set shipping to a fixed value for now.
        
        if ($request->has('coupon_code')) {
            $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();
            if ($coupon) {
                if ($coupon->type == 'percent') {
                    $discount = $totalPrice * ($coupon->amount / 100);
                } else {
                    $discount = $coupon->amount;
                }
            }
        }

        $finalTotal = $totalPrice - $discount + $shipping;

        return response()->json([
            'success' => true,
            'itemTotalPrice' => $itemTotalPrice,
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
            'discount' => $discount,
            'shipping' => $shipping,
            'finalTotal' => $finalTotal,
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Cart item not found.'
        ]);
    }
}



}