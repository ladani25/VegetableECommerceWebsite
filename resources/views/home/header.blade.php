
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
                  <li class="nav-item submenu dropdown">
                    <a href="{{url('shop')}}" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                      aria-expanded="false">Shop Category</a>
                    <ul class="dropdown-menu">
                      {{-- @foreach ($categories as $category)
                      <li>
                          <a href="#">{{ $category->c_name }}</a>
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
                    </ul>
                  </li>
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
                  <li class="nav-item">
                    {{-- <a href="{{ url('search') }}">
                      <input type="text" name="query" placeholder="Search products...">
                      <i class="ti-search" aria-hidden="true"></i>
                    </a> --}}
                  </li>
                  <li class="nav-item">
                  <form action="{{ route('search') }}" method="GET">
                    <input type="text" name="query" placeholder="Search products...">
                    <button type="submit"><i class="ti-search" aria-hidden="true"></i></button>
                </form>
              </li>
                  <li class="nav-item">
                    <a href="{{url('cart')}}" class="icons">
                      <i class="ti-shopping-cart"></i>
                    </a>
                  </li>

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
                          <a class="nav-link" href="{{url('order_histroy')}}">order_histroy</a>
                        </li>
                      </ul>
                  </li>

                  <li class="nav-item">
                    {{-- <form action="{{url('add-whitelist')}}" method="post">
                      @csrf --}}
                    <a href="{{url('wishlists')}}" class="icons">
                      <i class="ti-heart" aria-hidden="true"></i>
                    </a>
                    {{-- </form> --}}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </div>
  </header>