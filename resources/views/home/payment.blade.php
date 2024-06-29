{{-- @include('home.header') --}}

<div style="text-align: center; padding-top:10%">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <h1>Order ID: {{ $order_id }}</h1>
    <p>{{ $message }}</p>
</div>



{{-- 
@include('home.footer') --}}
