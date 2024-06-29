
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="img/favicon.png" type="image/png" />
  <title>Organic Valley</title>
  <!-- Bootstrap CSS -->
  
  <link rel="stylesheet" href="{{url('front-end/css/bootstrap.css')}}" />
  <link rel="stylesheet" href="{{url('front-end/vendors/linericon/style.css')}}" />
  <link rel="stylesheet" href="{{url('front-end/css/font-awesome.min.css')}}" />
  <link rel="stylesheet" href="{{url('front-end/css/themify-icons.css')}}" />
  <link rel="stylesheet" href="{{url('front-end/css/flaticon.css')}}" />
  <link rel="stylesheet" href="{{url('front-end/vendors/owl-carousel/owl.carousel.min.cs')}}s" />
  <link rel="stylesheet" href="{{url('front-end/vendors/lightbox/simpleLightbox.css')}}" />
  <link rel="stylesheet" href="{{url('front-end/vendors/nice-select/css/nice-select.css')}}" />
  <link rel="stylesheet" href="{{url('front-end/vendors/animate-css/animate.css')}}" />
  <link rel="stylesheet" href="{{url('front-end/vendors/jquery-ui/jquery-ui.css')}}" />
  <!-- main css -->
  <link rel="stylesheet" href="{{url('front-end/css/style.css')}}" />
  <link rel="stylesheet" href="{{url('front-end/css/responsive.css')}}" />

<style>
  .tip
  {
    border-bottom-style solid
border-bottom-width 0px
border-left-style solid
border-left-width 0px
border-right-style solid
border-right-width 0px
border-top-style solid
border-top-width 0px
box-sizing border-box
color rgb(0, 0, 0)
cursor pointer
d path("M 0 0 H 24 V 24 H 0 Z")
display inline
fill rgb(255, 255, 255)
font-family ProximaNova, Helvetica, Arial, sans-serif
font-size 16px
font-weight 400
height auto
transform-origin 0px 0px
  }
  </style>
  
</head>

