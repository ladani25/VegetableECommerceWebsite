<!-- Include header -->
@include('home.header')

<!-- Styles -->
<style>
    .heart-red {
        color: red;
    }
    .product {
        display: flex;
        align-items: center;
        margin: 10px 0;
    }
    .heart {
        cursor: pointer;
        font-size: 24px;
        margin-left: 10px;
    }
    .heart.red {
        color: red;
    }
    .range_item {
        margin: 20px 0;
    }
    .pagination-links {
        display: flex;
        justify-content: center;
        margin-top: 10px;
    }
    .pagination-links a, .pagination-links span {
        margin: 0 5px;
        /* padding: 10px 10px; */
        /* border: 1px solid #ddd; */
        text-decoration: none;
        color: #333;
    }
    .pagination-links .active span {
        background-color: #007bff;
        color: white;
    }
    svg.w-5.h-5 {
    width: 20px;
}

.flex.justify-between.flex-1.sm\:hidden {
    display: none;
}
p.text-sm.text-gray-700.leading-5.dark\:text-gray-400 {
    display: none;
}
</style>

<!-- Category Product Area -->
<section class="cat_product_area section_gap">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                
                <div class="product_top_bar">
                    <div class="left_dorp">
                        <input type="text" id="search" placeholder="Search for products..." style="padding: 5px; margin-right: 10px;">
                        <select class="sorting">
                            <option value="1">Default sorting</option>
                            <option value="2">Default sorting 01</option>
                            <option value="4">Default sorting 02</option>
                        </select>
                        <select class="show">
                            <option value="1">Show 12</option>
                            <option value="2">Show 14</option>
                            <option value="4">Show 16</option>
                        </select>
                    </div>
                </div>
                
                <div class="latest_product_inner">
                    <div class="row" id="product-list">
                        {{-- @include('home.product_list') --}}
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
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="left_sidebar_area">
                    <aside class="left_widgets p_filter_widgets">
                        <div class="l_w_title">
                            <h3>Vegetables Categories</h3>
                        </div>
                        <div class="widgets_inner">
                            <ul class="list">
                                @foreach ($categories as $category)
                                <li>
                                    <a href="{{url('products.category', ['c_id' => $category->c_id]) }}">{{ $category->c_name }}</a>                     
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </aside>
                    <aside class="left_widgets p_filter_widgets">
                        <div class="l_w_title">
                            <h3>Price Filter</h3>
                        </div>
                        <div class="widgets_inner">
                            <div class="range_item">
                                <div id="slider-range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                    <div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span>
                                    <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span>
                                </div>
                                <div class="">
                                    <label for="amount">Price Range: </label>
                                    <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include footer -->
@include('home.footer')

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize the price range slider
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 1000,
            values: [0, 1000],
            slide: function(event, ui) {
                $("#amount").val("₹" + ui.values[0] + " - ₹" + ui.values[1]);
            },
            change: function(event, ui) {
                filterProducts(ui.values[0], ui.values[1]);
            }
        });

        $("#amount").val("₹" + $("#slider-range").slider("values", 0) +
            " - ₹" + $("#slider-range").slider("values", 1));

        // Function to filter products based on price range
        function filterProducts(minPrice, maxPrice) {
            $(".product-item").each(function() {
                var productPrice = parseInt($(this).data('price'), 10);
                if (productPrice >= minPrice && productPrice <= maxPrice) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Search functionality
        $('#search').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            $(".product-item").each(function() {
                var productName = $(this).data('name').toLowerCase();
                if (productName.indexOf(searchTerm) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Pagination functionality
        $(document).on('click', '.pagination-links a', function(event) {
            event.preventDefault();
            var url = $(this).attr('href');
            fetchProducts(url);
        });

        function fetchProducts(url) {
            $.ajax({
                url: url,
                success: function(data) {
                    $('#product-list').html(data);
                }
            });
        }
    });
</script>
