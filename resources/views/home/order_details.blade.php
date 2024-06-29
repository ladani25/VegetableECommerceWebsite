@include('home.header')


<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h3>Order Details</h3>
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Order Date: {{ $order->order_date }}</h5>
                    <p>Order ID: {{ $order->order_id }}</p>
                    <p>Price: ${{ $order->total_amount }}</p>
                    <p>Payment Method: {{ $order->payment_type }}</p>s
                    <p>Status: {{ $order->payment_status }}</p>
                </div>
            </div>
            <div class="row">
                @foreach ($orderProducts as $orderProduct)
                    <div class="col-lg-4">
                        <div class="card mb-3">
                            {{-- <img class="card-img-top" src="{{ url('images/' . $orderProduct->product->images) }}" alt="{{ $orderProduct->product->name }}"> --}}
                            <div class="card-body">
                                <h5 class="card-title">{{ $orderProduct->product->name }}</h5>
                                <p class="card-text">Quantity: {{ $orderProduct->u_quantity }}</p>
                                <p class="card-text">Price: ${{ $orderProduct->product->price }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


@include('home.footer')
