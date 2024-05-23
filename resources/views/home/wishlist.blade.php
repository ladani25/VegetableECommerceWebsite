@include('home.header')

<div class="row">
    @if($wishlists->count() > 0)
        @foreach($wishlists as $wishlist)
            {{-- Debugging: Check each wishlist item --}}
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        @if($wishlist->p_id)
                            <h5 class="card-title">{{ $wishlist->name }}</h5>
                            <p class="card-text">{{ !!$wishlist->description }}</p>
                            <p class="card-text">Price: ${{ $wishlist->price }}</p>
                    </div>
                    <img  class="card-img" style='height:200px; width:300px;' src="{{ url('images/' . $wishlist->images) }}" alt="{{ $wishlist->name }}"  >
                
                            <form action="{{url('remove', $wishlist->w_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger mt-2">Remove</button>
                            </form>
                        @else
                            <h5 class="card-title">Product not found</h5>
                        @endif
                    </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-md-12">
            <h1>No products in your wishlist</h1>
        </div>
    @endif
</div>

@include('home.footer')
