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
        $cartItems = session()->get('cart', []);
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

                // Product::where('p_quantity', $cart->quantity)->update();

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






  // In your update-cart route handler
public function updateCart(Request $request, $itemId) {
    // dd($request->all());
    $qty = $request->input('qty');
    $couponCode = $request->input('coupon_code');
    $productId = $request->input('product_id');
    $qtyChange = $request->input('qty_change');

    // dd($qtyChange);

    // Fetch the cart item and product from the database
    $cartItem = Cart::find($itemId);
    $product = Product::find($productId);

    if (!$cartItem || !$product) {
        return response()->json(['success' => false, 'message' => 'Item or Product not found']);
    }

    // Update the cart item quantity
    $cartItem->quantity = $qty;
    $cartItem->save();

    // Update the product quantity
    $product->p_quantity -= $qtyChange;
    $product->save();

    // Calculate new totals and other necessary details
    // ... (your existing calculations for total price, discount, etc.)

    return response()->json([
        'success' => true,
        'itemTotalPrice' => $itemTotalPrice,
        'totalQuantity' => $totalQuantity,
        'totalPrice' => $totalPrice,
        'discount' => $discount,
        'shipping' => $shipping,
        'finalTotal' => $finalTotal,
        'productQuantity' => $product->quantity
    ]);
}

    


// public function updateCart(Request $request, $itemId)
// {
//     $validatedData = $request->validate([
//         'qty' => 'required|integer|min:1|max:100',
//     ]);

//     $cartItem = Cart::find($itemId);

//     if ($cartItem) {
//         // Check if the product is available in sufficient quantity
//         $product = Product::find($cartItem->p_id);

//         if (!$product || $product->p_quantity < $validatedData['qty']) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Product is out of stock or quantity exceeds available stock.'
//             ]);
//         }

//         // Update cart item quantity
//         $cartItem->quantity = $validatedData['qty'];
//         $cartItem->save();

//         // Update product quantities after successful update
//         $error = $this->updateProductQuantities($cartItem->id);

//         if ($error) {
//             return response()->json([
//                 'success' => false,
//                 'message' => $error
//             ]);
//         }

//         // Recalculate totals
//         $user_id = $cartItem->u_id;
//         $cartItems = Cart::where('u_id', $user_id)->get();
//         $totalQuantity = $cartItems->sum('quantity');
//         $totalPrice = $cartItems->sum(function ($item) {
//             return $item->quantity * $item->product->price;
//         });

//         // Retrieve discount and shipping details from session
//         $couponDetails = Session::get('coupon', [
//             'discount' => 0,
//             'shipping' => 0,
//         ]);

//         $discount = $couponDetails['discount'];
//         $shipping = $couponDetails['shipping'];

//         $finalTotal = $totalPrice - $discount + $shipping;

//         return response()->json([
//             'success' => true,
//             'totalQuantity' => $totalQuantity,
//             'totalPrice' => $totalPrice,
//             'discount' => $discount,
//             'shipping' => $shipping,
//             'finalTotal' => $finalTotal,
//         ]);
//     } else {
//         return response()->json([
//             'success' => false,
//             'message' => 'Cart item not found.'
//         ]);
//     }
// }



    //  public function updateProductQuantities($order_id)
    // {
        
    //     $cartItems = Cart::where('id', $order_id)->get();
    
    //     foreach ($cartItems as $item) {
    //         $product = Product::find($item->p_id);
    
    //         if ($product) {
    //             if ($product->p_quantity >= $item->quantity) {
    //                 $product->p_quantity -= $item->quantity;
    //                 $product->save();
    //             } else {
    //                 // Handle out of stock scenario
    //                 return redirect()->back()->with('error', 'One or more items in your cart are out of stock.');
    //             }
    //         } else {
    //             // Handle case where product is not found (optional)
    //             return redirect()->back()->with('error', 'Product not found.');
    //         }
    //     }
    
    //     // Continue with further processing if all products are available
    // }


        public function updateProductQuantities($cartItemId)
        {
            $cartItem = Cart::find($cartItemId);
            // dd($cartItem);

            if ($cartItem) {
                $product = Product::find($cartItem->p_id);
                // dd($product);

                if ($product) {
                    
                    
                    if ($product->p_quantity >= $cartItem->quantity) {
                        // Reduce product quantity by the cart item quantity
                        $product->p_quantity -= $cartItem->quantity;
                        $product->save();

                        // Update the cart item quantity after saving product changes
                    
                    } else {
                        $cartItem->quantity += $cartItem->quantity;
                        $cartItem->save();
                        // Return an error message if out of stock
                        return 'One or more items in your cart are out of stock.';
                    }
                } else {
                    // Return an error message if product not found (optional)
                    return 'Product not found.';
                }
            } else {
                // Return an error message if cart item not found (optional)
                return 'Cart item not found.';
            }

            // Return null or success message if all products are available
            return null;
        }


       
          
    



}