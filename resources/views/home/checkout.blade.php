@include('home.header')

<!--================Checkout Area =================-->
<section class="checkout_area section_gap">
  <div class="container">
    <div class="billing_details">
      <div class="row">
        <div class="col-lg-8">
          <h3>Billing Details</h3>
          <form class="row contact_form" action="{{ url('addorder') }}" method="post" novalidate="novalidate">
            @csrf
            <div class="col-md-6 form-group p_star">
              <input type="text" class="form-control" id="first" name="first_name"  required/>
              <span class="placeholder" data-placeholder="First name"></span>
            </div>
            <div class="col-md-6 form-group p_star">
              <input type="text" class="form-control" id="last" name="last_name" required/>
              <span class="placeholder" data-placeholder="Last name"></span>
            </div>
            <div class="col-md-12 form-group">
              <input type="text" class="form-control" id="company" name="company" placeholder="Company name"/>
            </div>
            <div class="col-md-6 form-group p_star">
              <input type="text" class="form-control" id="number" name="phone" required/>
              <span class="placeholder" data-placeholder="Phone number"></span>
            </div>
            <div class="col-md-6 form-group p_star">
              <input type="email" class="form-control" id="email" name="email" required/>
              <span class="placeholder" data-placeholder="Email Address"></span>
            </div>
           
            <div class="col-md-12 form-group p_star">
              <input type="text" class="form-control" id="add1" name="address_line1" required/>
              <span class="placeholder" data-placeholder="Address line 01"></span>
            </div>
            <div class="col-md-12 form-group p_star">
              <input type="text" class="form-control" id="add2" name="address_line2"/>
              <span class="placeholder" data-placeholder="Address line 02"></span>
            </div>
            <div class="col-md-12 form-group p_star">
              <input type="text" class="form-control" id="city" name="city" required/>
              <span class="placeholder" data-placeholder="Town/City"></span>
            </div>
           
            <div class="col-md-12 form-group">
              <input type="text" class="form-control" id="zip" name="zip" placeholder="Postcode/ZIP" required/>
            </div>
            <div class="col-md-12 form-group">
              <div class="creat_account">
                <input type="checkbox" id="f-option2" name="create_account"/>
                <label for="f-option2">Create an account?</label>
              </div>
            </div>
            <div class="col-md-12 form-group">
              <div class="creat_account">
                <h3>Shipping Details</h3>
                <input type="checkbox" id="f-option3" name="different_shipping_address"/>
                <label for="f-option3">Ship to a different address?</label>
              </div>
              <textarea class="form-control" name="order_notes" id="message" rows="1" placeholder="Order Notes"></textarea>
            </div>
            <div class="col-md-12 form-group">
              <button type="submit" class="btn submit_btn">Place Order</button>
            </div>
          </form>
        </div>
        <div class="col-lg-4">
          <div class="order_box">
            <form action="{{url('order')}}">
            <h2>Your Order</h2>
            <ul class="list list_2">
              <li><p>Total Price: ₹<span id="displayTotalPrice">{{ $totalPrice }}</span></p></li>
              <li><p name="Discount">Discount: -₹<span id="displayDiscount">{{ session('coupon')['discount'] ?? 0 }}</span></p></li>
              <li><p>Shipping: ₹<span id="displayShipping">{{ session('coupon')['shipping'] ?? 0 }}</span></p></li>
              <li><p><strong>Final Total: ₹<span id="displayFinalTotal">{{ $totalPrice - (session('coupon')['discount'] ?? 0) + (session('coupon')['shipping'] ?? 0) }}</span></strong></p></li>
              <button><a href="{{url('placeorder')}}">place order</a></button>
            </ul>
            </form>
            <div class="payment_item">
              <div class="radion_btn">
                <input type="radio" id="f-option5" name="payment_method" value="check" required/>
                <label for="f-option5">Check payments</label>
                <div class="check"></div>
              </div>
              <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
            </div>
            <div class="payment_item active">
              <div class="radion_btn">
                <input type="radio" id="f-option6" name="payment_method" value="paypal" required/>
                <label for="f-option6">Paypal </label>
                <img src="img/product/single-product/card.jpg" alt=""/>
                <div class="check"></div>
              </div>
              <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
            </div>
            <div class="creat_account">
              <input type="checkbox" id="f-option4" name="terms" required/>
              <label for="f-option4">I’ve read and accept the </label>
              <a href="#">terms & conditions*</a>
            </div>
            <a class="main_btn" href="#" onclick="document.querySelector('form.contact_form').submit();">Proceed to Paypal</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--================End Checkout Area =================-->

@include('home.footer')
