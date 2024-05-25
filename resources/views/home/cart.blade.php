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


<section class="cart_area section_gap">
    <div style="padding-left:70%">
        <form action="{{ url('removeall') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger mt-2">Remove All</button>
        </form>
    </div>
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Image</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cartItems as $item)
                        <tr id="cart-item-{{ $item->id }}">
                            <td>
                                <div class="media">
                                    <div class="media-body">
                                        <p>{{ $item->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <img src="{{ url('images/' . $item->images) }}" alt="{{ $item->name }}" style="width: 100px;">
                                </div>
                            </td>
                            <td>
                                <h5>₹{{ $item->price }}</h5>
                            </td>
                            <td>
                                <div style="box-sizing: border-box;">
                                    <div class="product_count">
                                        <input type="number" name="qty" id="sst-{{ $item->id }}" value="{{ $item->quantity }}" title="Quantity:" class="input-text qty" min="1" max="10" onchange="updateCartQty({{ $item->id }});">
                                        <button onclick="event.preventDefault(); increaseQty({{ $item->id }});" class="increase items-count" type="button">
                                            <i class="lnr lnr-chevron-up"></i>
                                        </button>
                                        <button onclick="event.preventDefault(); decreaseQty({{ $item->id }});" class="reduced items-count" type="button">
                                            <i class="lnr lnr-chevron-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5 id="total-price-{{ $item->id }}">₹{{ $item->total_price }}</h5>
                            </td>
                            <td>
                                <form action="{{ url('removecart', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger mt-2">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <h5>No items in your cart</h5>
                            </td>
                        </tr>
                        @endforelse
                        @if($cartItems->isNotEmpty())
                        <tr>
                            <td colspan="4"></td>
                            <td>
                                <div class="cart_total">
                                    <h5>Total Quantity: <span id="totalQuantity">{{ $totalQuantity }}</span></h5>
                                    <h5>Total Price: ₹<span id="totalPrice">{{ $totalPrice }}</span></h5>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="cupon_text">
                                    
                                    <form action="{{ url('coupon') }}" method="POST">
                                        @csrf
                                        <h6>
                                            <h5>Shipping</h5>
                                            @php
                                            $user_id = session('u_id');
                                            $totalPrice = 0;
                                            $discount = 0;
                                            $shipping = 0;
                                            $finalTotal =0;
                                
                                            if ($user_id) {
                                                $totalPrice = \App\Models\Cart::where('u_id', $user_id)
                                                    ->join('products', 'carts.p_id', '=', 'products.p_id')
                                                    ->sum('products.price');
                                
                                                $coupon = session('coupon', ['discount' => 0, 'shipping' => 0]);
                                                $discount = $coupon['discount'];
                                                $shipping = $coupon['shipping'];
                                                $finalTotal = $totalPrice - $discount + $shipping;
                                            }
                                            @endphp
                                
                                            <p>Total Price: ${{ $totalPrice }}</p>
                                            <p>Discount: -${{ $discount }}</p>
                                            <p>Shipping: ${{ $shipping }}</p>
                                            <p><strong>Final Total: ${{ $finalTotal }}</strong></p>
                                        </h6>
                                        <input type="text" placeholder="Coupon Code" name="coupon_code" id="coupon_code" class="form-control">
                                        <button class="main_btn" type="submit">Apply</button>
                                    </form>
                                    {{-- <a class="gray_btn" href="{{ url('remove-coupon') }}">Close Coupon</a> --}}
                                </div>
                                
                                
                                
                            </td>
                        </tr>
                        <tr class="bottom_button">
                           
                            
                            <td>
                                <div class="cupon_text">
                                    <form action="{{ url('coupon') }}" method="POST">
                                        @csrf
                                        <h6>
                                            <h5>Shipping</h5>
    
                                            @php
                                            $user_id = session('u_id');
                                            $totalPrice = 0;
                                            $discount = 0;
                                            $shipping = 0;
                                            $finalTotal = 0;
    
                                            if ($user_id) {
                                                $totalPrice = \App\Models\Cart::where('u_id', $user_id)->sum('price');
                                                $coupon = session('coupon');
                                                $discount = $coupon['discount'] ?? 0;
                                                $shipping = $coupon['shipping'] ?? 0;
                                                $finalTotal = $totalPrice - $discount + $shipping;
                                            } else {
                                                $totalPrice = 0;
                                                $discount = 0;
                                                $shipping = 0;
                                                $finalTotal = 0;
                                            }
                                            @endphp
    
                                            <p>Total Price: ${{ $totalPrice }}</p>
                                            <p>Discount: -${{ $discount }}</p>
                                            <p>Shipping: ${{ $shipping }}</p>
                                            <p><strong>Final Total: ${{ $finalTotal }}</strong></p>
                                        </h6>
                                        <input type="text" placeholder="Coupon Code" name="coupon_code" id="coupon_code" class="form-control">
                                        <button class="main_btn" type="submit">Apply</button>
                                    </form>
                                    {{-- <a class="gray_btn" href="{{ url('remove-coupon') }}">Close Coupon</a> --}}
                                </div>
                            </td>
                        </tr>
                        {{-- <tr class="shipping_area">
                            <td></td>
                            <td></td>
                            <td>
                                <h5>Shipping</h5>
                            </td>
                            <td>
                                <div class="shipping_box">
                                    <form >
                                        @csrf
                                        <!-- Your shipping options and calculations -->
                                    </form>
                                    <h6>
                                        Calculate Shipping
                                        <i class="fa fa-caret-down" aria-hidden="true"></i>

                                        @php
                                        $user_id = session('u_id');
                                        $totalPrice = 0;
                                        $discount = 0;
                                        $shipping = 0;
                                        $finalTotal = 0;

                                        if ($user_id) {
                                            $totalPrice = \App\Models\Cart::where('u_id', $user_id)->sum('price');
                                            $coupon = session('coupon');
                                            $discount = $coupon['discount'] ?? 0;
                                            $shipping = $coupon['shipping'] ?? 0;
                                            $finalTotal = $totalPrice - $discount + $shipping;
                                        } else {
                                            $totalPrice = 0;
                                            $discount = 0;
                                            $shipping = 0;
                                            $finalTotal = 0;
                                        }
                                        @endphp

                                        <p>Total Price: ${{ $totalPrice }}</p>
                                        <p>Discount: -${{ $discount }}</p>
                                        <p>Shipping: ${{ $shipping }}</p>
                                        <p><strong>Final Total: ${{ $finalTotal }}</strong></p>
                                    </h6>
                                </div>
                            </td>
                        </tr> --}}
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

{{-- <script>
    // Your JavaScript functions
</script>

@include('home.footer') --}}


<script>
    function increaseQty(itemId) {
        var result = document.getElementById('sst-' + itemId);
        var sst = parseInt(result.value);
        if (!isNaN(sst)) {
            result.value = sst + 1;
            // Limit to max value of 10
            if (result.value > 100) {
                result.value = 100;
            }
            updateCartQty(itemId);
        }
    }

    function decreaseQty(itemId) {
        var result = document.getElementById('sst-' + itemId);
        var sst = parseInt(result.value);
        if (!isNaN(sst) && sst > 1) {
            result.value = sst - 1;
            updateCartQty(itemId);
        }
    }

    function updateCartQty(itemId) {
        var qty = document.getElementById('sst-' + itemId).value;

        fetch(`{{ url('update-cart') }}/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ qty: qty })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('total-price-' + itemId).innerText = '₹' + data.itemTotalPrice;
                document.getElementById('totalQuantity').innerText = data.totalQuantity;
                document.getElementById('totalPrice').innerText = '₹' + data.totalPrice;
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function coupon() {
        var couponCode = document.getElementById('coupon_code').value;

        fetch(`{{ url('apply-coupon') }}/${couponCode}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
       
</script>

<script>
  $(document).ready(function(){
        $('.shipping select[name=shipping]').change(function(){
            var value = $(this).val();
            if(value == 'flat_rate'){
                $('.flat_rate').show();
            }else{
                $('.flat_rate').hide();
            }
        });
    });
    
</script>

@include('home.footer')
