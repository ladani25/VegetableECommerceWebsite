<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product; 
use App\Models\Category; 
use App\Models\Wishlist;
use App\Models\cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

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
        return redirect()->route('home')->with(compact('products', 'categories'));

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

    public function user_profile(Request $request)
    {
        $user = User::where('email', session('email'))->first();
        $user_id = $user->u_id;
        $wishlistCount = Wishlist::where('u_id', auth()->id())->count();
        $cartCount = cart::where('u_id', auth()->id())->count();
    //    $user = User::find($id);
        return view('home.user_profile', compact('user' ,'wishlistCount' ,'cartCount'));
    }

    public function edit_profile(Request $request, $u_id)
    {
        // dd($request->all());
        $user = User::find($u_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        // $user->password = $request->password;
        $user->update();

        // $user = User::all($u_id);
        // dd($user);
        return view('home.user_profile', compact('user'));
    }

    public function change_password($u_id)
    {
        $user = User::find($u_id);
        return view('home.change_password', compact('user'));
    }

    public function update_password(Request $request, $u_id)
    {
        // Validate the request
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'new_password.confirmed' => 'The new password and confirmation password do not match.',
        ]);
    
        // Find the user
        $user = User::find($u_id);
        if (!$user) {
            return redirect()->back()->withErrors(['user_not_found' => 'User not found.']);
        }
    
        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();
    
        return view('home.user_profile', compact('user'));
    }
    
    public function showLinkRequestForm()
    {
        return view('home.email');
    }
    
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm()
    {
        if (!session('reset_user_id')) {
            return redirect()->route('password.verify');
        }

        return view('home.email');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find(session('reset_user_id'));

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            // Clear the session
            session()->forget('reset_user_id');

            return redirect()->route('login')->with('status', 'Password reset successfully');
        }

        return back()->withErrors(['error' => 'Invalid session data']);
    }
    

        public function showVerificationForm()
    {
        return view('home.email');
    }



    public function verifyIdentity(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            // Add other validation rules as needed
        ]);

        $user = User::where('email', $request->username)->first();
        $user = User::where('email', session('email'))->first();
        $user_id = $user->u_id;

        if ($user) {
            // Store user information in the session to identify them in the next step
            session(['reset_user_id' => $user->id]);

            return redirect()->route('password.reset');
        }

        return back()->withErrors(['username' => 'User not found']);
    }
}
