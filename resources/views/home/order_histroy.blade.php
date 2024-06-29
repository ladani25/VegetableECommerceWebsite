
@include('home.header')
    <div class="container">
      <div class="row">
          <div class="col-lg-6">
              <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                          <img src="{{url('front-end/img/product/single-product/s-product-s-2.jpg')}}" alt="" />
                      </li>
                      <!-- Add more carousel indicators if needed -->
                  </ol>
                  <div class="carousel-inner">
                      {{-- <div class="carousel-item active">
                       
                          <img class="d-block w-100"  src="{{ url('images/' . $product->images) }}" alt="First slide">
                      </div> --}}
                      <!-- Add more carousel items if needed -->
                  </div>
                  <!-- Add carousel controls if needed -->
              </div>
          </div>
          <div class="col-lg-6">
            <div class="s_product_text">
              @foreach ($orderDetails as $orderDetail)
                <div class="card-body">
                <h5>Order Date: {{ $orderDetail->order_date }}
                  <p class="card-text"><h5>Order Id: {{ $orderDetail->order_id }}
                  <p class="card-text"><h5>Order NUMBER: {{ $orderDetail->order_num }}
                  <p class="card-text"><h5>Price: ${{ $orderDetail->totalal_amout }}
                  <p class="card-text"><h5>Payment Method: {{ $orderDetail->payment_type }}
                  <p class="card-text"><h5>Status: {{ $orderDetail->payment_status }}
                  <div>
                 <form>
                    {{-- <button class="btn btn-primary">Read More</button> --}}
                    <a href="{{ url('order-details', $orderDetail->id) }}" class="btn btn-primary">Read More</a>
                 </form>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          
                  <div class="product_count">
                   
                  </div>
              </div>
          </div>
      </div>
  </div>


  {{-- @if ($orders->isEmpty())
  <p>No orders found.</p>
@else
  <ul>
      @foreach ($orders as $order)
          <li>
              Order ID: {{ $order->id }}<br>
              Quantity: {{ $order->qty }}<br>
              Amount: {{ $order->amount }}<br>
              <!-- Add more details as per your Order model -->
          </li>
      @endforeach
  </ul>
@endif --}}
    @include('home.footer')