<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\admin;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        // $admins = admins::where('email', $request->email)->first();
        $admins = Admin::where('email', $request->email)->first();

        // dd($user);
    
        // Check if user exists and the password matches
        if ($admins && $admins->password === $request->password) {
            // Authentication passed
            
            return view('admin.dashbord');

        }
    
        // Authentication failed
        return redirect('login')->withErrors('error');
    }
    
    public function dashbord()
    {  
      
        return view('admin.dashbord');
    }
    // public function dashbord()
    // {
    //     $totalCategories = Category::count();
    //     return view('admin.dashboard')->with('totalCategories', $totalCategories);
    // }
    
    
    public function categeroy()
    {
        $categeroy = Category::all();
        return view('admin.categeroy', ['categeroy' => $categeroy]);
       // return view('admin.categeroy');
    }
   

    public function products()
    {
        $products = Product::all(); 
        // $products = Product::paginate(5);
        return view('admin.products', ['products' => $products]); 
    }



    public function add_products(){
        $categeroy = Category::all();
        return view('admin.add_products', ['categeroy' => $categeroy]);
    }

    public function add_categeroy(){
        return view('admin.add_categeroy');
    }

    public function get_categeroy(Request $request)
    {
        $request->validate([
            'c_name' => 'required|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate each image file
        ]);

        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $extension = $file->getClientOriginalExtension(); // Correct variable name
            $filename = time() . '.' . $extension; // Correct variable name
            // Move the file to the public/images directory
            $file->move('images', $filename); // Correct directory path and comma added
        }

        
        // Create a new category instance
        $category = new Category();
        $category->c_name = $request->c_name;
        $category->images = $filename;
        $category->save();

        $categeroy = Category::all();
        return view('admin.categeroy', ['categeroy' => $categeroy]);
    }
    
  
    public function c_edit($c_id)
    {
        $categeroy = Category::find($c_id);
        $image = $categeroy ->image;
        return view('admin.c_edit')->with('category',$categeroy )->with('image', $image);
    }
   
    
    public function  edit_c(Request $request, $c_id)
    {
        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $extension = $file->getClientOriginalExtension(); // Correct variable name
            $filename = time() . '.' . $extension; // Correct variable name
            // Move the file to the public/images directory
            $file->move('images', $filename); // Correct directory path and comma added
        }


        $category = Category::find($c_id);
        $category->c_name = $request->c_name;
        $category->images = $filename; // Assign the value of $filename
        $category->update();
        // Here, you can return a success message
        $categeroy = Category::all();
        return view('admin.categeroy', ['categeroy' => $categeroy]);
    }

    public function c_delete($c_id)
    {
        $category = Category::find($c_id);
        $category->delete();
        $categeroy = Category::all();
        return view('admin.categeroy', ['categeroy' => $categeroy]);
    }


    
   
   
}


