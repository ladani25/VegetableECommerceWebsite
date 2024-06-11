@include('home.header')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<section class="checkout_area section_gap">
    <div class="container">
        <div class="billing_details">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Billing Details</h3>
                    <form class="row contact_form" action="{{ url('place_order') }}" method="post" id="checkout_form">
                        @csrf
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="first" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" required>
                            @if ($errors->has('first_name'))
                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="last" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required>
                            @if ($errors->has('last_name'))
                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="number" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" required>
                            @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="address" name="address1" placeholder="Address" value="{{ old('address1') }}" required>
                            @if ($errors->has('address1'))
                                <span class="text-danger">{{ $errors->first('address1') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="address2" name="address2" placeholder="Address Line 2" value="{{ old('address2') }}">
                            @if ($errors->has('address2'))
                                <span class="text-danger">{{ $errors->first('address2') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="post_code" name="post_code" placeholder="Post Code" value="{{ old('post_code') }}">
                            @if ($errors->has('post_code'))
                                <span class="text-danger">{{ $errors->first('post_code') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12 form-group">
                            <select class="form-control" name="payment_method" id="payment_method" required>
                                <option value="" disabled selected>Select Payment Method</option>
                                <option id="rzp-button1" value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cash on Delivery</option>
                            </select>
                            @if ($errors->has('payment_method'))
                                <span class="text-danger">{{ $errors->first('payment_method') }}</span>
                            @endif
                        </div>
                        
                        <div class="col-md-12 form-group">
                            <button type="submit" name="submit" class="btn btn-primary" id="place_order_btn">Place Order</button>
                        </div>
                    </form>
                    <div id="paypal-button-container" style="display: none;"></div>
                </div>
                <div class="col-lg-4">
                    <div class="order_box">
                        <h2>Your Order</h2>
                        <ul class="list">
                            <li><a href="#">Product <span>Total</span></a></li>
                            @foreach($cartItems as $item)
                                <li><a href="#">{{ $item->product->name }} <span class="middle">{{ $item->quantity }}</span> <span class="last">₹{{ $item->quantity * $item->product->price }}</span></a></li>
                            @endforeach
                        </ul>
                        <ul class="list list_2">
                            <li><a>Subtotal <span name="sub_totale">₹{{ $totalPrice }}</span></a></li>
                            <li><a>Discount: -₹<span id="displayDiscount">{{ session('coupon')['discount'] ?? 0 }}</span></a></li>
                            <li><a>Shipping: ₹<span id="displayShipping">{{ session('coupon')['shipping'] ?? 0 }}</span></a></li>
                            <li><a>Total Price: <span id="total-pro-prices" name="totalal_amout">{{ $totalPrice - (session('coupon')['discount'] ?? 0) + (session('coupon')['shipping'] ?? 0) }}</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('home.footer')

{{-- <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "YOUR_KEY_ID",
    "amount": "50000",
    "currency": "INR",
    "name": "Acme Corp",
    "description": "Test Transaction",
    "image": "https://example.com/your_logo",
    "order_id": "order_9A33XWu170gUtm",
    "callback_url": "https://eneqd3r9zrjok.x.pipedream.net/",
    "prefill": {
        "name": "Gaurav Kumar",
        "email": "gaurav.kumar@example.com",
        "contact": "9000090000"
    },
    "notes": {
        "address": "Razorpay Corporate Office"
    },
    "theme": {
        "color": "#3399cc"
    }
};
var rzp1 = new Razorpay(options);
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script> --}}
