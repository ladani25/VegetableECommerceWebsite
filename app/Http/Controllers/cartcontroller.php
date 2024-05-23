<?php

namespace App\Http\Controllers;
use App\Models\cart;
use App\Models\product;
use App\Models\wishlist;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class cartcontroller extends Controller
{
    // public function cart()
    // {
    //     // Fetch the user
    //     $user = User::where('email', session('email'))->first();
    
    //     if ($user) {
    //         // Retrieve the user's ID
    //         $user_id = $user->u_id;
    
    //         // Fetch cart items with product details
    //         $cartItems = DB::table('carts')
    //             ->join('products', 'carts.p_id', '=', 'products.p_id')
    //             ->where('carts.u_id', $user_id)
    //             ->select('carts.*', 'products.*')
    //             ->select(DB::raw('carts.quantity * products.price as total_price'))
    //             ->get();
    
    //         // Calculate total quantity and total price
    //         // $totalQuantity = $cartItems->sum('quantity');
    //         // $totalPrice = $cartItems->sum(function ($item) {
    //         //     return $item->price * $item->quantity;
    //         // });
    
    //         // Pass the cart items, total quantity, and total price to the view
    //         return view('home.cart', compact('cartItems'));
    //     } else {
    //         // Handle the case where the user is not found
    //         return redirect()->back()->with('error', 'User not found.');
    //     }
    // }
    
    
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
    
   


    
  // Add this line at the top of your controller file

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
    


//     public function addcart(Request $request)
// {
//     // Retrieve the product ID from the request
//     $products_id = $request->input('product_id');

//     // Check if the product exists
//     $product = Product::find($products_id);

//     if ($product) {
//         // Retrieve the authenticated user's ID
//         $user_id = auth()->id();

//         // Check if the product is already in the user's cart
//         $existingCartItem = Cart::where('p_id', $products_id)
//                                 ->where('u_id', $user_id)
//                                 ->first();

//         if ($existingCartItem) {
//             return redirect()->back()->with('success', 'Product is already in your cart.');
//         }

//         // Add the product to the cart
//         $cart = new Cart();
//         $cart->p_id = $products_id;
//         $cart->u_id = $user_id;
//         $cart->save();

//         return redirect()->back()->with('success', 'Product added to cart.');
//     } else {
//         return redirect()->back()->with('error', 'Product not found.');
//     }
// }




    public function removecart($id)
    {
        $cart = cart::find($id);
        if ($cart) {
            $cart->delete();
            return redirect()->back()->with('success', 'Product removed from cart.');
        }
        return redirect()->back()->with('error', 'Product not found in cart.');
    }
   
    // public function updateCart(Request $request, $id)
    // {
    //     $cartItem = cart::find($id);
    //     if (!$cartItem) {
    //         return redirect()->back()->with('error', 'Cart item not found.');
    //     }

    //     $cartItem->quantity = $request->quantity;
    //     $cartItem->save();

    //     return redirect()->back()->with('success', 'Cart updated successfully.');
    // }

    // public function updateCart(Request $request, $id)
    // {
    //     // Validate the incoming request data
    //     $request->validate([
    //         'quantity' => 'required|integer|min=1'
    //     ]);
    
    //     // Fetch the cart item by ID
    //     $cartItem = DB::table('carts')->where('id', $id)->first();
    
    //     if ($cartItem) {
    //         // Update the cart item quantity
    //         DB::table('carts')
    //             ->where('id', $id)
    //             ->update(['quantity' => $request->quantity]);
    
    //         // Redirect back to the cart with a success message
    //         return redirect()->back()->with('success', 'Cart updated successfully.');
    //     } else {
    //         // Handle the case where the cart item is not found
    //         return redirect()->back()->with('error', 'Cart item not found.');
    //     }
    // }




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
    //     $request->validate([
    //         'quantity' => 'required|integer|min:1|max:10', // Adjust validation rules as needed
    //     ]);
    
    //     // Find the cart item by ID
    //     $cartItem =  cart::find($itemId);
    
    //     if ($cartItem) {
    //         // Update the quantity
    //         $cartItem->quantity = $request->input('quantity');
    //         $cartItem->save();
    
    //         // Optionally, you can return a response indicating success
    //         return redirect()->back()->with('success', 'Cart item updated successfully.');
    //     } else {
    //         // Handle the case where the cart item is not found
    //         return redirect()->back()->with('error', 'Cart item not found.');
    //     }
    // }

    public function updateCart(Request $request, $itemId)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'qty' => 'required|integer|min:1|max:10', // Adjust validation rules as needed
        ]);

        // Find the cart item by ID
        $cartItem = cart::find($itemId);

        if ($cartItem) {
            // Update the quantity
            $cartItem->quantity = $validatedData['qty']; // Use the validated quantity from the request
            $cartItem->save();

            // Optionally, you can return a response indicating success
            return redirect()->back()->with('success', 'Cart item updated successfully.');
        } else {
            // Handle the case where the cart item is not found
            return redirect()->back()->with('error', 'Cart item not found.');
        }
    }
}



