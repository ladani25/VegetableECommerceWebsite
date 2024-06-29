{{-- @include('home.header')

<div class="row">
    @if($wishlists->count() > 0)
        @foreach($wishlists as $wishlist)
         
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

@include('home.footer') --}}


@include('home.header')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<section class="wishlist_area section_gap">
    <div style="padding-left:73%">
        <form action="{{ url('removeall-wishlist') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger mt-2">Remove All</button>
        </form>
    </div>
    <div class="container">
        @if($wishlists->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            {{-- <th scope="col">Description</th> --}}
                            <th scope="col">Price</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wishlists as $wishlist)
                            <tr>
                                @if($wishlist->p_id)
                                    <td>{{ $wishlist->name }}</td>
                                    {{-- <td>{{ $wishlist->description }}</td> --}}
                                    <td>${{ $wishlist->price }}</td>
                                    <td><img src="{{ url('images/' . $wishlist->images) }}" alt="{{ $wishlist->name }}" style="height: 100px; width: 100px;"></td>
                                    <td>
                                        <form action="{{url('remove', $wishlist->w_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Remove</button>
                                        </form>
                                    </td>
                                @else
                                    <td colspan="5">Product not found</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="col-md-12">
                <h1>No products in your wishlist</h1>
            </div>
        @endif
    </div>
</section>

@include('home.footer')




