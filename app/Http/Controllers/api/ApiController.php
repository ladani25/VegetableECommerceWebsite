<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\DB;
use App\Mail\SendOtp;
use App\Models\User;
use App\Models\Product;
USE App\Models\Coupon;
USE App\Models\order_deatils;
use App\Models\order;
use App\Models\Review;
use App\Models\Category;
use App\Models\user_orders;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Create a new user
        $user = new user ();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password= $request->password;
        $user->save();
    

        // Optionally, you can issue a token here if you're using JWT or Passport for authentication

        // Return a response
        // return ['code'=>200,'status'=>1,"result" => "done" , 'data'=>$customers];
        return response()->json(['message' => 'User registered successfully', 
                                 'user' => $user,
                                 'code'=>200,
                                 'status'=>1,
                                "result" => "done" ] );
    }


    public function login(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        // Check if the user exists and the password is correct
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Optionally, you can issue a token here if you're using JWT or Passport for authentication

        // Return a response
        return ['code'=>200,'status'=>1,"result" => "done" , 'data'=>$user];
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Session::get('cart', []);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'quantity' => $quantity
            ];
        }

        Session::put('cart', $cart);

        return response()->json(['message' => 'Product added to cart successfully', 'cart' => $cart], 200);
    }

    // public function cart(Request $request)
    // {
    //     $email = $request->input('email');
    //     $user = User::where('email', $email)->first();

    //     $user_id = $user->u_id;

    //     // if ($user) {
    //     //     $user_id = $user->u_id;
    //     //     return response()->json([
    //     //         'message' => 'Cart items retrieved successfully',
    //     //         'code'=>200,
    //     //         'status'=>1,
    //     //        "result" => "done"
       
    //     //     ], 200);
    //     // } else {
    //     //     return response()->json(['error' => 'User not found.'], 404);
    //     // }

    //     if ($user) {
    //         // Fetch cart items with product details and calculate total price for each item
    //         $cartItems = DB::table('carts')
    //             ->join('products', 'carts.p_id', '=', 'products.p_id')
    //             ->where('carts.u_id', $user_id)
    //             ->select('carts.*', 'products.*', DB::raw('carts.quantity * products.price as total_price'))
    //             ->get();

    //         // Calculate total quantity and total price
    //         $totalQuantity = $cartItems->sum('quantity');
    //         $totalPrice = $cartItems->sum('total_price');
           

    //         // Return the data as a JSON response
    //         return response()->json([
    //             'cartItems' => $cartItems,
    //             'totalQuantity' => $totalQuantity,
    //             'totalPrice' => $totalPrice,
            
    //         ], 200);
    //     } else {
    //         // Handle the case where the user is not found
    //         return response()->json(['error' => 'User not found.'], 404);
    //     }
    // }

    public function cart(Request $request)
    {
        $user_id = $request->input('u_id');

        // Fetch the user by ID
        $user = User::find($user_id);

        if ($user) {
            // Fetch cart items with product details and calculate total price for each item
            $cartItems = DB::table('carts')
                ->join('products', 'carts.p_id', '=', 'products.p_id')
                ->where('carts.u_id', $user_id)
                ->select('carts.*', 'products.*', DB::raw('carts.quantity * products.price as total_price'))
                ->get();

            // Calculate total quantity and total price
            $totalQuantity = $cartItems->sum('quantity');
            $totalPrice = $cartItems->sum('total_price');

            // Return the data as a JSON response
            return response()->json([
                'cartItems' => $cartItems,
                'totalQuantity' => $totalQuantity,
                'totalPrice' => $totalPrice,
            ], 200);
        } else {
            // Handle the case where the user is not found
            return response()->json(['error' => 'User not found.'], 404);
        }
    }

    public function removecart(Request $request)
    {
        $user_id = $request->input('u_id');
        $p_id = $request->input('p_id');

        // Fetch the user by ID
        $user = User::find($user_id);

        if ($user) {
            // Remove the item from the cart
            DB::table('carts')->where('u_id', $user_id)->where('p_id', $p_id)->delete();

            return response()->json(['message' => 'Item removed from cart successfully'], 200);
        } else {
            // Handle the case where the user is not found
            return response()->json(['error' => 'User not found.'], 404);
        }
    }
    
    public function removeallcart(Request $request)
    {
        $user_id = $request->input('u_id');

        // Fetch the user by ID
        $user = User::find($user_id);

        if ($user) {
            // Remove all items from the cart
            DB::table('carts')->where('u_id', $user_id)->delete();

            return response()->json(['message' => 'All items removed from cart successfully'], 200);

        } else {
            // Handle the case where the user is not found
            return response()->json(['error' => 'User not found.'], 404);
        }

    }

    public function wishlist(Request $request)
    {
        $user_id = $request->input('u_id');

        // Fetch the user by ID
        $user = User::find($user_id);

        if ($user) {
            // Fetch wishlist items with product details
            $wishlistItems = DB::table('wishlists')
                ->join('products', 'wishlists.p_id', '=', 'products.p_id')
                ->where('wishlists.u_id', $user_id)
                ->select('wishlists.*', 'products.*')
                ->get();

            // Return the data as a JSON response
            return response()->json(['wishlistItems' => $wishlistItems], 200);
        } else {
            // Handle the case where the user is not found
            return response()->json(['error' => 'User not found.'], 404);
        }
    }

    public function removewishlist(Request $request)
    {
        $user_id = $request->input('u_id');
        $p_id = $request->input('p_id');

        // Fetch the user by ID
        $user = User::find($user_id);

        if ($user) {
            // Remove the item from the wishlist
            DB::table('wishlists')->where('u_id', $user_id)->where('p_id', $p_id)->delete();

            return response()->json(['message' => 'Item removed from wishlist successfully'], 200);
        } else {
            // Handle the case where the user is not found
            return response()->json(['error' => 'User not found.'], 404);
        }
    }

    public function removeallwishlist(Request $request)
    {
        $user_id = $request->input('u_id');

        // Fetch the user by ID
        $user = User::find($user_id);

        if ($user) {
            // Remove all items from the wishlist
            DB::table('wishlists')->where('u_id', $user_id)->delete();

            return response()->json(['message' => 'All items removed from wishlist successfully'], 200);
        } else {
            // Handle the case where the user is not found
            return response()->json(['error' => 'User not found.'], 404);
        }
    }



    public function editProfile(Request $request)
    {
        $user_id = $request->input('u_id');

    
        // Fetch the user by ID
        $user = User::find($user_id);

        if ($user) {
            // Update user details
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone_number = $request->input('phone_number');

            // Save the updated user
            $user->save();

            // Return the updated user data as a JSON response
            return response()->json([
                'message' => 'Profile updated successfully.',
                'user' => $user
            ], 200);
        } else {
            // Handle the case where the user is not found
            return response()->json(['error' => 'User not found.'], 404);
        }
    }


    public function fillter(Request $request)
    {
        $rules = [
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric',
            'c_id' => 'required|integer', // Assuming c_id represents category id
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errormsg = $validator->errors()->all();
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => $errormsg,
            ]);
        }

        $category =Category::findOrFail($request->input('c_id'));
        $products = Product::where('price', '>=', $request->input('min_price'))
                    ->where('price', '<=', $request->input('max_price'))
                    ->where('c_id', $request->input('c_id'))
                    ->get();

        return response()->json([
            'code' => 200,
            'status' => 1,
            'message' => "Filter Product",
            'data' => [
                'category' => $category,
                'products' => $products
            ]
        ]);
    }

 
    public function search(Request $request)
    {
        // Validate the request input
        $rules = [
            'query' => 'required|string|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            
            $errormsg = $validator->errors()->all();
            return response()->json([
                'code'=>400,
                'status'=>0,
                'message'=> $errormsg,
                

            ]);
        }
    
        // Retrieve the search query from the request
        $search = $request->input('query');
    
        // Build the query to search for products by name
        $products = Product::where('name', 'like', '%' . $search . '%')->get();
    
        // Return the response
        return response()->json([
            'code' => 200,
            'status' => 1,
            'message' => 'Search Product',
            'data' => $products,
        ]);
    }

    public function coupon(Request $request)
    {
        $rules = [
            'coupon' => 'required|string|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            
            $errormsg = $validator->errors()->all();
            return response()->json([
                'code'=>400,
                'status'=>0,
                'message'=> $errormsg,
            ]);
        }

        $coupon = $request->input('coupon');
        $coupon = Coupon::where('coupon_code', $coupon)->first();
        if ($coupon) {
            return response()->json([
                'code' => 200,
                'status' => 1,
                'message' => 'Coupon Found',
                'data' => $coupon,
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => 'Coupon Not Found',
            ]);
        }

    }

    public function checkout(Request $request)
    {
        $rules = [
            'u_id' => 'required',
            'amount' => 'required',
            'qty' => 'required',
            'totalamount' => 'required',
            'subtotal' => 'required',
            'discount' => 'required',
            // 'payment' => 'required',
            'payment_type' => 'required',
            'order_date' => 'required',
            'payment_id' => 'required',
            'address' => 'required',
            'product_json'=>'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errormsg = $validator->errors()->all();
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => $errormsg,
            ]);
        }

        $order = new Order();
        $order->qty = $request->input('qty');
        $order->amount = $request->input('amount');
        $order->u_id = $request->input('u_id');
        $order->save();

        $orderId = $order->id;

        $product = json_decode($request->input('product_json'));
        foreach ($product as $value) {
            $user_order = new user_orders();
            $user_order->u_id = $value->u_id;
            $user_order->p_id = $value->p_id;
            $user_order->u_qty = $value->p_qty;
            $user_order->order_id = $order->order_id;
            $user_order->save();
        }
       

        $order_details = new order_deatils();
        $order_details->order_num = '#' . strtoupper(uniqid());
        $order_details->order_id = $order->order_id;
        $order_details->totalal_amout = $request->input('totalamount');
        $order_details->sub_totale = $request->input('subtotal');
        $order_details->discount = $request->input('discount');
        $order_details->payment_type = $request->input('payment_type');
        $order_details->payment_status	 = $request->input('payment_status');
        $order_details->order_date = now();
        $order_details->u_id = $request->input('u_id');
        $order_details->address = $request->input('address');
        $order_details->save();

        if ($request->input('payment_type') == 'cheque') {
            $order_details->payment_status = 'paid';
            $order_details->payment_id = $request->input('payment_id');
            $order_details->save();
            return response()->json([
                'code' => 200,
                'status' => 1,
                'message' => 'Payment successful',
            ]);
        } elseif ($request->input('payment_type') == 'razorpay') {
            $order_details->payment_status = 'unpaid';
            $order_details->payment_id = null;
            $order_details->save();
            return response()->json([
                'code' => 200,
                'status' => 1,
                'message' => 'Order placed successfully. Complete the payment through Razorpay.',
                'data' => $order_details->order_num
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => 'Payment failed',
            ]);
        }
    }



    public function checkout_payment(Request $request)
    {
        $rules = [
            'order_num' => 'required',
            'payment_id' => 'required',
            'payment_status' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errormsg = $validator->errors()->all();
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => $errormsg,
            ]);
        }

        $order_num = $request->input('order_num');
        $order_details = order_deatils::where('order_num', $order_num)->first();

        if (!$order_details) {
            return response()->json([
                'code' => 404,
                'status' => 0,
                'message' => 'Order not found',
            ]);
        }

        $order_details->payment_id = $request->input('payment_id');
        $order_details->payment_status = $request->input('payment_status');
        $order_details->update();

        return response()->json([
            'code' => 200,
            'status' => 1,
            'message' => 'Payment successful',
        ]);
    }

    public function Review(Request $request)
    {
        $rules = [
            'u_id' => 'required',
            'p_id' => 'required',
            'rating' => 'required',
            'review' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errormsg = $validator->errors()->all();
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => $errormsg,
            ]);
        }
        $review = new Review();
        $review->u_id = $request->input('u_id');
        $review->p_id = $request->input('p_id');
        $review->rating = $request->input('rating');
        $review->comment = $request->input('review');
        $review->save();

        return response()->json([
            'code' => 200,
            'status' => 1,
            'message' => 'Review added successfully',
        ]);
    }


    public function forgetPassword(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];
        $validation = validator::make($request->all(), $rules);
        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            $errorMessage = implode(' ', $errors);
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => $errorMessage
            ]);
        }
        $user = user::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => 'User not found'
            ]);
        }
        $otp = random_int(1000, 9999);
        $num = 123;
        Cache::put('otp_' . $otp, $otp, now()->addMinutes(5));
        Cache::put('email_' . $num, $user->email, now()->addMinutes(120));

        $email_send = Mail::to($request->email)->send(new SendOtp($otp, $user));
        if ($email_send) {
            return response()->json([
                'code' => 200,
                'status' => 1,
                'message' => 'OTP send successfully',
                // 'data' => $otp
            ]);
        } else {
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => 'OTP send failed'
            ]);
        }
    } 

    public function verifyOtp(Request $request)
    {
        $rules = [
            // 'email' => 'required|email',
            'otp' => 'required|numeric',
        ];
    
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            $errorMessage = implode(' ', $errors);
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => $errorMessage,
            ]);
        }
    
        $cachedOtp = Cache::get('otp_' . $request->email);
        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => 'Invalid OTP',
            ]);
        }
    
        // If OTP is valid, you can proceed with your logic here (e.g., allow password reset).
    
        // Optionally, clear the OTP from cache after successful verification
        Cache::forget('otp_' . $request->email);

        $email = Cache::get('email_' . $request->email);
    
        return response()->json([
            'code' => 200,
            'status' => 1,
            'message' => 'OTP verified successfully',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            $errorMessage = implode(' ', $errors);
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => $errorMessage
            ]);
        }
        $user = user::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => 'User not found'
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'code' => 200,
            'status' => 1,
            'message' => 'Password reset successfully',
        ]);
    }
    
    public function orderhistrory(Request $request)
    {
        $rules = [
            'u_id' => 'required|integer',
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            $errorMessage = implode(' ', $errors);
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => $errorMessage
            ]);
        }
        // $order = Order::where('u_id', $request->input('u_id'))->get();
        $orderDetails = order_deatils::where('u_id',$request->input('u_id'))->latest()->get();
        return response()->json([
            'code' => 200,
            'status' => 1,
            'message' => 'Order History',
            'data' => $orderDetails
        ]);
    }

    public function orderDetails(Request $request)
    {
        // Validate the incoming request
        $rules = [
            'u_id' => 'required|integer',
            'order_id' => 'required|integer',
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            $errors = $validation->errors()->all();
            $errorMessage = implode(' ', $errors);
            return response()->json([
                'code' => 400,
                'status' => 0,
                'message' => $errorMessage
            ]);
        }

        // Fetch the user's order details based on u_id and order_id
        $userOrders = user_orders::where('u_id', $request->input('u_id'))
                                ->where('order_id', $request->input('order_id'))
                                ->with('Product')  // Assuming there's a relationship defined to fetch related product details
                                ->get();

        if ($userOrders->isEmpty()) {
            return response()->json([
                'code' => 404,
                'status' => 0,
                'message' => 'Order not found.'
            ]);
        }

        // Return a JSON response with the order details
        return response()->json([
            'code' => 200,
            'status' => 1,
            'message' => 'Order Details',
            'data' => $userOrders
        ]);
    }


}