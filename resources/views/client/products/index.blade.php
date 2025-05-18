@extends('layouts.app')

@section('title', 'Products - Cleaning Services')

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="page-header-bg" style="background-image: url({{ asset('assets/images/safaraz/product2.png') }}); background-size: cover; background-position: center;">
    <!-- Konten di dalam header, misalnya judul halaman, teks, dll -->
</div>

    </div>
    <div class="container">
        <div class="page-header__inner">
            <ul class="thm-breadcrumb list-unstyled">
                <li><a href="{{ route('client.dashboard') }}">Home</a></li>
                <li><span>/</span></li>
                <li>Products</li>
            </ul>
            <h2>Our Cleaning Products</h2>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="products-page">
    <div class="container">
        <div class="row">
            <!-- Sidebar with Filters -->
            <div class="col-xl-3 col-lg-3">
                <div class="shop-sidebar">
                    <div class="shop-search">
                        <form action="{{ route('products.index') }}" method="GET">
                            <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
                            <button type="submit"><i class="icon-magnifying-glass"></i></button>
                        </form>
                    </div>
                    
                    <div class="shop-category">
                        <h3 class="shop-sidebar__title">Categories</h3>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('products.index') }}" class="{{ !request('category') ? 'active' : '' }}">All Products</a></li>
                            @foreach($categories ?? [] as $category)
                                <li><a href="{{ route('products.index', ['category' => $category->id]) }}" class="{{ request('category') == $category->id ? 'active' : '' }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="shop-price-filter">
                        <h3 class="shop-sidebar__title">Filter by Price</h3>
                        <div class="price-range-slider">
                            <form action="{{ route('products.index') }}" method="GET">
                                <div class="range-slider">
                                    <div class="input-box">
                                        <div class="field">
                                            <input type="range" min="0" max="1000000" value="{{ request('min_price', 0) }}" step="10000" name="min_price">
                                            <span>Rp {{ number_format(request('min_price', 0)) }}</span>
                                        </div>
                                        <div class="field">
                                            <input type="range" min="0" max="1000000" value="{{ request('max_price', 1000000) }}" step="10000" name="max_price">
                                            <span>Rp {{ number_format(request('max_price', 1000000)) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="thm-btn shop-sidebar__btn">Filter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="col-xl-9 col-lg-9">
                <div class="products-top-bar">
                    <div class="products-top-bar__left">
                        <p>Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() ?? 0 }} results</p>
                    </div>
                    <div class="products-top-bar__right">
                        <select name="sort" class="selectpicker" onchange="window.location.href=this.options[this.selectedIndex].value">
                            <option value="{{ route('products.index', ['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="{{ route('products.index', ['sort' => 'price_low']) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="{{ route('products.index', ['sort' => 'price_high']) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    @if(isset($products) && count($products) > 0)
                        @foreach($products as $product)
                            <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                                <div class="product-card">
                                    <div class="product-card__img">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('assets/images/shop/shop-product-1-1.jpg') }}" alt="Default Product Image">
                                        @endif
                                        <div class="product-card__buttons">
                                            <a href="{{ route('products.show', $product->id) }}" class="thm-btn product-card__quick-view-btn">Quick View</a>
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="thm-btn product-card__add-to-cart-btn">Add to Cart</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="product-card__content">
                                        <div class="product-card__category">{{ $product->category->name ?? 'Uncategorized' }}</div>
                                        <h3 class="product-card__title"><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h3>
                                        <p class="product-card__price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <div class="product-card__stars">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half"></i>
                                            <span>(4.7)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="no-products-found text-center py-5">
                                <div class="no-products-found__icon">
                                    <i class="fa fa-search fa-3x"></i>
                                </div>
                                <h3 class="mt-3">No products found</h3>
                                <p>Try adjusting your search or filter to find what you're looking for.</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Pagination -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="products-page__pagination">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="featured-products">
    <div class="container">
        <div class="section-title text-center">
            <span class="section-title__tagline">Popular Items</span>
            <h2 class="section-title__title">Featured Products</h2>
        </div>
        
        <div class="row">
            @foreach($products as $product)
    <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
        <div class="product-card">
            <div class="product-card__img">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('assets/images/shop/shop-product-1-1.jpg') }}" alt="Default Product Image">
                @endif
                <div class="product-card__buttons">
                    <button type="button" class="thm-btn product-card__quick-view-btn show-product-modal" 
                        data-bs-toggle="modal" 
                        data-bs-target="#productDetailModal" 
                        data-product-id="{{ $product->id }}">
                        Quick View
                    </button>
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="thm-btn product-card__add-to-cart-btn">Add to Cart</button>
                    </form>
                </div>
            </div>
            <div class="product-card__content">
                <div class="product-card__category">{{ $product->category->name ?? 'Uncategorized' }}</div>
                <h3 class="product-card__title">
                    <a href="javascript:void(0);" class="show-product-modal" 
                       data-bs-toggle="modal" 
                       data-bs-target="#productDetailModal" 
                       data-product-id="{{ $product->id }}">
                        {{ $product->name }}
                    </a>
                </h3>
                <p class="product-card__price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
