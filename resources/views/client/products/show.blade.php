@extends('layouts.app')

@section('title', $product->name . ' - Cleaning Services')

@section('content')
<section class="page-header">
    <div class="page-header-bg" style="background-image: url({{ asset('assets/images/backgrounds/page-header-bg.jpg') }})">
    </div>
    <div class="container">
        <div class="page-header__inner">
            <ul class="thm-breadcrumb list-unstyled">
                <li><a href="{{ route('client.dashboard') }}">Home</a></li>
                <li><span>/</span></li>
                <li><a href="{{ route('products.index') }}">Products</a></li>
                <li><span>/</span></li>
                <li>{{ $product->name }}</li>
            </ul>
            <h2>Product Details</h2>
        </div>
    </div>
</section>

<section class="product-details">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="product-details__img">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                    @else
                        <img src="{{ asset('assets/images/shop/shop-details-img-1.jpg') }}" alt="Default Product Image" class="img-fluid">
                    @endif
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="product-details__content">
                    <h3 class="product-details__title">{{ $product->name }}</h3>
                    <div class="product-details__review">
                        <div class="product-details__stars">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half"></i>
                            <span>(4.7)</span>
                        </div>
                        <p class="product-details__review-count">10 Customer Reviews</p>
                    </div>
                    <div class="product-details__price">
                        <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="product-details__text">
                        <p>{{ \Illuminate\Support\Str::limit($product->description, 200) }}</p>
                    </div>
                    <div class="product-details__category">
                        <p><span>Category:</span> {{ $product->category->name ?? 'Uncategorized' }}</p>
                    </div>

                    {{-- --- BARU: TAMPILAN STOK DI DETAIL PRODUK --- --}}
                    <div class="product-details__stock mb-4">
                        <p>
                            <strong>Stok:</strong> **{{ $product->stock }}**
                            @if ($product->stock <= 5 && $product->stock > 0)
                                <span class="text-warning fw-bold">(Stok Terbatas!)</span>
                            @elseif ($product->stock === 0)
                                <span class="text-danger fw-bold">(Stok Habis!)</span>
                            @endif
                        </p>
                    </div>
                    {{-- --- AKHIR TAMPILAN STOK --- --}}
                    
                    <form action="{{ route('cart.add') }}" method="POST" class="product-details__form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="product-details__quantity">
                            <h3 class="product-details__quantity-title">Quantity</h3>
                            <div class="quantity-box">
                                <button type="button" class="sub">-</button>
                                {{-- BARU: Tambahkan atribut max="{{ $product->stock }}" pada input kuantitas --}}
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                                <button type="button" class="add">+</button>
                            </div>
                        </div>
                        <div class="product-details__buttons">
                            {{-- BARU: Logika tombol Add to Cart berdasarkan stok --}}
                            @if ($product->stock > 0)
                                <button type="submit" class="thm-btn product-details__add-to-cart">Add to Cart</button>
                            @else
                                <button type="button" class="thm-btn product-details__add-to-cart disabled" disabled>Stok Habis</button>
                            @endif
                            <a href="#" class="product-details__wishlist"><i class="far fa-heart"></i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <div class="product-details__tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews (10)</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="product-details__description-content">
                                <p>{{ $product->description }}</p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="product-details__reviews-content">
                                <div class="product-details__review-item">
                                    <div class="product-details__review-img">
                                        <img src="{{ asset('assets/images/testimonial/testimonial-1-1.jpg') }}" alt="">
                                    </div>
                                    <div class="product-details__review-content">
                                        <div class="product-details__review-top">
                                            <h3 class="product-details__review-name">Kevin Martin</h3>
                                            <div class="product-details__review-stars">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <p class="product-details__review-text">Great product! Works exactly as described and the quality is excellent.</p>
                                    </div>
                                </div>
                                
                                <div class="product-details__review-form">
                                    <h3 class="product-details__review-form-title">Add a Review</h3>
                                    <form action="#" method="post">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="product-details__review-form-input">
                                                    <input type="text" placeholder="Your Name" name="name" required>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="product-details__review-form-input">
                                                    <input type="email" placeholder="Your Email" name="email" required>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="product-details__review-form-rating">
                                                    <p>Your Rating</p>
                                                    <div class="rating-stars">
                                                        <i class="far fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="product-details__review-form-input">
                                                    <textarea name="review" placeholder="Write Your Review" required></textarea>
                                                </div>
                                                <button type="submit" class="thm-btn product-details__review-form-btn">Submit Review</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="related-products">
    <div class="container">
        <div class="section-title text-center">
            <span class="section-title__tagline">Similar Products</span>
            <h2 class="section-title__title">Related Products</h2>
        </div>
        
        <div class="row">
            @foreach($relatedProducts ?? [] as $relatedProduct)
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="product-card">
                        <div class="product-card__img">
                            @if($relatedProduct->image)
                                <img src="{{ asset('storage/' . $relatedProduct->image) }}" alt="{{ $relatedProduct->name }}">
                            @else
                                <img src="{{ asset('assets/images/shop/shop-product-1-1.jpg') }}" alt="Default Product Image">
                            @endif
                            <div class="product-card__buttons">
                                <a href="{{ route('products.show', $relatedProduct->id) }}" class="thm-btn product-card__quick-view-btn">Quick View</a>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $relatedProduct->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    {{-- BARU: Logika tombol Add to Cart untuk related products --}}
                                    @if ($relatedProduct->stock > 0)
                                        <button type="submit" class="thm-btn product-card__add-to-cart-btn">Add to Cart</button>
                                    @else
                                        <button type="button" class="thm-btn product-card__add-to-cart-btn disabled" disabled>Stok Habis</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                        <div class="product-card__content">
                            <div class="product-card__category">{{ $relatedProduct->category->name ?? 'Uncategorized' }}</div>
                            <h3 class="product-card__title"><a href="{{ route('products.show', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a></h3>
                            <p class="product-card__price">Rp {{ number_format($relatedProduct->price, 0, ',', '.') }}</p>
                            {{-- BARU: Tampilan stok untuk related products --}}
                            <p class="product-card__stock">
                                Stok: <strong>{{ $relatedProduct->stock }}</strong>
                                @if ($relatedProduct->stock <= 5 && $relatedProduct->stock > 0)
                                    <span class="text-warning fw-bold">(Terbatas!)</span>
                                @elseif ($relatedProduct->stock === 0)
                                    <span class="text-danger fw-bold">(Habis)</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .product-details {
        padding: 80px 0;
    }
    
    .product-details__img {
        position: relative;
        margin-bottom: 30px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }
    
    .product-details__content {
        padding-left: 20px;
    }
    
    .product-details__title {
        font-size: 30px;
        font-weight: 700;
        margin-bottom: 15px;
    }
    
    .product-details__review {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .product-details__stars {
        color: #ffc107;
        margin-right: 15px;
    }
    
    .product-details__review-count {
        margin: 0;
        color: #777;
    }
    
    .product-details__price {
        margin-bottom: 20px;
    }
    
    .product-details__price p {
        font-size: 24px;
        font-weight: 700;
        color: #28dbd1;
        margin: 0;
    }
    
    .product-details__text {
        margin-bottom: 20px;
    }
    
    .product-details__category {
        margin-bottom: 30px;
    }
    
    .product-details__category p span {
        font-weight: 600;
        margin-right: 5px;
    }
    
    .product-details__quantity {
        margin-bottom: 30px;
    }
    
    .product-details__quantity-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .quantity-box {
        display: flex;
        align-items: center;
        max-width: 150px;
        border: 1px solid #e9e9e9;
        border-radius: 5px;
        overflow: hidden;
    }
    
    .quantity-box button {
        width: 40px;
        height: 40px;
        background-color: #f8f9fa;
        border: none;
        font-size: 18px;
    }
    
    .quantity-box input {
        width: 70px;
        height: 40px;
        border: none;
        text-align: center;
        font-weight: 600;
    }
    
    .product-details__buttons {
        display: flex;
        align-items: center;
    }
    
    .product-details__add-to-cart {
        padding: 12px 30px;
        margin-right: 15px;
    }
    
    .product-details__wishlist {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border-radius: 50%;
        color: #777;
        transition: all 0.3s ease;
    }
    
    .product-details__wishlist:hover {
        background-color: #28dbd1;
        color: #fff;
    }
    
    .product-details__tabs {
        margin-top: 60px;
    }
    
    .product-details__tabs .nav-tabs {
        border-bottom: 1px solid #e9e9e9;
        margin-bottom: 30px;
    }
    
    .product-details__tabs .nav-link {
        border: none;
        font-size: 18px;
        font-weight: 600;
        color: #777;
        padding: 15px 30px;
    }
    
    .product-details__tabs .nav-link.active {
        color: #28dbd1;
        border-bottom: 2px solid #28dbd1;
    }
    
    .product-details__review-item {
        display: flex;
        margin-bottom: 30px;
        padding-bottom: 30px;
        border-bottom: 1px solid #e9e9e9;
    }
    
    .product-details__review-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 20px;
    }
    
    .product-details__review-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .product-details__review-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .product-details__review-name {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }
    
    .product-details__review-stars {
        color: #ffc107;
    }
    
    .product-details__review-form {
        margin-top: 50px;
    }
    
    .product-details__review-form-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 30px;
    }
    
    .product-details__review-form-input {
        margin-bottom: 20px;
    }
    
    .product-details__review-form-input input,
    .product-details__review-form-input textarea {
        width: 100%;
        padding: 15px 20px;
        border: 1px solid #e9e9e9;
        border-radius: 5px;
    }
    
    .product-details__review-form-input textarea {
        height: 150px;
        resize: none;
    }
    
    .product-details__review-form-rating {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
    }
    
    .product-details__review-form-rating p {
        margin: 0 15px 0 0;
        font-weight: 600;
    }
    
    .rating-stars {
        color: #ffc107;
        font-size: 18px;
        cursor: pointer;
    }
    
    .product-details__review-form-btn {
        padding: 12px 30px;
    }
    
    .related-products {
        padding: 80px 0;
        background-color: #f8f9fa;
    }

    /* --- BARU: CSS UNTUK TAMPILAN STOK --- */
    .product-details__stock {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px; /* Sesuaikan jarak */
    }
    .product-details__stock .text-warning {
        color: #ffc107; /* Warna kuning untuk terbatas */
    }
    .product-details__stock .text-danger {
        color: #dc3545; /* Warna merah untuk habis */
    }

    /* Styling untuk tombol Add to Cart yang disabled */
    .product-details__add-to-cart.disabled {
        opacity: 0.6;
        cursor: not-allowed;
        background-color: #6c757d; /* Warna abu-abu */
        border-color: #6c757d;
    }
    .product-details__add-to-cart.disabled:hover {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    /* Styling tambahan untuk product-card__stock di related products (jika belum ada) */
    .product-card__stock {
        font-size: 15px;
        margin-top: 5px; /* Sesuaikan jaraknya */
        color: #555;
    }
    .product-card__stock .text-warning {
        color: #ffc107;
    }
    .product-card__stock .text-danger {
        color: #dc3545;
    }
    .product-card__add-to-cart-btn.disabled {
        opacity: 0.6;
        cursor: not-allowed;
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .product-card__add-to-cart-btn.disabled:hover {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    /* --- AKHIR BARU: CSS UNTUK TAMPILAN STOK --- */
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Quantity buttons functionality
        $('.quantity-box .add').on('click', function() {
            var $qtyInput = $(this).closest('.quantity-box').find('input[name="quantity"]'); // Select by name for safety
            var currentVal = parseInt($qtyInput.val());
            var maxStock = parseInt($qtyInput.attr('max')); // Get max value from attribute

            if (!isNaN(currentVal) && currentVal < maxStock) { // Ensure not to exceed max stock
                $qtyInput.val(currentVal + 1);
            }
        });
        
        $('.quantity-box .sub').on('click', function() {
            var $qtyInput = $(this).closest('.quantity-box').find('input[name="quantity"]'); // Select by name for safety
            var currentVal = parseInt($qtyInput.val());
            var minVal = parseInt($qtyInput.attr('min')); // Get min value from attribute

            if (!isNaN(currentVal) && currentVal > minVal) { // Ensure not to go below min (usually 1)
                $qtyInput.val(currentVal - 1);
            }
        });

        // Ensure input quantity does not exceed stock or go below minimum
        $('#quantity').on('change', function() {
            var currentVal = parseInt($(this).val());
            var maxStock = parseInt($(this).attr('max'));
            var minVal = parseInt($(this).attr('min'));

            if (isNaN(currentVal) || currentVal < minVal) {
                $(this).val(minVal);
            } else if (currentVal > maxStock) {
                $(this).val(maxStock);
            }
        });
        
        // Rating stars functionality
        $('.rating-stars i').on('click', function() {
            var index = $(this).index();
            $('.rating-stars i').removeClass('fas').addClass('far');
            for (var i = 0; i <= index; i++) {
                $('.rating-stars i:eq(' + i + ')').removeClass('far').addClass('fas');
            }
        });
    });
</script>
@endsection