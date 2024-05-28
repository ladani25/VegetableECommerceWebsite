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
                                <td colspan="6">
                                    <div class="cart_total">
                                        <form action="{{ url('apply-coupon') }}" method="POST">
                                            @csrf
                                            <div id="couponDetails">
                                                <input type="text" placeholder="Coupon Code" name="coupon_code" id="coupon_code" class="form-control">
                                                <button class="main_btn" type="submit">Apply</button>
                                                <p>Total Price: ₹<span id="displayTotalPrice">{{ $totalPrice }}</span></p>
                                                <p>Discount: -₹<span id="displayDiscount">{{ session('coupon')['discount'] ?? 0 }}</span></p>
                                                <p>Shipping: ₹<span id="displayShipping">{{ session('coupon')['shipping'] ?? 0 }}</span></p>
                                                <p><strong>Final Total: ₹<span id="displayFinalTotal">{{ $totalPrice - (session('coupon')['discount'] ?? 0) + (session('coupon')['shipping'] ?? 0) }}</span></strong></p>
                                            </div>
                                            {{-- <input type="text" placeholder="Coupon Code" name="coupon_code" id="coupon_code" class="form-control">
                                            <button class="main_btn" type="submit">Apply</button> --}}
                                            <button class="main_btn" type="submit"><a href="{{ url('checkout') }}">Checkout</a></button>
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
    function increaseQty(itemId) {
        var result = document.getElementById('sst-' + itemId);
        var sst = parseInt(result.value);
        if (!isNaN(sst)) {
            result.value = sst + 1;
            if (result.value > 10) {
                result.value = 10;
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
</script>
