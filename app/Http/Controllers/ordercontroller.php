<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;

class ordercontroller extends Controller
{
    public function order(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'id' => 'required|integer', // Assuming this is the product ID
            'amount' => 'required|numeric', // Assuming this is the total amount
            'qty' => 'required|integer|min:1', // Assuming this is the quantity
            'u_id' => 'required|integer', // Assuming this is the user ID
        ]);

        // Create a new order
        $order = new order();
        $order->product_id = $validatedData['id'];
        $order->amount = $validatedData['amount'];
        $order->quantity = $validatedData['qty'];
        $order->user_id = $validatedData['u_id'];
        $order->save();

        // Optionally, you can return a success response or redirect
        return redirect()->back()->with('success', 'Order placed successfully');
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Order placed successfully.',
        // ]);
    }

    public function addorder(Request $request)
    {
        $order = new order();
        $order->product_id = $request->product_id;
        $order->total_amount = $request->total_amount;
        $order->sub_total  = $request->sub_total;
        
        $order->quantity = $request->quantity;
        $order->u_id = $request->u_id;
        $order->save();
    }
}
