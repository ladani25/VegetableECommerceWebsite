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
                    <form class="row contact_form" action="{{ url('order_details') }}" method="POST">
                        @csrf
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="first" name="first_name" placeholder="First Name" required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="last" name="last_name" placeholder="Last Name" required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="text" class="form-control" id="number" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-6 form-group p_star">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="state" name="state" placeholder="State" required>
                        </div>
                        <div class="col-md-12 form-group p_star">
                            <input type="text" class="form-control" id="zip" name="zip" placeholder="Zip Code" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <h3>Shipping Details</h3>
                                <label for="shipping">
                                    Same as billing
                                    <input type="checkbox" id="same_as_billing" name="same_as_billing" value="1">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="btn-btn-primary">Place Order</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4">
                    <div class="order_box">
                        <h2>Your Order</h2>
                        <ul class="list">
                            {{-- <li><a href="#">Product <span>Total</span></a></li>
                            @foreach($cartItems as $item)
                                <li><a href="#">{{ $item->product->name }} <span class="middle"> {{ $item->quantity }}</span> <span class="last">₹{{ $item->quantity * $item->product->price }}</span></a></li>
                            @endforeach
                        </ul> --}}
                        <ul class="list list_2">
                            {{-- <li><a>Subtotal <span>₹{{ $totalPrice }}</span></a></li> --}}
                            <li><a> <p>Discount: -₹<span id="displayDiscount">{{ session('coupon')['discount'] ?? 0 }}</span></p></a></li>
                            <li><a>Shipping: ₹<span id="displayShipping">{{ session('coupon')['shipping'] ?? 0 }}</span></a></li>
                            {{-- <li><a>Total Price: <span id="total-pro-prices">{{ $totalPrice - (session('coupon')['discount'] ?? 0) + (session('coupon')['shipping'] ?? 0) }}</span></a></li> --}}
                        </ul>
                        
                        <div class="payment_item">
                            <div class="radion_btn">
                                <input type="radio" id="f-option5" name="payment" value="cheque" checked>
                                <label for="f-option5">Check payments</label>
                                <div class="check"></div>
                            </div>
                            <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                        </div>
                        <div class="payment_item active">
                            <div class="radion_btn">
                                <input type="radio" id="f-option6" name="payment" value="paypal">
                                <label for="f-option6">Paypal</label>
                                <img src="{{ url('front-end/img/product/single-product/card.jpg')}}" alt="">
                                <div class="check"></div>
                            </div>
                            <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                        </div>
                        <button class="primary-btn" type="submit">Proceed to PayPal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('home.footer')