@endforeach
@include('layouts.show')
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-one">
    <div class="container">
        <div class="cta-one__inner">
            <div class="cta-one-shape-1"></div>
            <div class="cta-one-shape-2"></div>
            <div class="cta-one-shape-3"></div>
            <div class="cta-one-shape-4"></div>
            <div class="cta-one-shape-5"></div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="cta-one__content">
                        <h2 class="cta-one__title">Need help choosing the right products?</h2>
                        <div class="cta-one__btn-box">
                            <a href="{{ route('contact') }}" class="thm-btn cta-one__btn">Contact Our Team <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .product-card {
        position: relative;
        margin-bottom: 30px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .product-card__img {
        position: relative;
        overflow: hidden;
        height: 250px;
    }
    
    .product-card__img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .product-card__img img {
        transform: scale(1.05);
    }
    
    .product-card__buttons {
        position: absolute;
        bottom: -60px;
        left: 0;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: bottom 0.3s ease;
        padding: 10px;
        background: rgba(255, 255, 255, 0.9);
    }
    
    .product-card:hover .product-card__buttons {
        bottom: 0;
    }
    
    .product-card__quick-view-btn,
    .product-card__add-to-cart-btn {
        width: 100%;
        text-align: center;
        margin: 5px 0;
        padding: 8px 15px;
        font-size: 14px;
    }
    
    .product-card__content {
        padding: 20px;
    }
    
    .product-card__category {
        font-size: 14px;
        color: #777;
        margin-bottom: 5px;
    }
    
    .product-card__title {
        font-size: 18px;
        margin-bottom: 10px;
        font-weight: 600;
    }
    
    .product-card__title a {
        color: #222;
        transition: color 0.3s ease;
    }
    
    .product-card__title a:hover {
        color: #28dbd1;
    }
    
    .product-card__price {
        font-size: 18px;
        font-weight: 700;
        color: #28dbd1;
        margin-bottom: 10px;
    }
    
    .product-card__stars {
        color: #ffc107;
        font-size: 14px;
    }
    
    .product-card__stars span {
        color: #777;
        margin-left: 5px;
    }
    
    .shop-sidebar {
        background-color: #f8f9fa;
        padding: 30px;
        border-radius: 8px;
        margin-bottom: 30px;
    }
    
    .shop-sidebar__title {
        font-size: 20px;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .shop-sidebar__title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: #28dbd1;
    }
    
    .shop-search {
        position: relative;
        margin-bottom: 30px;
    }
    
    .shop-search input {
        width: 100%;
        height: 50px;
        border: 1px solid #e9e9e9;
        background-color: #fff;
        padding: 0 50px 0 20px;
        border-radius: 5px;
    }
    
    .shop-search button {
        position: absolute;
        top: 0;
        right: 0;
        height: 50px;
        width: 50px;
        background-color: transparent;
        border: none;
        color: #777;
        font-size: 16px;
    }
    
    .shop-category {
        margin-bottom: 30px;
    }
    
    .shop-category ul li {
        margin-bottom: 10px;
    }
    
    .shop-category ul li a {
        color: #777;
        transition: color 0.3s ease;
        display: flex;
        justify-content: space-between;
    }
    
    .shop-category ul li a:hover,
    .shop-category ul li a.active {
        color: #28dbd1;
    }
    
    .products-top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding: 15px 20px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }
    
    .products-top-bar__left p {
        margin-bottom: 0;
        color: #777;
    }
    
    .no-products-found {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 50px 20px;
    }
    
    .no-products-found__icon {
        color: #ddd;
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Activate the Products menu item
        $('.main-menu__list li').removeClass('current');
        $('.main-menu__list li:nth-child(4)').addClass('current');
        
        // Price range slider functionality
        const minPriceInput = $('input[name="min_price"]');
        const maxPriceInput = $('input[name="max_price"]');
        
        minPriceInput.on('input', function() {
            $(this).next('span').text('Rp ' + parseInt(this.value).toLocaleString('id-ID'));
        });
        
        maxPriceInput.on('input', function() {
            $(this).next('span').text('Rp ' + parseInt(this.value).toLocaleString('id-ID'));
        });
    });
</script>
@endsection
