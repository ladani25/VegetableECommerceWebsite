<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Cart;
use App\Models\order;
use App\Models\User;
use App\Models\Product;
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


     
    public function checkout(Request $request)
    {
        // dd($request->all());
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

        // Optionally, save order items or any other order-related data here


        $user = auth()->user();
        $totalQuantity = $request->input('totalQuantity');
        $totalPrice = $request->input('totalPrice');
      
        $user = User::where('email', session('email'))->first();
        $user_id = $user->u_id;
    
            // Retrieve the user's ID

        // Create the order
        $order = new order();
        $order->u_id = $user->u_id;
        $order->qty = $totalQuantity;
        $order->amount = $totalPrice;
        $order->save();

        // $this->updateProductQuantities($request->id);
        $this->updateProductQuantities($order->id);

       Session::put('order', [
           'amount' => $totalPrice
       ]);
        return view('home.checkout', compact('cartItems', 'totalPrice', 'discount', 'shipping', 'finalPrice'));
    }

    // public function updateProductQuantities($id)
    // {
    //     dd($id);
    //     $order = cart::where('id', $id)->get();
    //     // dd($order);

    //     foreach ($order as $order) {
    //         $product = Product::find($order->p_id);
    //         // dd($product);

    //         if ($product) {
    //             $product->p_quantity -= $order->quantity;
    //             $product->save();
    //         }
    //     }
    // }

    // public function updateProductQuantities($u_id )
    // {
    //     // dd($order_id);
    //     // Retrieve cart items related to the order
    //     $cartItems = Cart::where('id', $u_id )->get();
    //     dd($cartItems);
    //     foreach ($cartItems as $cartItem) {
    //         $product = Product::find($cartItem->p_id);

    //         if ($product) {
    //             $product->p_quantity -= $cartItem->quantity;
    //             $product->save();
    //         }
    //     }
    // }

    public function updateProductQuantities($order_id)
    {
        $cartItems = Cart::where('id', $order_id)->get();
    
        foreach ($cartItems as $item) {
            $product = Product::find($item->p_id);
    
            if ($product) {
                if ($product->p_quantity >= $item->quantity) {
                    $product->p_quantity -= $item->quantity;
                    $product->save();
                } else {
                    // Handle out of stock scenario
                    return redirect()->back()->with('error', 'One or more items in your cart are out of stock.');
                }
            } else {
                // Handle case where product is not found (optional)
                return redirect()->back()->with('error', 'Product not found.');
            }
        }
    
        // Continue with further processing if all products are available
    }
    


}