<body>
  <!--================Header Menu Area =================-->
  <header class="header_area">
    <div class="main_menu">
      <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light w-100">
          <!-- Brand and toggle get grouped for better mobile display -->
          <a class="navbar-brand logo_h" href="{{url('home')}}">
            <img src="{{url('front-end/img/logo.png')}}" alt="" />
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse offset w-100" id="navbarSupportedContent">
            <div class="row w-100 mr-0">
              <div class="col-lg-7 pr-0">
                <ul class="nav navbar-nav center_nav pull-right">
                  <li class="nav-item">
                    <a class="nav-link" href="{{url('home')}}">Home</a>
                  </li>
                  <li class="nav-item ">
                    <a class="nav-link" href="{{url('shop')}}">Shop</a>
                  </li>
                  {{-- <li class="nav-item submenu dropdown"> --}}
                    {{-- <a href="{{ url('shop_categeroy') }}" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                      aria-expanded="false">Shop Category</a> --}}
                    {{-- <ul class="dropdown-menu"> --}}
                      {{-- @foreach ($categories as $category)
                      <li>
                          <a href="{{url('products.category', ['c_id' => $category->c_id]) }}">{{ $category->c_name }}</a>
                      </li>
                      @endforeach --}}
                    
                      {{-- <li class="nav-item">
                        <a class="nav-link" href="{{url('shop_categeroy')}}">Shop Category</a>   
                      </li> --}}
                      
                      {{-- <li class="nav-item">
                        <a class="nav-link" href="checkout.html">Product Checkout</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="cart.html">Shopping Cart</a>
                      </li> --}}
                    {{-- </ul> --}}
                  {{-- </li> --}}
                  {{-- <li class="nav-item submenu dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                      aria-expanded="false">Blog</a>
                    <ul class="dropdown-menu">
                      <li class="nav-item">
                        <a class="nav-link" href="blog.html">Blog</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="single-blog.html">Blog Details</a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item submenu dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                      aria-expanded="false">Pages</a>
                    <ul class="dropdown-menu">
                      <li class="nav-item">
                        <a class="nav-link" href="tracking.html">Tracking</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="elements.html">Elements</a>
                      </li>
                    </ul>
                  </li> --}}
                  <li class="nav-item">
                    <a class="nav-link" href="{{url('contact')}}">Contact</a>
                  </li>
                </ul>
              </div>

              <div class="col-lg-5 pr-0">
                <ul class="nav navbar-nav navbar-right right_nav pull-right">
                  {{-- <li class="nav-item">
                    <a href="{{ url('search') }}">
                      <input type="text" name="query" placeholder="Search products...">
                      <i class="ti-search" aria-hidden="true"></i>
                    </a>
                  </li> --}}
                  <li class="nav-item">
                  <form action="{{ route('search') }}" method="GET"  id="search-form">
                    {{-- <input type="text" name="query" placeholder="Search products..."> --}}
                    <input type="text" name="query" id="search-query"  placeholder="Search for products...">
                    <button type="submit"><i class="ti-search" aria-hidden="true"></i></button>
                </form>
              </li>
              <div class="tip">
                  <li class="nav-item">
                    <a href="{{url('cart')}}" class="icons">
                     
                      <i class="ti-shopping-cart"></i>
                      @if ($cartCount > 0)
                      <span class="badge badge-pill badge-primary">{{ $cartCount }}</span>
                  @endif
                    </a>
                  </li>
              </div>

                  <li class="nav-item submenu dropdown">
                    <a href="#" class="icons">
                      <i class="ti-user" aria-hidden="true"></i>
                    </a>
                   <ul class="dropdown-menu">
                        <li class="nav-item">
                          <a class="nav-link" href="{{url('register')}}">Reagestion</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{url('login')}}">Login</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{url('user_profile')}}"> user_profile</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{url('order_histroy')}}">order_histroy</a>
                        </li>
                      </ul>
                  </li>
                  {{-- user_profile --}}
                  <li class="nav-item" >
                   
                    <a href="{{url('wishlists')}}" class="icons">
                      <i class="ti-heart" aria-hidden="true">
                      @if ($wishlistCount > 0)
                      <span class="badge badge-pill badge-primary">{{ $wishlistCount }}</span>
                  @endif
                </i>
                      </div>
                    </a>
                    
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </header>

  <script>
    $(document).ready(function() {
        $('#search-form').on('submit', function(e) {
            e.preventDefault();

            let query = $('#search-query').val();

            $.ajax({
                url: '{{ route("search") }}',
                method: 'GET',
                data: {
                    query: query
                },
                success: function(response) {
                    $('#search-results').html('');

                    if (response.products.data.length > 0) {
                        let productsHtml = '<div class="row">';
                        response.products.data.forEach(function(product) {
                            productsHtml += `
                                <div class="col-md-4">
                                    <div class="card mb-4">
                                        <img class="card-img-top" src="${product.image_url}" alt="${product.name}">
                                        <div class="card-body">
                                            <h5 class="card-title">${product.name}</h5>
                                            <p class="card-text">${product.description}</p>
                                            <p class="card-text">Rs ${product.price}</p>
                                            <a href="/product/${product.id}" class="btn btn-primary">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        productsHtml += '</div>';
                        productsHtml += response.pagination;

                        $('#search-results').html(productsHtml);
                    } else {
                        $('#search-results').html('<p>No products found matching your query.</p>');
                    }

                    $('#search-results').append(`
                        <div>
                            <p>Wishlist Items: ${response.wishlistCount}</p>
                            <p>Cart Items: ${response.cartCount}</p>
                        </div>
                    `);
                },
                error: function() {
                    $('#search-results').html('<p>An error occurred. Please try again.</p>');
                }
            });
        });
    });
</script>