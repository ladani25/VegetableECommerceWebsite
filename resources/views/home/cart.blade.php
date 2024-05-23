@include('home.header')

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
                        <tr>
                            <td>
                                <div class="media">
                                    <div class="media-body">
                                        <p>{{ optional($item)->name ?? 'Product not found' }}</p>
                                    </div>
                                </div>
                            </td>
                            <!-- Image column -->
                            <td>
                                <div class="d-flex">
                                    <img src="{{ url('images/' . $item->images) }}" alt="{{ $item->name }}" style="width: 100px;">
                                </div>
                            </td>
                            <!-- Price column -->
                            <td>
                                <h5>₹{{ optional($item)->price ?? 'N/A' }}</h5>
                            </td>
                            <!-- Quantity column -->
                            <td>
                                <div style="box-sizing: border-box;">
                                    <form id="update-cart-form-{{ $item->id }}" action="{{ url('update-cart', $item->id) }}" method="POST">
                                        @csrf
                                        <div class="product_count">
                                            <input type="text" name="qty" id="sst" maxlength="12" title="Quantity:" class="input-text qty">
                                            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button">
                                                <i class="lnr lnr-chevron-up"></i>
                                            </button>
                                            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;" class="reduced items-count" type="button">
                                                <i class="lnr lnr-chevron-down"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                            <!-- Total Price column -->
                            <td>
                                <h5>₹{{ $item->total_price }}</h5>
                            </td>
                            <!-- Remove button column -->
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
                        <!-- Total quantity and price row -->
                        <tr>
                            <td colspan="4"></td>
                            <td>
                                <div class="cart_total">
                                    <h5>Total Quantity: {{ $totalQuantity }}</h5>
                                    <h5>Total Price: ₹{{ $totalPrice }}</h5>
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
