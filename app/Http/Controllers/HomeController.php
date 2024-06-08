<?php
namespace App\Http\Controllers;
use App\Models\Product; 
use App\Models\Category; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function home()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('home.home', compact('products','categories'));
      
    }
 
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
    public function products_details($p_id)
    {
        $product = Product::find($p_id);
        return view('home.products_deatils', compact('product'));
    }
}