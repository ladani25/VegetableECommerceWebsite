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
                                <option value="razorpay" {{ old('payment_method') == 'razorpay' ? 'selected' : '' }}>Razorpay</option>
                                <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cash on Delivery</option>
                            </select>
                            @if ($errors->has('payment_method'))
                                <span class="text-danger">{{ $errors->first('payment_method') }}</span>
                            @endif
                            @if (isset($payment_id))
                            <input type="hidden" name="payment_id" value="{{ $payment_id }}">
                        @endif
                        </div>
                        
                        <div class="col-md-12 form-group">
                            <button type="submit" name="submit" class="btn btn-primary" id="place_order_btn">Place Order</button>
                        </div>
                    </form>
                    <div id="razorpay-button-container" style="display: none;">
                        <button id="rzp-button1" class="btn btn-primary">Pay with Razorpay</button>
                    </div>
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

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
{{-- <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ env('RAZORPAY_KEY') }}", // Enter the Key ID generated from the Dashboard
        "amount": "{{ $totalPrice * 100 }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise or ₹500.
        "currency": "INR",
        "name": "{{ env('APP_NAME') }}",
        "description": "Thank you for shopping with us",
        "order_id": "{{ Session::get('order_id') }}", // Replace with Order ID generated in Step 1
        "callback_url": "https://yourdomain.com/payment-success", // Your callback URL
        "notes": {
            "address": "Razorpay Corporate Office"
        },
        "theme": {
            "color": "#3399cc"
        },
        "handler": function (response){
            // Handle the successful payment response
            console.log(response);

            // Add the payment ID to the form and submit the form
            var form = document.getElementById('checkout_form');
            var paymentIdInput = document.createElement('input');
            paymentIdInput.type = 'hidden';
            paymentIdInput.name = 'payment_id';
            paymentIdInput.value = response.razorpay_payment_id;
            form.appendChild(paymentIdInput);
            form.submit();
        }
    };

    var rzp1 = new Razorpay(options);

    document.getElementById('rzp-button1').onclick = function(e){
        e.preventDefault();
        rzp1.open();
    }

    document.getElementById('payment_method').onchange = function() {
        var value = this.value;
        if (value === 'razorpay') {
            document.getElementById('razorpay-button-container').style.display = 'block';
        } else {
            document.getElementById('razorpay-button-container').style.display = 'none';
        }
    }
</script> --}}

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ env('RAZORPAY_KEY') }}",
        "amount": "{{ $totalPrice * 100 }}",
        "currency": "INR",
        "name": "{{ env('APP_NAME') }}",
        "description": "Thank you for shopping with us",
        "order_id": "{{ Session::get('order_id') }}",
        "callback_url": "https://yourdomain.com/payment-success",
        "notes": {
            "address": "Razorpay Corporate Office"
        },
        "theme": {
            "color": "#3399cc"
        },
        "handler": function (response){
            // Handle the successful payment response
            console.log(response);

            // Add the payment ID to the form and submit the form
            var form = document.getElementById('checkout_form');
            var paymentIdInput = document.createElement('input');
            paymentIdInput.type = 'hidden';
            paymentIdInput.name = 'payment_id';
            paymentIdInput.value = response.razorpay_payment_id;
            form.appendChild(paymentIdInput);

            // Submit the form
            form.submit();
        }
    };

    var rzp1 = new Razorpay(options);

    document.getElementById('rzp-button1').onclick = function(e){
        e.preventDefault();
        rzp1.open();
    }

    document.getElementById('payment_method').onchange = function() {
        var value = this.value;
        if (value === 'razorpay') {
            document.getElementById('razorpay-button-container').style.display = 'block';
        } else {
            document.getElementById('razorpay-button-container').style.display = 'none';
        }
    }
</script>



@include('home.footer')