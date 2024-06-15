<!-- search-results.blade.php -->

@include('home.header')
    <h2>Search Results for "{{ $query }}"</h2>

    @if ($products->isEmpty())
        <p>No results found.</p>
    @else
        <ul>
            @foreach ($products as $product)
                <li>name- {{ $product->name }} </li>
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
@include('home.footer')