<?php
namespace App\Http\Controllers;
use App\Models\Product; 
use App\Models\Category; 
use App\Models\User;
use App\Models\Review;
use App\Models\Wishlist;
use App\Models\cart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function home()
    {
        $products = Product::all();
        $categories = Category::all();
        // $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
        // $cartCount = cart::where('u_id', auth()->id())->count();
        $wishlist = [];
        $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
        $cartCount = Cart::where('u_id', auth()->id())->count();
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

        // return view('wishlists.index', compact('wishlistCount'));
        return view('home.home',compact('products', 'categories', 'wishlist' ,'wishlistCount','cartCount'));
        
    }
 
    // public function shop(Request $request)
    // {
    //     $query = Product::query();
    
    //     if ($request->has('min') && $request->has('max')) {
    //         $min = $request->input('min');
    //         $max = $request->input('max');
    //         $query->whereBetween('price', [$min, $max]);
    //     }
    //     $products = $query->get();
    //     $products = Product::all();
    //     $categories = Category::all();
    //     $wishlist = [];
    //     $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
    //     $cartCount = Cart::where('u_id', auth()->id())->count();
    //     // Check if the user email is stored in the session
    //     if (session()->has('email'))
    //      {
    //         $user = User::where('email', session('email'))->first();
    //         if ($user) 
    //         {
    //             $wishlist = DB::table('wishlists')
    //                 ->where('u_id', $user->u_id)
    //                 ->pluck('p_id')
    //                 ->toArray();
    //         }
    //     }
    //     $minPrice = Product::min('price');
    //     $maxPrice = Product::max('price');

    //     if ($request->get('price_max') != '' && $request->get('price_min') != '') {

    //         if($request->get('price_max') == 1000)
    //         {
    //             $products = $products->whereBetween('price', [intval($request->get('price_min')),1000000]);
    //         }
    //         else{
    //             $products = $products->whereBetween('price', [intval($request->get('price_min')), intval($request->get('price_max'))]);
    //         }
    //     }
    //     if(!empty($request->get('search')))
    //     {
    //         $products = $products->where('title','like','%'.$request->get('search').'%');

    //     }


    //     // Sorting filter
    //     if($request->get('sort') != '')
    //     {
    //         if($request->get('sort') == 'latest')
    //         {
    //             $products = $products->orderBy('id','DESC');
    //         }
    //         else if($request->get('sort') == 'price_asc')
    //         {
    //             $products = $products->orderBy('price','ASC');
    //         }
    //         else
    //         {
    //             $products = $products->orderBy('price','DESC');
    //         }
    //     }
    //     else
    //     {
    //         $products = $products->orderBy('p_id','DESC');
    //     }

    //     return view('home.shop', compact('products', 'categories', 'wishlist' ,'wishlistCount','cartCount','minPrice', 'maxPrice'));
    // }

    public function shop(Request $request)
    {
        $query = Product::query();
    
        if ($request->has('min') && $request->has('max')) {
            $min = $request->input('min');
            $max = $request->input('max');
            $query->whereBetween('price', [$min, $max]);
        }
    
        if ($request->get('price_max') != '' && $request->get('price_min') != '') {
            if ($request->get('price_max') == 1000) {
                $query->whereBetween('price', [intval($request->get('price_min')), 1000000]);
            } else {
                $query->whereBetween('price', [intval($request->get('price_min')), intval($request->get('price_max'))]);
            }
        }
    
        if (!empty($request->get('search'))) {
            $query->where('title', 'like', '%' . $request->get('search') . '%');
        }
    
        $sort = $request->get('sort', ''); // Get sort parameter or default to empty string
        // Sorting filter
        if ($sort != '') {
            if ($sort == 'latest') {
                $query->orderBy('id', 'DESC');
            } else if ($sort == 'price_asc') {
                $query->orderBy('price', 'ASC');
            } else {
                $query->orderBy('price', 'DESC');
            }
        } else {
            $query->orderBy('p_id', 'DESC');
        }
    
        $products = $query->get();
        $categories = Category::all();
        $wishlist = [];
        $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
        $cartCount = cart::where('u_id', auth()->id())->count();
    
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
        $products = Product::paginate(5); // 12 products per page
        // $categories = Category::all();
        // $wishlist = session()->get('wishlist', []);
    
        if ($request->ajax()) {
            return view('home.product_list', compact('products', 'wishlist'))->render();
        }
    
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');
    
        return view('home.shop', compact('products', 'categories', 'wishlist', 'wishlistCount', 'cartCount', 'minPrice', 'maxPrice', 'sort'));
    }
    
    


    public function contact()
    {
        $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
        $cartCount = Cart::where('u_id', auth()->id())->count();
        return view('home.contact', compact('wishlistCount','cartCount'));
    }


    public function shopCategory($c_id)
    {
        $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
            $cartCount = Cart::where('u_id', auth()->id())->count();
        $category = Category::findOrFail($c_id);
        $products = $category->products; // Assuming you have a 'products' relationship in your Category model
        return response()->json(['products' => $products])->with('wishlistCount', $wishlistCount)->with('cartCount', $cartCount);
    }
    
    public function products_details($p_id)
    {
        $product = Product::find($p_id);
        $reviews = $product->reviews;
        $wishlist = [];
        $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
        $cartCount = Cart::where('u_id', auth()->id())->count();
        
        return view('home.products_deatils', compact('product', 'wishlistCount','cartCount','wishlist', 'reviews'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1',
        ]);
    
        $query = $request->input('query');
    
        // Perform the search query with pagination
        $products = Product::where('name', 'LIKE', "%$query%")
                        ->orWhere('description', 'LIKE', "%$query%")
                        ->paginate(10); // 10 results per page
                        $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
                        $cartCount = cart::where('u_id', auth()->id())->count();
                        if ($request->ajax()) {
                            return response()->json([
                                'products' => $products,
                                'wishlistCount' => $wishlistCount,
                                'cartCount' => $cartCount,
                                'pagination' => (string) $products->links()
                            ]);
                        }
                    
                        // For non-AJAX requests, return the usual view
                        // return view('home.search-results', compact('products', 'query', 'wishlistCount', 'cartCount'));
        
        // return redirect()->back()->with('success')->with (compact('products', 'query', 'wishlistCount', 'cartCount'));
        return view('home.search-results', compact('products', 'query', 'wishlistCount', 'cartCount'));
    }
    


    public function showCategory($c_id)
    {
    

        $category = Category::findOrFail($c_id);
        $product = $category->products;
        $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
        $cartCount = Cart::where('u_id', auth()->id())->count();
        // return response()->json(['products' => $product]);
        return view('home.p_category', compact('category',  'wishlistCount', 'cartCount','product'));
     
    }
    public function shop_categeroy($c_id)
    {
        //  $products = Product::all();
        $categories = Category::all();
        $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
        $cartCount = Cart::where('u_id', auth()->id())->count();
        $category = Category::findOrFail($c_id);
        $product = $category->products;
        // return response()->json(['products' => $product]);
     
        return view('home.shop_categeroy', compact('categories', 'wishlistCount','cartCount'));
       
    }

    public function filterByPrice(Request $request)
    {
        dd($request->all());
        $minPrice = $request->query('min');
        $maxPrice = $request->query('max');

        $products = Product::whereBetween('price', [$minPrice, $maxPrice])->get();

        // Return a view with filtered products (you can customize this part as per your requirement)
        return view('home.shop', compact('products'));
    }

   
    public function addReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,p_id',
            // 'rating' => 'required|integer|between:1,5',
             'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string'
        ]);
        $products_id = $request->product_id;
                
        // dd($products_id);
        if(product::find($products_id))
        {

            $user = User::where('email', session('email'))->first();
            $user_id = $user->u_id;

            $review = new Review();
            $review->p_id =  $products_id;
            // $review->u_id = auth()->id();
            $review->u_id = $user_id;
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->save();

            return redirect()->back()->with('success', 'Review added successfully!');
        }
    }
}
