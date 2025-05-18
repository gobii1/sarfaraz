@extends('layouts.app')

@section('title', $jasa->nama . ' - Cleaning Services')

@section('content')
<!--Page Header Start-->
<section class="page-header">
    <div class="page-header-bg" style="background-image: url({{ asset('assets/images/backgrounds/page-header-bg.jpg') }})">
    </div>
    <div class="page-header-bubble"><img src="{{ asset('assets/images/shapes/page-header-bubble.png') }}" alt=""></div>
    <div class="container">
        <div class="page-header__inner">
            <ul class="thm-breadcrumb list-unstyled">
                <li><a href="{{ route('client.dashboard') }}">Home</a></li>
                <li><span>/</span></li>
                <li><a href="{{ route('jasa.index') }}">Services</a></li>
                <li><span>/</span></li>
                <li>{{ $jasa->nama }}</li>
            </ul>
            <h2>{{ $jasa->nama }}</h2>
        </div>
    </div>
</section>
<!--Page Header End-->

<!--Service Details Start-->
<section class="service-details">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="service-details__left">
                    <div class="service-details__img">
                        <img src="{{ asset('assets/images/services/service-details-img-1.jpg') }}" alt="">
                        <div class="service-details__icon">
                            <span class="icon-cleaning"></span>
                        </div>
                    </div>
                    <h3 class="service-details__title">{{ $jasa->nama }}</h3>
                    <p class="service-details__text-1">{{ $jasa->deskripsi }}</p>
                    
                    <div class="service-details__benefits">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="service-details__benefits-content">
                                    <h3 class="service-details__benefits-title">Our Benefits</h3>
                                    <p class="service-details__benefits-text">We provide high quality and professional cleaning services.</p>
                                    <ul class="list-unstyled service-details__benefits-list">
                                        <li>
                                            <div class="icon">
                                                <span class="fa fa-check"></span>
                                            </div>
                                            <div class="text">
                                                <p>Expert Staff</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon">
                                                <span class="fa fa-check"></span>
                                            </div>
                                            <div class="text">
                                                <p>Quality Equipment</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon">
                                                <span class="fa fa-check"></span>
                                            </div>
                                            <div class="text">
                                                <p>100% Satisfaction</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="icon">
                                                <span class="fa fa-check"></span>
                                            </div>
                                            <div class="text">
                                                <p>Eco-friendly Products</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="service-details__benefits-img">
                                    <img src="{{ asset('assets/images/services/service-details-benefits-img.jpg') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="service-details__pricing">
                        <h3 class="service-details__pricing-title">Pricing</h3>
                        <p class="service-details__pricing-text">Our pricing is transparent and competitive.</p>
                        <div class="service-details__pricing-inner">
                            <div class="service-details__pricing-icon">
                                <span class="icon-budget"></span>
                            </div>
                            <div class="service-details__pricing-content">
                                <h3>Rp {{ number_format($jasa->harga, 0, ',', '.') }}</h3>
                                <p>Starting price for this service</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5">
                <div class="service-details__sidebar">
                    <div class="service-details__sidebar-service">
                        <h3 class="service-details__sidebar-title">All Services</h3>
                        <ul class="service-details__sidebar-service-list list-unstyled">
                            @foreach($relatedJasas ?? [] as $relatedJasa)
                                <li>
                                    <a href="{{ route('jasa.show', $relatedJasa->id) }}" class="{{ $relatedJasa->id == $jasa->id ? 'current' : '' }}">
                                        {{ $relatedJasa->nama }} <span class="icon-right-arrow"></span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="service-details__need-help">
                        <div class="service-details__need-help-bg" style="background-image: url({{ asset('assets/images/backgrounds/service-details-need-help-bg.jpg') }})">
                        </div>
                        <h3 class="service-details__need-help-title">Book this service now</h3>
                        <p class="service-details__need-help-text">Contact us to schedule your service</p>
                        <div class="service-details__need-help-icon">
                            <span class="icon-phone"></span>
                        </div>
                        <div class="service-details__need-help-contact">
                            <p>Call anytime</p>
                            <a href="tel:123456789">123 456 789</a>
                        </div>
                        <div class="service-details__need-help-btn-box">
                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="jasa_id" value="{{ $jasa->id }}">
                                <button type="submit" class="thm-btn service-details__need-help-btn">Book Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Service Details End-->
@endsection
