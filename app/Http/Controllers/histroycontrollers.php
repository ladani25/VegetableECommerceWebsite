<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\order_deatils;
use App\Models\User; 

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
}
