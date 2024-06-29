<!-- search-results.blade.php -->

@include('home.header')
    <h2>Search Results for "{{ $query }}"</h2>

    @if ($products->isEmpty())
        <p>No results found.</p>
    @else
        <ul>
            @foreach ($products as $product)
                <li>name: {{ $product->name }} </li>
                <li> @foreach(explode(',',$product->images) as $image)
                    <img src="{{ asset('images/' . $image) }}" alt="{{ $image }}" style="width: 100px; height: auto;">
                @endforeach
                </li>
                <li>Category: - {{ $product->category->name }}</li>
                <li>Price: - {{ $product->price }}</li>
                <li>Description: - {!! $product->description !!}</li>
                <!-- Adjust the above based on your actual product fields -->
            @endforeach
        </ul>
        @endif
        {{ $products->links() }}
        {{-- <div class="container">
            <h1>Search Results for "{{ $query }}"</h1>
    
            @if($products->isEmpty())
                <p>No products found matching your query.</p>
            @else
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ $product->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
    
                <!-- Pagination links -->
                {{ $products->links() }}
            @endif
        </div> --}}

        
@include('home.footer')