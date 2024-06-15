<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\order_deatils;
use App\Models\User; 
use App\Models\order;

class histroycontrollers extends Controller
{
    public function order_histroy()
    {
        $user = User::where('email', session('email'))->first();
        $user_id = $user->u_id;
        $orderDetails = order_deatils::where('u_id', $user_id)->latest()->get();
        

        
        //$orderDetails = order_deatils::all();
        return view('home.order_histroy', compact('orderDetails'));

        
    }

//     public function order_histroy()
// {
//     // Retrieve orders associated with the authenticated user
//     $user = User::where('email', session('email'))->first();
//     $user_id = $user->u_id;
//     $orders = order::where('u_id', $user->u_id)->orderBy('created_at', 'desc')->get();

//     return view('home.order_histroy', compact('orders'));
// }
}
