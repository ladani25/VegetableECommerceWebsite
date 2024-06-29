<!-- resources/views/products/partials/product_list.blade.php -->
<div class="row">
    @foreach ($products as $product)
    <div class="col-lg-4 col-md-6 product-item" data-price="{{ $product->price }}" data-name="{{ $product->name }}">
        <div class="single-product">
            <div class="product-img">
                <img class="card-img" style="height: 200px; width: 300px;" src="{{ url('images/' . $product->images) }}" alt="{{ $product->name }}"/>
                <div class="p_icon">
                    <a href="{{ url('products_details', ['p_id' => $product->p_id]) }}">
                        <i class="ti-eye"></i>
                    </a>
                    <form action="{{ url('add') }}" method="POST" class="add-to-wishlist-form" data-product-id="{{ $product->p_id }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->p_id }}">
                        <button type="submit">
                            <i class="ti-heart heart-icon {{ in_array($product->p_id, $wishlist) ? 'heart-red' : '' }}"></i>
                        </button>
                    </form>
                    <form action="{{ url('addcart') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->p_id }}">
                        <button type="submit"><i class="ti-shopping-cart"></i></button>
                    </form>
                </div>
            </div>
            <div class="product-item" data-price="{{ $product->price }}">
                <div class="product-btm">
                    <a href="#" class="d-block">
                        <h4>{{ $product->name }}</h4>
                    </a>
                    <div class="mt-3">
                        <span class="mr-4">₹{{ $product->price }}</span>
                        <!-- Additional fields can be added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="pagination-links">
    {{ $products->links() }}
</div>
