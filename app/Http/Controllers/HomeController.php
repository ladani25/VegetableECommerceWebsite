<?php

namespace App\Http\Controllers;
use App\Models\Product; 
use App\Models\Category; 
use App\Models\wishlist;
use App\Models\User;
use App\Models\cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('home.home', compact('products','categories'));
      
    }
    // public function shop()
    // {
    //     $products = Product::all();
    //     $categories = Category::all();
    //     // $wishlist = auth()->user()->wishlist->pluck('w_id')->toArray();
    //     return view('home.shop', compact('products','categories'));
    // }
    
    public function shop()
{
    $products = Product::all();
    $categories = Category::all();
    $wishlist = [];

    // Check if the user email is stored in the session
    if (session()->has('email')) {
        $user = User::where('email', session('email'))->first();
        if ($user) {
            $wishlist = DB::table('wishlists')
                ->where('u_id', $user->u_id)
                ->pluck('p_id')
                ->toArray();
        }
    }

    return view('home.shop', compact('products', 'categories', 'wishlist'));
}



    public function contact()
    {
        return view('home.contact');
    }

    public function shop_categeroy()
    {
        //  $products = Product::all();
        $categories = Category::all();
        return view('home.shop_categeroy', compact('categories'));
        // return view('home.shop_categeroy');
    }

    // public function register()
    // {
    //     return view('home.register');
    // }

    
    
    public function products_deatils($p_id)
    {
        $product = Product::find($p_id);
        return view('home.products_deatils', compact('product'));
    }

// public function Whitelist()
// {
//     return view('home.Whitelist');
// }

//     public function Whitelist(Request $request,$u_id)
// {
//     // Ensure the user is authenticated
//     $user = user::find($u_id);

//     if ($user) {
//         // dd($user);
//         // Get the product ID from the request
//         $p_id = $request->input('p_id');

//         // Check if the product exists
//         $product = Product::find($p_id);

//         if ($product) {
//             // Check if the product is already in the user's wishlist
//             $wishlistItem = Wishlist::where('u_id', $user->id)
//                                     ->where('p_id', $p_id)
//                                     ->first();

//             if (!$wishlistItem) {
//                 // Add the product to the wishlist
//                 $wishlistItem = new Wishlist();
//                 $wishlistItem->u_id = $user->id;
//                 $wishlistItem->p_id = $p_id;
//                 $wishlistItem->save();
//             }

//             // Fetch the updated wishlist with product relationships
//             $wishlists = $user->wishlist()->with('product')->get();

//             // Return the view with the updated wishlist
//             return view('home.Whitelist', compact('wishlists'));
//         } else {
//             // Handle the case where the product doesn't exist
//             return redirect()->back()->with('error', 'Product not found.');
//         }
//     } else {
//         // Handle the case where the user is not authenticated
//         return view('home.login')->with('error', 'You must be logged in to add items to your wishlist.');
//     }
    
// }

// public function showWhitelist($u_id)
// {
//     // Ensure the user is authenticated
//     $user = User::find($u_id);

//     if ($user) {
//         // Fetch the wishlist with product relationships
//         $wishlists = $user->wishlist()->with('product')->get();

//         // Return the view with the updated wishlist
//         return view('home.whitelist', compact('wishlists'));
//     } else {
//         // Handle the case where the user is not authenticated
//         return redirect()->route('login')->with('error', 'You must be logged in to view your wishlist.');
//     }
// }

// public function addToWhitelist(Request $request, $u_id)
// {
//     // Ensure the user is authenticated
//     $user = User::find($u_id);

//     if ($user) {
//         // Get the product ID from the request
//         $productId = $request->input('product_id');

//         // Check if the product exists
//         $product = Product::find($productId);

//         if ($product) {
//             // Check if the product is already in the user's wishlist
//             $wishlistItem = Wishlist::where('user_id', $user->id)
//                                     ->where('product_id', $productId)
//                                     ->first();

//             if (!$wishlistItem) {
//                 // Add the product to the wishlist
//                 $wishlistItem = new Wishlist();
//                 $wishlistItem->user_id = $user->id;
//                 $wishlistItem->product_id = $productId;
//                 $wishlistItem->save();
//             }

//             // Fetch the updated wishlist with product relationships
//             $wishlists = $user->wishlist()->with('product')->get();

//             // Return the view with the updated wishlist
//             return view('home.whitelist', compact('wishlists'));
//         } else {
//             // Handle the case where the product doesn't exist
//             return redirect()->back()->with('error', 'Product not found.');
//         }
//     } else {
//         // Handle the case where the user is not authenticated
//         return redirect()->route('login')->with('error', 'You must be logged in to add items to your wishlist.');
//     }
// }

//    public function cart(Request $request)
//     {
//         $cart = json_decode($request->cookie('user_cart', '[]'), true);

//         if (empty($cart)) {
//             return view('home.cart', ['cartItems' => []]);
//         }

//         $products = Product::whereIn('id', array_keys($cart))->get();
//         $cartItems = [];

//         foreach ($products as $product) {
//             $cartItems[] = [
//                 'product' => $product,
//                 'quantity' => $cart[$product->p_id], // Use 'id' instead of 'p_id'
//             ];
//         }

//         return view('home.cart', compact('cartItems'));
//     }
    // public function add_Cart(Request $request)
    // {
    //     dd($request->all());
    //     // Get the product ID and quantity from the request
    //     $productId = $request->input('p_id');  // Use 'p_id' to match your form input
    //     $quantity = $request->input('quantity', 1);
    //     // dd($quantity);
        
    //     $cart = new cart();
        

    //     // Decode the 'user_cart' cookie, defaulting to an empty array if not set
    //     // $cart = json_decode($request->cookie('user_cart', '[]'), true);
    
    //     // // Update the cart with the new product and quantity
    //     // if (isset($cart[$productId])) {
    //     //     $cart[$productId] += $quantity;
    //     // } else {
    //     //     $cart[$productId] = $quantity;
    //     // }
    
    //     // // Fetch the updated products to pass to the view
    //     // $products = Product::whereIn('p_id', array_keys($cart))->get();
    //     // $cartItems = [];
    
    //     // foreach ($products as $product) {
    //     //     $cartItems[] = [
    //     //         'product' => $product,
    //     //         'quantity' => $cart[$product->p_id],  // Ensure consistent use of 'p_id'
                
    //     //     ];
    //     // }
    
    //     // Return the cart view with the updated cart items and cookie
    //     return view('home.cart', compact('cartItems'));
    // }
    
    // public function add_Cart(Request $request)
    // {
    //     dd($request->all());
    //     // Get the product ID and quantity from the request
    //     $productId = $request->input('p_id');  // Use 'p_id' to match your form input
    //     $quantity = $request->input('quantity', 1);
    //     // dd($quantity);
        
    //     $cart = new cart();
       
    //     // Return the cart view with the updated cart items and cookie
    //     return view('home.cart', compact('cartItems'));
    // }
    // public function remove_Cart(Request $request)
    // {
    //     $productId = $request->input('product_id');
    //     $cart = json_decode($request->cookie('user_cart', '[]'), true);

    //     if (isset($cart[$productId])) {
    //         unset($cart[$productId]);
    //     }

    //     return view('home.cart')->withCookie(cookie()->forever('user_cart', json_encode($cart)));
    // }





    public function addCart(Request $request)
    {
        $productId = $request->input('p_id');
        $userId = $request->input('u_id');
    
        // Fetch the user's cart or create a new one
        $cart = Cart::firstOrCreate(
            ['u_id' => $userId]
        );
    
        // Attach product to the cart with quantity
        $cart->products()->attach($productId, ['quantity' => 1]);
    
        return redirect()->route('cart.view');
    }
    

    public function viewCart()
{
    // Assuming authenticated user
    $userId = auth()->id();
    $cart = Cart::where('u_id', $userId)->where('status', 'active')->first();

    $cartItems = $cart ? $cart->products : [];

    return view('home.cart', compact('cartItems'));
}




}