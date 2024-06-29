<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class productscontrollers extends Controller
{
   
    public function get_products(Request $request)
    {
        if ($request->hasFile('images')) {
            $file = $request->file('images');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('images', $filename);
        }
    
        // Create a new Product instance
        $product = new Product();
        $product->name = $request->name;
        $product->images = $filename;
        $product->price = $request->price;
        $product->selling_price=$request->selling_price;
        $product->p_quantity = $request->p_quantity;
        $product->c_id = $request->c_id ;
        $product->description= $request->description;
    
        // Save the product
        $product->save();
    
        // Retrieve all products from the database
        $products = Product::all();
    
  
        $products= session('products', [
            // 'amount' =>  $totalPrice
            'products' => 'p_id'
         ]);

        // Pass products to the view
        return view('admin.products', compact('products'));
    }
    
    public function p_edit($p_id)
    {
        
       $data['product'] = Product::find($p_id); 
       $data['category'] = Category::all(); 
        return view('admin.p_edit',$data);//->with('image', $image);
    }
   
    // public function  edit_p(Request $request, $p_id)
    // {     
    //         $product = Product::find($p_id);
    //         $product->name = $request->name;
    //         // $product->images = $filename;
    //         $product->price = $request->price;
    //         $product->quantity = $request->quantity;
    //         $product->c_id = $request->c_id ;

         
    //     // $category->images = $filename; // Assign the value of $filename
    //     $product->update();
    //     // Here, you can return a success message
    //    // return view('admin.products');
    //     $products = Product::all(); 
    //     return view('admin.products', ['products' => $products]); 
    // }

//     public function edit_p(Request $request, $p_id)
// {     
//     if ($request->hasFile('images')) {
//         $file = $request->file('images');
//         $extension = $file->getClientOriginalExtension();
//         $filename = time() . '.' . $extension;
//         $file->move('images', $filename);
//     }


//     $product = Product::find($p_id);
//     $product->name = $request->name;
//     $product->images = $filename;
//     $product->price = $request->price;
//     $product->quantity = $request->quantity;
//     $product->c_id = $request->c_id ;

//     // $category->images = $filename; // Assign the value of $filename
//     $product->update();

//     // Retrieve all products after updating
//     $products = Product::all(); 

//     // Return the view with updated products
//     return view('admin.products', ['products' => $products]); 
// }

public function edit_p(Request $request, $p_id)
{     
    $filename = null; // Initialize with a default value

    if ($request->hasFile('images')) {
        $file = $request->file('images');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $file->move('images', $filename);
    }

    // dd($request->all());
    $product = Product::find($p_id);
    $product->name = $request->name;
    $product->images = $filename; // Use the initialized value
    $product->price = $request->price;
    $product->selling_price=$request->selling_price;
    $product->p_quantity = $request->p_quantity;
    $product->c_id = $request->c_id ;
    $product->description= $request->description;

    $product->update();

    // Retrieve all products after updating
    $products = Product::all(); 
    $user = User::all();

    // Return the view with updated products
    return view('admin.products', ['products' => $products , 'user' => $user]); 
}
 

    public function p_delete($p_id)
    {
        $product = Product::find($p_id);
        $product->delete();  
        $products = Product::all(); 
        return view('admin.products', ['products' => $products]); 
    }   
}
