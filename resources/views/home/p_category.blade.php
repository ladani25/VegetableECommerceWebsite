{{-- <h1>{{ $category->c_name }}</h1>
<ul>
    @foreach ($products as $product)
        <li>
            <a href="{{url('products.show', ['c_id' => $product->c_id]) }}">{{ $product->name }}</a>
        </li>
    @endforeach
</ul> --}}


@include('home.header')
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
</style>

<!--================Category Product Area =================-->
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
                    <div class="row">
                        @foreach ($product as $product)
                        <div class="col-lg-4 col-md-6">
                            <div class="single-product">
                                <div class="product-img">
                                    <img class="card-img" style='height:200px; width:300px;' src="{{ url('images/' . $product->images) }}" alt="{{ $product->name }}"/>
                                    <div class="p_icon">
                                        <a href="{{ url('products_details', ['p_id' => $product->p_id]) }}">
                                            <i class="ti-eye"></i>
                                        </a>
                                        {{-- <form action="{{ url('add') }}" method="POST" class="add-to-wishlist-form" data-product-id="{{ $product->p_id }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->p_id }}">
                                            <button type="submit">
                                                <i class="ti-heart heart-icon {{ in_array($product->p_id, $wishlist) ? 'heart-red' : '' }}"></i>
                                            </button>
                                        </form> --}}
                                        <form action="{{ url('addcart') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->p_id }}">
                                            <button type="submit"><i class="ti-shopping-cart"></i></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="product-btm">
                                    <a href="#" class="d-block">
                                        <h4>{{ $product->name }}</h4>
                                    </a>
                                    <div class="mt-3">
                                        <span class="mr-4">₹{{ $product->price }}</span>
                                        <!-- Add any additional fields here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
              
                </div>
            </div>
            <div class="col-lg-3">
                <div class="left_sidebar_area">
                    {{-- <aside class="left_widgets p_filter_widgets">
                        <div class="l_w_title">
                            <h3>Vegetables Categories</h3>
                        </div>
                        <div class="widgets_inner">
                         
                            <ul class="list">
                                @foreach ($category as $category)
                                <li>
                                    <a href="{{url('products.category', ['c_id' => $category->c_id]) }}">{{ $category->c_name }}</a>                     
                                </li>
                                @endforeach
                            </ul>
                          
                            </ul>
                        </div>
                    </aside> --}}

                    <aside class="left_widgets p_filter_widgets">
                        <div class="l_w_title">
                          <h3>Price Filter</h3>
                        </div>
                        <div class="widgets_inner">
                          <div class="range_item">
                            <div id="slider-range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"><div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span></div>
                            <div class="">
                              <label for="amount">Price : </label>
                              <input type="text" id="amount" readonly="">
                            </div>
                          </div>
                        </div>
                      </aside>


                    <aside class="left_widgets p_filter_widgets">
                        <div class="l_w_title">
                            <h3>Price Filter</h3>
                        </div>
                        <div class="widgets_inner">
                            <div class="range_item">
                                <div id="slider-range"></div>
                                <div class="">
                                    <label for="amount">Price : </label>
                                    <input type="text" id="amount" readonly />
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>
<!--================End Category Product Area =================-->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var addToWishlistForms = document.querySelectorAll('.add-to-wishlist-form');

        addToWishlistForms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent form submission

                var heartIcon = this.querySelector('.heart-icon');
                var productId = this.getAttribute('data-product-id');

                if (!heartIcon.classList.contains('heart-red')) {
                    heartIcon.classList.add('heart-red'); // Add the red color class
                } else {
                    heartIcon.classList.remove('heart-red'); // Remove the red color class
                }

                // Submit the form
                var formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok.');
                })
                .then(data => {
                    // Handle success response
                    console.log(data);

                    // Update the wishlist in the session
                    fetch('/update-wishlist', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ productId: productId, action: heartIcon.classList.contains('heart-red') ? 'add' : 'remove' })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to update wishlist.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                    })
                    .catch(error => {
                        console.error('Error occurred while updating wishlist:', error);
                    });

                })
                .catch(error => {
                    console.error('Error occurred:', error);
                });
            });
        });
    });


</script>

<script>
    $(document).ready(function() {
        $(".category-link").on("click", function(e) {
            e.preventDefault();
            var c_id = $(this).attr("data-id");
            $.ajax({
                type: "GET",
                url: "{{ url('shop') }}",
                data: { c_id: c_id },
                success: function(data) {
                    $("#products-container").html("");
                    $.each(data.products, function(index, product) {
                        $("#products-container").append(`
                            <div class="single-product">
                                <div class="product-img">
                                   
                                    <!-- Add other product details here -->
                                </div>
                            </div>
                        `);
                    });
                }
            });
        });
    });
</script>



@include('home.footer')



