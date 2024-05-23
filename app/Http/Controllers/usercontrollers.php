<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product; 
use App\Models\Category; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class usercontrollers extends Controller
{
    public function register()
    {
        return view('home.register');
    }
    
    public function login()
    {
        return view('home.login');
    }

    public function user_register(Request $request)
    {
        $user = new user ();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password= $request->password;
        $user->save();

        $products = Product::all();
        $categories = Category::all();
        return view('home.home', compact('products','categories'));
        // return view('home.home');

    }  
   
    public function  user_login(Request $request)
    {
        // dd($request);
        $pwd= Hash::make($request->password);
        $user = user::where('email', $request->email)->first();
        $request->session()->put('email', $request->email);

       
    if ($user && Hash::check($request->password, $user->password)) {
        // Authentication passed
        Auth::login($user);
        $request->session()->regenerate();
        $products = Product::all();
        $categories = Category::all();
        return view('home.home', compact('products','categories'));
        // return view('home.home')->with('message', 'welcome to'.$user);
    }
    
        // Authentication failed
        return redirect('login')->with('message', 'It is correct');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('home.login');
    }





    

    public function user()
    {
        $user = user::all(); 
        // $products = Product::paginate(5);
        return view('admin.user', ['user' => $user]); 
    }
}
