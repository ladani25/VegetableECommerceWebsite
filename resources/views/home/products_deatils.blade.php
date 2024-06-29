@include('home.header')

<style>
    .heart-red {
        color: red;
    }

    .product {
        display: flex;
        align-items: center;
        margin: 10px 0;
    }

    .heart {
        cursor: pointer;
        font-size: 24px;
        margin-left: 10px;
    }

    .heart.red {
        color: red;
    }

    .reviews {
        margin-top: 30px;
    }

    .review-form {
        margin-top: 20px;
    }

    .review-form input,
    .review-form textarea {
        width: 100%;
        margin-bottom: 10px;
    }

    .review-list {
        margin-top: 20px;
    }

    .review-item {
        margin-bottom: 10px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }

    .star-rating {
        font-size: 24px;
        color:#ddd;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        cursor: pointer;
    }

    .star-rating input[type="radio"]:checked~label,
    .star-rating input[type="radio"]:hover~label {
        color: #ffb400;
    }
</style>

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
                    <div class="carousel-item active">
                        {{-- <img class="d-block w-100" src="{{url('front-end/img/product/single-product/s-product-1.jpg')}}" alt="First slide"> --}}
                        <img class="d-block w-100" src="{{ url('images/' . $product->images) }}"
                            alt="First slide">
                    </div>
                    <!-- Add more carousel items if needed -->
                </div>
                <!-- Add carousel controls if needed -->
            </div>
        </div>
        <div class="col-lg-6">
            <div class="s_product_text">

                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">Price: ${{ $product->price }}</p>
                    <p class="card-text">Description: {!! $product->description !!}</p>
                    <!-- Add more details as needed -->
                </div>

                <div class="card_area">

                    <form action="{{ url('addcart') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->p_id }}">
                        <button type="submit" class="main_btn"><i class="ti-shopping-cart"></i></button>
                    </form>
                    <a class="icon_btn" href="#">
                        <i class="lnr lnr-diamond"></i>
                    </a>
                    {{-- <a class="icon_btn" href="#">
                          <i class="lnr lnr-heart"></i>
                      </a> --}}
                    <form action="{{ url('add') }}" method="POST" class="add-to-wishlist-form"
                        data-product-id="{{ $product->p_id }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->p_id }}">
                        <button type="submit">
                            <i class="ti-heart heart-icon {{ in_array($product->p_id, $wishlist) ? 'heart-red' : '' }}"></i>
                        </button>
                    </form>

                    <div class="reviews">
                        <h3>Customer Reviews</h3>
                        <div class="review-list">
                            @if ($reviews && count($reviews) > 0)
                                @foreach ($reviews as $review)
                                    <div class="review-item">
                                        <div class="star-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="fa fa-star{{ $i <= $review->rating ? '' : '-o' }}"></span>
                                            @endfor
                                        </div>
                                        <p>{{ $review->comment }}</p>
                                        <small>by {{ $review->user->name }}
                                            on {{ $review->created_at->format('d M Y') }}</small>
                                    </div>
                                @endforeach
                            @else
                                <p>No reviews yet.</p>
                            @endif
                        </div>

                        <div class="review-form">
                            <h4>Add a Review</h4>
                            <form action="{{ url('addreview') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->p_id }}">
                                <div class="star-rating">
                                    <input type="radio" name="rating" value="5" id="5-stars">
                                    <label for="5-stars" class="fa fa-star"></label>
                                    <input type="radio" name="rating" value="4" id="4-stars">
                                    <label for="4-stars" class="fa fa-star"></label>
                                    <input type="radio" name="rating" value="3" id="3-stars">
                                    <label for="3-stars" class="fa fa-star"></label>
                                    <input type="radio" name="rating" value="2" id="2-stars">
                                    <label for="2-stars" class="fa fa-star"></label>
                                    <input type="radio" name="rating" value="1" id="1-star">
                                    <label for="1-star" class="fa fa-star"></label>
                                </div>
                                
                                <textarea name="comment" placeholder="Write your review here..."
                                    required></textarea>
                                <button type="submit" class="main_btn">Submit Review</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var addToWishlistForms = document.querySelectorAll('.add-to-wishlist-form');

        addToWishlistForms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent form submission

                var heartIcon = this.querySelector('.heart-icon');
                var productId = this.getAttribute('data-product-id');

                if (!heartIcon.classList.contains('heart-red')) {
                    heartIcon.classList.add('heart-red'); // Add the red color class
                } else {
                    heartIcon.classList.remove('heart-red'); // Remove the red color class
                }

                // Submit the form
                var formData = new FormData(this);
                fetch(this.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        }
                        throw new Error('Network response was not ok.');
                    })
                    .then(data => {
                        // Handle success response
                        console.log(data);

                        // Update the wishlist in the session
                        fetch('/update-wishlist', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    productId: productId,
                                    action: heartIcon.classList.contains('heart-red') ? 'add' : 'remove'
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Failed to update wishlist.');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log(data);
                            })
                            .catch(error => {
                                console.error('Error occurred while updating wishlist:', error);
                            });

                    })
                    .catch(error => {
                        console.error('Error occurred:', error);
                    });
            });
        });

        // Star rating functionality
        const stars = document.querySelectorAll('.star-rating .fa');
        const ratingInput = document.querySelector('input[name="rating"]');

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                // Set the rating value to the clicked star's index + 1
                ratingInput.value = index + 1;

                // Highlight all the stars up to the clicked star
                highlightStars(index + 1);
            });

            star.addEventListener('mouseover', () => {
                // Highlight all the stars up to the hovered star
                highlightStars(index + 1);
            });

            star.addEventListener('mouseout', () => {
                // Highlight stars based on the current rating value
                highlightStars(ratingInput.value);
            });
        });

        function highlightStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('checked');
                } else {
                    star.classList.remove('checked');
                }
            });
        }

        //
        highlightStars(ratingInput.value);
    });

</script>



@include('home.footer')
