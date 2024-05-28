<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    // public function Coupon(Request $request)
    // {
    //     $request->validate([
    //         'coupon_code' => 'required|string',
    //     ]);

    //     $coupon = Coupon::findByCode($request->coupon_code);

    //     // dd($coupon);

    //     if ($coupon) {
    //         $totalPrice = Cart::where('u_id', session('u_id'))
    //             ->join('products', 'carts.p_id', '=', 'products.p_id')
    //             ->sum('products.price');
    //          // dd($coupon);
    //         $discount = $coupon->discount($totalPrice);
    //         // dd($discount);
    //         session(['coupon' => [
    //             'discount' => $discount,
    //             'shipping' => 0,
    //         ]]);

    //         $shipping = session('coupon')['shipping'];
    //         $finalTotal = $totalPrice - $discount + $shipping;

    //         // return redirect()->back()->with('success', 'Coupon code is valid.')->with(compact('discount'));
    //         return redirect()->back()->with('success', 'Coupon code is valid.')->with(compact('totalPrice','discount'));
    //     } else {
    //         return redirect()->back()->with('error', 'Invalid coupon code.');
    //     }
    // }

    public function applyCoupon(Request $request)
{
    $coupon = Coupon::where('code', $request->coupon_code)->first();

    if (!$coupon) {
        return redirect()->back()->with('error', 'Invalid coupon code');
    }

    // Assuming you have fields 'type' and 'amount' in your Coupon model
    $totalPrice = Cart::where('u_id', session('u_id'))
        ->join('products', 'carts.p_id', '=', 'products.p_id')
        ->sum('products.price');

    $discount = 0;

    if ($coupon->type == 'percent') {
        $discount = $totalPrice * ($coupon->amount / 100);
    } elseif ($coupon->type == 'flat') {
        $discount = $coupon->amount;
    }

    // Assuming a fixed shipping cost for simplicity
    $shipping = 50;

    Session::put('coupon', [
        'discount' => $discount,
        'shipping' => $shipping
    ]);

    return redirect()->back()->with('success', 'Coupon applied successfully');
}

public function Coupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'Invalid coupon code.');
        }

        $totalPrice = Cart::where('u_id', session('u_id'))
            ->join('products', 'carts.p_id', '=', 'products.p_id')
            ->sum('products.price');

        $discount = $coupon->type == 'percent'
            ? $totalPrice * ($coupon->amount / 100)
            : $coupon->amount;

        $shipping = 10; // Assuming a fixed shipping cost

        Session::put('coupon', [
            'discount' => $discount,
            'shipping' => $shipping
        ]);

        return redirect()->back()->with('success', 'Coupon applied successfully.');
    }

    public function checkout()
    {
        return view('home.checkout');
    }
}