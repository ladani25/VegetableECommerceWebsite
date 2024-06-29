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
    <div style="padding-left:73%">
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
                                        <img src="{{ url('images/' . $item->images) }}" alt="{{ $item->name }}" style="width: 50px;">
                                    </div>
                                </td>
                                <td>
                                    <h5>₹{{ $item->price }}</h5>
                                </td>
                                <td>
                                    <div style="box-sizing: border-box;">
                                        <div class="product_count">
                                          <!-- Assume each item has a product ID associated with it, available as $item->product_id -->
                                            <input type="number" name="qty" id="sst-{{ $item->id }}" value="{{ $item->quantity }}" title="Quantity:" class="input-text qty" min="1" max="10" onchange="updateCartQty({{ $item->id }}, {{ $item->p_id }});">
                                            <button onclick="event.preventDefault(); increaseQty({{ $item->id }}, {{ $item->p_id }});" class="increase items-count" type="button">
                                                <i class="lnr lnr-chevron-up"></i>
                                            </button>
                                            <button onclick="event.preventDefault(); decreaseQty({{ $item->id }}, {{ $item->p_id }});" class="reduced items-count" type="button">
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
                                        <button type="submit" class="btn btn-danger mt-2"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
                                <td colspan="6">
                                    <div class="cart_total">
                                        <form action="{{ url('apply-coupon') }}" method="POST" class="#coupon_code">
                                            @csrf
                                            <div id="couponDetails">
                                                <input type="text" placeholder="Coupon Code" name="coupon_code" id='total-price-after-coupon'>
                                                <div style="padding-top:0.5%">
                                                    <button class="main_btn" type="submit">Apply</button>
                                                </div>
                                                <p>Total Price: <span id="total-main-price">{{ $totalPrice }}</span></p>
                                                <p>Discount: -₹<span id="displayDiscount">{{ session('coupon')['discount'] ?? 0 }}</span></p>
                                                <p>Shipping: ₹<span id="displayShipping">{{ session('coupon')['shipping'] ?? 0 }}</span></p>
                                                <p>Total Price: <span id="finalTotal">{{ $totalPrice - (session('coupon')['discount'] ?? 0) + (session('coupon')['shipping'] ?? 0) }}</span></p>
                                                {{-- <form action="{{url('order')}}" method="POST">
                                                    @csrf
                                                  
                                                <button type="submit" name="submit" class="main_btn"><a href="{{ url('checkout') }}">Checkout</a></button>
                                                </form> --}}
                                        </form>
                                        <form action="{{ url('checkout') }}" method="POST" id="checkoutForm">
                                            @csrf
                                            <input type="hidden" name="totalQuantity" value="{{ $totalQuantity }}">
                                            <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">
                                            <button type="submit" class="main_btn">Checkout</button>
                                        </form>
                                        
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@include('home.footer')

<script>
    function increaseQty(itemId, productId) {
    console.log('increaseQty called with itemId:', itemId, 'and productId:', productId);
        var result = document.getElementById('sst-' + itemId);
        var sst = parseInt(result.value);
        if (!isNaN(sst)) {
            result.value = sst + 1;
            if (result.value > 100) {
                result.value = 100;
            }
            updateCartQty(itemId, productId, 1);
        }
    }

    function decreaseQty(itemId, productId) {
        var result = document.getElementById('sst-' + itemId);
        var sst = parseInt(result.value);
        if (!isNaN(sst) && sst > 1) {
            result.value = sst - 1;
            updateCartQty(itemId, productId, -1);
        }
    }

    function updateCartQty(itemId, productId, qtyChange) {
    console.log('increaseQty called with itemId:', itemId, 'and productId:', productId);

        var qty = document.getElementById('sst-' + itemId).value;
        var couponCode = document.getElementById('coupon_code') ? document.getElementById('coupon_code').value : null;

        fetch(`{{ url('update-cart') }}/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ qty: qty, coupon_code: couponCode, product_id: productId, qty_change: qtyChange })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('total-price-' + itemId).innerText = '₹' + data.itemTotalPrice;
                document.getElementById('totalQuantity').innerText = data.totalQuantity;
                document.getElementById('totalPrice').innerText = '₹' + data.totalPrice;
                document.getElementById('total-main-price').innerText = '₹' + data.totalPrice;
                document.getElementById('displayDiscount').innerText = '₹' + data.discount;
                document.getElementById('displayShipping').innerText = '₹' + data.shipping;
                document.getElementById('finalTotal').innerText = '₹' + data.finalTotal;

                // Update product quantity
                document.getElementById('product-qty-' + productId).innerText = data.productQuantity;
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

