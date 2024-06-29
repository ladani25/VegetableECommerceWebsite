{{-- <h1>{{ $category->c_name }}</h1> --}}
{{-- <ul>
    @foreach ($products as $product)
        <li>
            <a>{{ $product->name }}</a>
            <h1>{{  $products->price }}</h1>
        </li>
    @endforeach
</ul> --}}

{{-- <pre>{{ var_dump($products) }}</pre> --}}
{{-- 
<ul>
    @if ($products && $products->count() > 0)
        @foreach ($products as $product)
            <li>
                <a>{{ $product->name }}</a>
                <a href="{{url('products.show', ['p_id' => $product->p_id]) }}">{{ $product->name }}</a>
                <pre>{{ var_dump($product) }}</pre>
                <h1>{{  $products->price }}</h1>
            </li>
        @endforeach
    @else
        <li>No products available</li>
    @endif
</ul> --}}

@include('home.header')

<div class="container">
    @if ($products && $products->count() > 0)
        @foreach ($products as $product)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <a href="{{url('products.show', ['p_id' => $product->p_id]) }}" class="btn btn-primary">View Product</a>
                </div>
            </div>
        @endforeach
    @else   
        <p>No products available</p>
    @endif
</div>

@include('home.footer')