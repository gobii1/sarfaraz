@extends('layouts.app')

@section('title', 'Home - Cleaning Services')

@section('content')
    <!-- Main Slider -->
    <section class="main-slider clearfix">
        <div class="swiper-container thm-swiper__slider" data-swiper-options='{"slidesPerView": 1, "loop": true,
            "effect": "fade",
            "pagination": {
            "el": "#main-slider-pagination",
            "type": "bullets",
            "clickable": true
            },
            "navigation": {
            "nextEl": "#main-slider__swiper-button-next",
            "prevEl": "#main-slider__swiper-button-prev"
            },
            "autoplay": {
            "delay": 5000
            }}'>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <div class="image-layer" style="background-image: url({{ asset('assets/images/safaraz/cleaning3.jpg') }}); background-size: cover; background-position: center;"></div>

                    <div class="main-slider-bubble">
                        <div class="main-slider-bubble-bg" style="background-image: url({{ asset('assets/images/shapes/main-slider-bubble-bg.png') }});"></div>
                    </div>
                    <div class="main-slider-star-1 zoominout">
                        <img src="{{ asset('assets/images/shapes/main-slider-star-1.png') }}" alt="">
                    </div>
                    <div class="main-slider-star-2 zoominout-2">
                        <img src="{{ asset('assets/images/shapes/main-slider-star-2.png') }}" alt="">
                    </div>
                    <div class="main-slider-star-3 zoominout">
                        <img src="{{ asset('assets/images/shapes/main-slider-star-3.png') }}" alt="">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-slider__content">
                                    <p class="main-slider__sub-title">Welcome to Our Cleaning Services</p>
                                    <h2 class="main-slider__title">Quality <br> Solutions <br> in Cleaning</h2>
                                    <div class="main-slider__btn-box">
                                        <a href="{{ url('/about') }}" class="thm-btn main-slider__btn">Discover more <i class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="image-layer" style="background-image: url({{ asset('assets/images/safaraz/cleaning4.jpg') }}); background-size: cover; background-position: center;"></div>
                    <div class="main-slider-bubble">
                        <div class="main-slider-bubble-bg" style="background-image: url({{ asset('assets/images/shapes/main-slider-bubble-bg.png') }});"></div>
                    </div>
                    <div class="main-slider-star-1 zoominout">
                        <img src="{{ asset('assets/images/shapes/main-slider-star-1.png') }}" alt="">
                    </div>
                    <div class="main-slider-star-2 zoominout-2">
                        <img src="{{ asset('assets/images/shapes/main-slider-star-2.png') }}" alt="">
                    </div>
                    <div class="main-slider-star-3 zoominout">
                        <img src="{{ asset('assets/images/shapes/main-slider-star-3.png') }}" alt="">
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-slider__content">
                                    <p class="main-slider__sub-title">Professional & Reliable</p>
                                    <h2 class="main-slider__title">Expert <br> Cleaning <br> Services</h2>
                                    <div class="main-slider__btn-box">
                                        <a href="{{ url('/services') }}" class="thm-btn main-slider__btn">Our Services <i class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Navigation buttons -->
            <div class="main-slider__nav">
                <div class="swiper-button-prev" id="main-slider__swiper-button-next">
                    <i class="fa fa-angle-left"></i>
                </div>
                <div class="swiper-button-next" id="main-slider__swiper-button-prev">
                    <i class="fa fa-angle-right"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Feature Section -->
    <section class="feature-one">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="100ms">
                    <div class="feature-one__single">
                        <div class="feature-one-single-bg" style="background-image: url({{ asset('assets/images/backgrounds/feature-one-single-bg.jpg') }});">
                        </div>
                        <div class="feature-one__icon">
                            <img src="{{ asset('assets/images/icon/feature-one-icon-1.png') }}" alt="">
                            <div class="feature-one__icon-shape">
                                <img src="{{ asset('assets/images/shapes/feature-one-icon-shape.png') }}" alt="">
                            </div>
                        </div>
                        <div class="feature-one__title-box">
                            <div class="feature-one__title-border"></div>
                            <h3 class="feature-one__title"><a href="{{ url('/services') }}">Outdoor Service</a></h3>
                        </div>
                        <p class="feature-one__text">Professional outdoor cleaning services for your home and garden.</p>
                        <div class="feature-one__btn-box">
                            <a href="{{ url('/services') }}" class="feature-one__btn">View more</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="200ms">
                    <div class="feature-one__single">
                        <div class="feature-one-single-bg" style="background-image: url({{ asset('assets/images/backgrounds/feature-one-single-bg.jpg') }});">
                        </div>
                        <div class="feature-one__icon">
                            <img src="{{ asset('assets/images/icon/feature-one-icon-2.png') }}" alt="">
                            <div class="feature-one__icon-shape">
                                <img src="{{ asset('assets/images/shapes/feature-one-icon-shape.png') }}" alt="">
                            </div>
                        </div>
                        <div class="feature-one__title-box">
                            <div class="feature-one__title-border"></div>
                            <h3 class="feature-one__title"><a href="{{ url('/services') }}">House Cleaning</a></h3>
                        </div>
                        <p class="feature-one__text">Complete house cleaning solutions for a spotless home environment.</p>
                        <div class="feature-one__btn-box">
                            <a href="{{ url('/services') }}" class="feature-one__btn">View more</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 wow fadeInUp" data-wow-delay="300ms">
                    <div class="feature-one__single">
                        <div class="feature-one-single-bg" style="background-image: url({{ asset('assets/images/backgrounds/feature-one-single-bg.jpg') }});">
                        </div>
                        <div class="feature-one__icon">
                            <img src="{{ asset('assets/images/icon/feature-one-icon-3.png') }}" alt="">
                            <div class="feature-one__icon-shape">
                                <img src="{{ asset('assets/images/shapes/feature-one-icon-shape.png') }}" alt="">
                            </div>
                        </div>
                        <div class="feature-one__title-box">
                            <div class="feature-one__title-border"></div>
                            <h3 class="feature-one__title"><a href="{{ url('/services') }}">Plumber Service</a></h3>
                        </div>
                        <p class="feature-one__text">Expert plumbing services for all your repair and maintenance needs.</p>
                        <div class="feature-one__btn-box">
                            <a href="{{ url('/services') }}" class="feature-one__btn">View more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section (Jasa) -->
    <section class="services-one">
        <div class="container">
            <div class="section-title text-center">
                <span class="section-title__tagline">Our Services</span>
                <h2 class="section-title__title">Providing the Best Services <br> for Our Customers</h2>
            </div>

            <div class="row">
                @if(isset($jasas) && count($jasas) > 0)
                    @foreach($jasas as $jasa)
                        <div class="col-xl-4 col-lg-6 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 100 }}ms">
                            <div class="services-one__single">
                                <div class="services-one__single-top-bubble" style="background-image: url({{ asset('assets/images/shapes/services-one-single-top-bubble.png') }});">
                                </div>
                                <div class="services-one__icon">
                                    <span class="icon-plumbing"></span>
                                </div>
                                <div class="services-one__single-inner">
                                    <div class="services-one__title-box">
                                        <h3 class="services-one__title"><a href="#">{{ $jasa->nama }}</a></h3>
                                    </div>
                                    <div class="services-one__text-box">
                                        <p class="services-one__text">{{ $jasa->deskripsi }}</p>
                                    </div>
                                </div>
                                <div class="services-one__overly-box" style="background-image: url({{ asset('assets/images/shapes/services-one-single-overlay-bg-1.png') }});">
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p>No services available at the moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="blog-one">
        <div class="blog-one-shape" style="background-image: url({{ asset('assets/images/shapes/blog-one-shape.png') }});"></div>
        <div class="container">
            <div class="section-title text-left">
                <span class="section-title__tagline">Our Products</span>
                <h2 class="section-title__title">Quality Products <br> for Your Needs</h2>
            </div>
            
            <div class="row">
                @if(isset($products) && count($products) > 0)
                    @foreach($products as $product)
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-4">
                            <div class="blog-one__single">
                                <div class="blog-one__img">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    @else
                                        <img src="{{ asset('assets/images/blog/blog-1-1.jpg') }}" alt="Default Image">
                                    @endif
                                    <a href="{{ route('products.show', $product->id) }}">
                                        <span class="blog-one__plus"></span>
                                    </a>
                                </div>
                                <div class="blog-one__content">
                                    <h3 class="blog-one__title">
                                        <a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a>
                                    </h3>
                                    <p>{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                                    <div class="blog-one__btn-box">
                                        <a href="{{ route('products.show', $product->id) }}">View Details <i class="fa fa-angle-right"></i></a>
                                    </div>
                                    <div class="blog-one__tag">
                                        <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p>No products available at the moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-one">
        <div class="contact-one-shape-1 float-bob-x">
            <img src="{{ asset('assets/images/shapes/contact-one-shape-1.png') }}" alt="">
        </div>
        <div class="container">
            <div class="section-title text-center">
                <span class="section-title__tagline">Need any cleaning service</span>
                <h2 class="section-title__title">Get a Free Estimate</h2>
                <div class="section-title__icon">
                    <img src="{{ asset('assets/images/icon/section-title-icon-1.png') }}" alt="">
                </div>
            </div>
            <div class="contact-one__inner">
                <div class="row">
                    <div class="col-xl-7 col-lg-7">
                        <div class="contact-one__left">
                            <div class="contact-one__form-box">
                                {{-- INI ADALAH BAGIAN FORM YANG PERLU ANDA GANTI --}}
                                <form action="{{ route('inquiry.submit') }}" method="POST" class="comment-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="comment-form__input-box">
                                                <input type="text" placeholder="Your Name" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="comment-form__input-box">
                                                <input type="email" placeholder="Email Address" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="comment-form__input-box">
                                                <input type="text" placeholder="Phone Number" name="phone">
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="comment-form__input-box">
                                                {{-- Dropdown untuk memilih layanan Jasa --}}
                                                <div class="select-box">
                                                    <select name="service" class="wide" aria-label="Select service">
                                                        <option data-display="Select service">Select service</option>
                                                        {{-- Loop ini akan mengambil data jasa dari database --}}
                                                        @foreach($jasas as $jasa)
                                                            <option value="{{ $jasa->id }}">{{ $jasa->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="comment-form__input-box">
                                                <textarea name="message" placeholder="Write message"></textarea>
                                            </div>
                                            <button type="submit" class="thm-btn comment-form__btn">Send a message <i class="fa fa-angle-right"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="contact-one__right">
                            <div class="contact-one-shape-1"></div>
                            <div class="contact-one-shape-2"></div>
                            <div class="contact-one-shape-3"></div>
                            <div class="contact-one__img">
                                <img src="{{ asset('assets/images/resources/contact-one-img-1.jpg') }}" alt="">
                            </div>
                            <div class="contact-one__call">
                                <div class="contact-one__call-icon">
                                    <span class="icon-phone-call"></span>
                                </div>
                                <div class="contact-one__call-content">
                                    <p class="contact-one__call-sub-title">Call Anytime</p>
                                    <h5 class="contact-one__call-number"><a href="tel:123456789">123 456 789</a></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
