@extends('layouts.app')

@section('title', 'Services - Cleaning Services')

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
                <li>Services</li>
            </ul>
            <h2>Our Services</h2>
        </div>
    </div>
</section>
<!--Page Header End-->

<!--Services Page Start-->
<section class="services-page-1">
    <div class="container">
        <div class="row">
            @if(isset($jasas) && count($jasas) > 0)
                @foreach($jasas as $jasa)
    <!-- Services Item Start -->
    <div class="col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 100 }}ms">
        <div class="services-two__single">
            <div class="services-two__img-box">
                <div class="services-two__img">
                    <!-- Gambar dinamis dari database -->
                    <img src="{{ asset('storage/' . $jasa->image) }}" alt="{{ $jasa->nama }}">
                </div>
                <div class="services-two__icon">
                    <span class="icon-{{ ['plumbing', 'laundry', 'washing-plate', 'window-cleaner', 'worker', 'sanitary'][$loop->iteration % 6] }}"></span>
                </div>
            </div>
            <div class="services-two__content">
                <h3 class="services-two__title">
                    <a href="{{ route('jasa.show', $jasa->id) }}">{{ $jasa->nama }}</a>
                </h3>
                <p class="services-two__text">{{ \Illuminate\Support\Str::limit($jasa->deskripsi, 100) }}</p>
                <a href="{{ route('jasa.show', $jasa->id) }}" class="services-two__btn">read more</a>
            </div>
        </div>
    </div>
    <!-- Services Item End -->
@endforeach

            @else
                <div class="col-12 text-center py-5">
                    <div class="no-services-found">
                        <div class="no-services-found__icon">
                            <span class="icon-worker" style="font-size: 48px; color: #ddd;"></span>
                        </div>
                        <h3 class="mt-3">No services available at the moment</h3>
                        <p>Please check back later for our service offerings.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<!--Services Page End-->

<!--Information Start-->
<section class="information information-two">
    <div class="container">
        <div class="information__inner">
            <div class="information__logo-box">
                <div class="information__border-1"></div>
                <div class="information__border-2"></div>
                <a href="{{ route('client.dashboard') }}"><img src="{{ asset('assets/images/resources/information-logo.png') }}" alt=""></a>
            </div>
            <ul class="list-unstyled information__list">
                <li>
                    <div class="information__icon">
                        <span class="icon-phone"></span>
                    </div>
                    <div class="information__content">
                        <p class="information__sub-title">Call anytime</p>
                        <h5 class="information__number">
                            <a href="tel:123456789">123 456 789</a>
                        </h5>
                    </div>
                </li>
                <li>
                    <div class="information__icon">
                        <span class="icon-envelope"></span>
                    </div>
                    <div class="information__content">
                        <p class="information__sub-title">Send email</p>
                        <h5 class="information__number">
                            <a href="mailto:info@example.com">info@example.com</a>
                        </h5>
                    </div>
                </li>
                <li>
                    <div class="information__icon">
                        <span class="icon-location-1"></span>
                    </div>
                    <div class="information__content">
                        <p class="information__sub-title">Visit office</p>
                        <h5 class="information__number">Ciherang, Dramaga, Bogor</h5>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>
<!--Information End-->
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Activate the Services menu item
        $('.main-menu__list li').removeClass('current');
        $('.main-menu__list li:nth-child(3)').addClass('current');
    });
</script>
@endsection
