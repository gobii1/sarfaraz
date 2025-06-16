@extends('layouts.app')

@section('title', $jasa->nama . ' - Cleaning Services')

@section('content')
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
<section class="service-details">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="service-details__left">
                    <div class="service-details__img">
                        {{-- GAMBAR UTAMA JASA (SUDAH DINAMIS) --}}
                        <img src="{{ asset('storage/' . $jasa->image) }}" alt="{{ $jasa->nama }}">
                        <div class="service-details__icon">
                            <span class="icon-cleaning"></span>
                        </div>
                    </div>
                    <h3 class="service-details__title">{{ $jasa->nama }}</h3>
                    <p class="service-details__text-1">{{ $jasa->deskripsi }}</p>
                    
                    {{-- Bagian "Our Benefits" dan GALERI GAMBAR JASA DI SINI --}}
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
                                {{-- GALERI GAMBAR JASA DIPINDAHKAN KE SINI --}}
                                @if($jasa->gallery_images && count($jasa->gallery_images) > 0)
                                <div class="service-details__gallery-in-benefits mt-3 mt-xl-0"> {{-- Tambah kelas margin untuk responsif --}}
                                    <h4 class="service-details__gallery-title mb-3">Contoh Pekerjaan</h4> {{-- Judul lebih kecil --}}
                                    <div class="row">
                                        @foreach($jasa->gallery_images as $galImage)
                                        <div class="col-6 mb-3"> {{-- Mengubah kolom agar pas di dalam col-xl-6 --}}
                                            <div class="service-details__gallery-item-small">
                                                <img src="{{ asset('storage/' . $galImage) }}" alt="Galeri {{ $jasa->nama }}">
                                                <a href="{{ asset('storage/' . $galImage) }}" class="img-popup">
                                                    <span class="icon-plus"></span>
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- Bagian GALERI GAMBAR JASA ASLI DIBAWAH INI TELAH DIHAPUS/DIPINDAHKAN --}}
                    {{-- @if($jasa->gallery_images && count($jasa->gallery_images) > 0)
                    <div class="service-details__gallery mt-5">
                        <h3 class="service-details__gallery-title">Contoh Pekerjaan Kami</h3>
                        <div class="row">
                            @foreach($jasa->gallery_images as $galImage)
                            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                                <div class="service-details__gallery-item">
                                    <img src="{{ asset('storage/' . $galImage) }}" alt="Galeri {{ $jasa->nama }}">
                                    <a href="{{ asset('storage/' . $galImage) }}" class="img-popup">
                                        <span class="icon-plus"></span>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif --}}

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
                        <h3 class="service-details__need-help-title">Pesan Layanan Ini Sekarang</h3>
                        <p class="service-details__need-help-text">Hubungi kami untuk menjadwalkan layanan Anda</p>
                        <div class="service-details__need-help-icon">
                            <span class="icon-phone"></span>
                        </div>
                        <div class="service-details__need-help-contact">
                            <p>Hubungi kapan saja</p>
                            <a href="tel:6283125587604">6283125587604</a>
                        </div>
                        <div class="service-details__need-help-btn-box">
                            @php
                                $whatsappNumber = '6283125587604'; // **GANTI DENGAN NOMOR WHATSAPP KLIEN ANDA**
                                $jasaName = urlencode($jasa->nama);
                                $jasaPrice = urlencode(number_format($jasa->harga, 0, ',', '.'));
                                $message = urlencode("Halo, saya tertarik dengan jasa {$jasa->nama} (Rp {$jasaPrice}). Bisakah saya mendapatkan informasi lebih lanjut atau memesan sekarang?");
                                $whatsappLink = "https://wa.me/{$whatsappNumber}?text={$message}";
                            @endphp
                            <a href="{{ $whatsappLink }}" target="_blank" class="thm-btn service-details__need-help-btn">
                                <i class="fab fa-whatsapp"></i> Pesan via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection