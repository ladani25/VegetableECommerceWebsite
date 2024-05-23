<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class  Wishlistcontroller extends Controller
{
    

    public function index()
    {
        // $wishlists = Wishlist::all();
        // $user = user::where('email' , session('email')  );
        $user = User::where('email', session('email'))->first();

        // dd($user);
        $user_id = $user->u_id;
        // dd($user_id);
        $wishlists = DB::table('wishlists')
        ->join('products', 'wishlists.p_id', '=', 'products.p_id')
        // ->join('user', 'wishlists.u_id', '=', 'user.u_id')
        ->where('wishlists.u_id', $user_id)
        ->select('wishlists.*', 'products.*')
        ->get();
    
        // dd($wishlists);
        // $wishlists = wishlist::all();
        // dd($wishlists);
        return view('home.wishlist', compact('wishlists'));
    }

    public function  add(Request $request)
    {

        // dd($request->all());
          
            $products_id = $request->product_id;
            
            // dd($products_id);
            if(product::find($products_id))
            {
                $user = User::where('email', session('email'))->first();
                $user_id = $user->u_id;
                $wishlist = new wishlist();
                $wishlist->p_id = $products_id;
                $wishlist->u_id = $user_id;
                $wishlist->save();
                return redirect()->back()->with('success', 'Product  added to wishlist.');
            }
            else
            {
                return redirect()->back()->with('success', 'Product  not  added to wishlist.');
            }

           
    }

    public function remove($w_id)
    {
        $wishlist = Wishlist::find($w_id);
        if ($wishlist) {
            $wishlist->delete();
            return redirect()->back()->with('success', 'Product removed from wishlist.');
        }
        return redirect()->back()->with('error', 'Product not found in wishlist.');
    }
   
    public function updateWishlist(Request $request)
    {
        $productId = $request->input('productId');
        $action = $request->input('action');

        $wishlist = session()->get('wishlist', []);

        if ($action === 'add') {
            if (!in_array($productId, $wishlist)) {
                $wishlist[] = $productId;
            }
        } elseif ($action === 'remove') {
            if (($key = array_search($productId, $wishlist)) !== false) {
                unset($wishlist[$key]);
            }
        }

        session()->put('wishlist', $wishlist);

        return response()->json(['wishlist' => $wishlist]);
    }

   
}