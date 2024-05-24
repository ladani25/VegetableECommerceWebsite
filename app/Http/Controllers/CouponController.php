<?php
// app/Http/Controllers/CouponController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Cart;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'DESC')->paginate(10);
        return view('backend.coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('backend.coupon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|unique:coupons',
            'type' => 'required|in:fixed,percent',
            'amount' => 'required|numeric',
        ]);

        $data = $request->all();
        $coupon = Coupon::create($data);

        if ($coupon) {
            return redirect()->route('coupon.index')->with('success', 'Coupon successfully added');
        } else {
            return redirect()->route('coupon.index')->with('error', 'Please try again');
        }
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            return view('backend.coupon.edit', compact('coupon'));
        } else {
            return redirect()->route('coupon.index')->with('error', 'Coupon not found');
        }
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        $request->validate([
            'coupon_code' => 'required|string|unique:coupons,coupon_code,' . $coupon->id,
            'type' => 'required|in:fixed,percent',
            'amount' => 'required|numeric',
        ]);

        $data = $request->all();
        $coupon->update($data);

        if ($coupon) {
            return redirect()->route('coupon.index')->with('success', 'Coupon successfully updated');
        } else {
            return redirect()->route('coupon.index')->with('error', 'Please try again');
        }
    }

    public function destroy($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $coupon->delete();
            return redirect()->route('coupon.index')->with('success', 'Coupon successfully deleted');
        } else {
            return redirect()->route('coupon.index')->with('error', 'Coupon not found');
        }
    }

    // public function applyCoupon(Request $request)
    // {
    //     $request->validate([
    //         'coupon_code' => 'required|string',
    //     ]);

    //     $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();

    //     if (!$coupon) {
    //         return redirect()->back()->with('error', 'Invalid coupon code');
    //     }

    //     $totalPrice = Cart::where('u_id', auth()->user()->u_id)->sum('price');
    //     $discount = $coupon->discount($totalPrice);

    //     session()->put('coupon', [
    //         'id' => $coupon->id,
    //         'code' => $coupon->coupon_code,
    //         'discount' => $discount,
    //     ]);

    //     return redirect()->back()->with('success', 'Coupon applied successfully');
    // }

    public function applyCoupon(Request $request)
{
    $request->validate([
        'coupon_code' => 'required|string',
    ]);

    // Check if the user is authenticated
    if (!auth()->check()) {
        return redirect()->back()->with('error', 'You need to login to apply a coupon.');
    }

    $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();

    if (!$coupon) {
        return redirect()->back()->with('error', 'Invalid coupon code');
    }

    // Retrieve the authenticated user's ID
    $userId = auth()->user()->id;

    // Assuming your Cart model has a user_id field instead of u_id
    $totalPrice = Cart::where('user_id', $userId)->sum('price');
    $discount = $coupon->discount($totalPrice);

    session()->put('coupon', [
        'id' => $coupon->id,
        'code' => $coupon->coupon_code,
        'discount' => $discount,
    ]);

    return redirect()->back()->with('success', 'Coupon applied successfully');
}
    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Coupon removed successfully');
    }
}
