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

  <!--================Home Banner Area =================-->
  <section class="home_banner_area mb-40">
    <div class="banner_inner d-flex align-items-center">
      <div class="container">
        <div class="banner_content row">
          {{-- <div class="col-lg-12">
            <p class="sub text-uppercase">men Collection</p>
            <h3><span>Show</span> Your <br />Personal <span>Style</span></h3>
            <h4>Fowl saw dry which a above together place.</h4>
            <a class="main_btn mt-40" href="#">View Collection</a>
          </div> --}}
        </div>
      </div>
    </div>
  </section>
  <!--================End Home Banner Area =================-->

  <!-- Start feature Area -->
  <section class="feature-area section_gap_bottom_custom">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="single-feature">
            <a href="#" class="title">
              <i class="flaticon-money"></i>
              <h3>Money back gurantee</h3>
            </a>
            <p>Shall open divide a one</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="single-feature">
            <a href="#" class="title">
              <i class="flaticon-truck"></i>
              <h3>Free Delivery</h3>
            </a>
            <p>Shall open divide a one</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="single-feature">
            <a href="#" class="title">
              <i class="flaticon-support"></i>
              <h3>Alway support</h3>
            </a>
            <p>Shall open divide a one</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="single-feature">
            <a href="#" class="title">
              <i class="flaticon-blockchain"></i>
              <h3>Secure payment</h3>
            </a>
            <p>Shall open divide a one</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End feature Area -->

  <!--================ Feature Product Area =================-->
  {{-- <section class="feature_product_area section_gap_bottom_custom">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="main_title">
            <h2><span>Featured product</span></h2>
            <p>Bring called seed first of third give itself now ment</p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="single-product">
            <div class="product-img">
              <img class="img-fluid w-100" src="{{url('front-end/img/product/feature-product/f-p-1.jpg')}}" alt="" />
              <div class="p_icon">
                <a href="#">
                  <i class="ti-eye"></i>
                </a>
                <a href="#">
                  <i class="ti-heart"></i>
                </a>
                <a href="#">
                  <i class="ti-shopping-cart"></i>
                </a>
              </div>
            </div>
            <div class="product-btm">
              <a href="#" class="d-block">
                <h4>Latest men’s sneaker</h4>
              </a>
              <div class="mt-3">
                <span class="mr-4">$25.00</span>
                <del>$35.00</del>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="single-product">
            <div class="product-img">
              <img class="img-fluid w-100" src="{{url('front-end/img/product/feature-product/f-p-2.jpg')}}" alt="" />
              <div class="p_icon">
                <a href="#">
                  <i class="ti-eye"></i>
                </a>
                <a href="#">
                  <i class="ti-heart"></i>
                </a>
                <a href="#">
                  <i class="ti-shopping-cart"></i>
                </a>
              </div>
            </div>
            <div class="product-btm">
              <a href="#" class="d-block">
                <h4>Red women purses</h4>
              </a>
              <div class="mt-3">
                <span class="mr-4">$25.00</span>
                <del>$35.00</del>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="single-product">
            <div class="product-img">
              <img class="img-fluid w-100" src="{{url('front-end/img/product/feature-product/f-p-3.jpg')}}" alt="" />
              <div class="p_icon">
                <a href="#">
                  <i class="ti-eye"></i>
                </a>
                <a href="#">
                  <i class="ti-heart"></i>
                </a>
                <a href="#">
                  <i class="ti-shopping-cart"></i>
                </a>
              </div>
            </div>
            <div class="product-btm">
              <a href="#" class="d-block">
                <h4>Men stylist Smart Watch</h4>
              </a>
              <div class="mt-3">
                <span class="mr-4">$25.00</span>
                <del>$35.00</del>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> --}}
  <!--================ End Feature Product Area =================-->

  <!--================ Offer Area =================-->
  <section>
    <div class="container">
      <div class="row justify-content-center-container-fluid" >
        
  
        {{-- <a class="na"> --}}
          <img src="{{url('ecommerces/banner/banner.jpg')}}" alt=""/>
        {{-- </a> --}}
      </div>
    </div>
  </section>

  <!--================ Inspired Product Area =================-->
  <section class="inspired_product_area section_gap_bottom_custom">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">
          <div class="main_title">
            <h2><span>Inspired products</span></h2>
            <p>Bring called seed first of third give itself now ment</p>
          </div>
        </div>
      </div>

      <div class="latest_product_inner">
        <div class="row">
          @foreach ($products as $product)
          <div class="col-lg-4 col-md-6"   >
              <div class="single-product" >
                  <div class="product-img" >
                      <img class="card-img" style='height:200px; width:300px;' src="{{ url('images/' . $product->images) }}" alt="{{ $product->name }}"/>
                      <div class="p_icon">
                          <a href="{{url('products_deatils', ['p_id' => $product->p_id])}}">
                              <i class="ti-eye"></i>
                          </a>
                        {{-- <form action="{{url('add')}}" method="POST">
                          @csrf
                          <input type="hidden" name="product_id" value="{{ $product->p_id }}">
                          <button type="submit"> <i class="ti-heart"></i></button>
                      </form>  --}}

                      <form action="{{ url('add') }}" method="POST" class="add-to-wishlist-form" data-product-id="{{ $product->p_id }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->p_id }}">
                        <button type="submit">
                            <i class="ti-heart heart-icon {{ in_array($product->p_id, $wishlist) ? 'heart-red' : '' }}"></i>
                        </button>
                    </form>
                      <form action="{{url('addcart')}}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->p_id }}">
                        {{-- <input type="hidden" name="user_id" value="{{ $user->u_id }}"> --}}
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
  </section>

  
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

 @include('home.footer');