@include('home.header')

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1>Order ID: {{ $order_id }}</h1>
    <p>{{ $message }}</p>
</div>

{{-- <div style="margin-bottom: 50%"> --}}
@include('home.footer')

{{-- </div> --}}