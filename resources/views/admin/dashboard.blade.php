@extends('layouts.layout')
@php
    $title='Dashboard';
    $subTitle = 'Sarfaraz Cleaning'; // Bisa diubah sesuai konteks
@endphp

@section('content')

<div class="row gy-4">
    {{-- Kartu Statistik Utama --}}
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card-body p-24 h-100 d-flex flex-column justify-content-center border">
            <span class="mb-1 fw-medium text-secondary-light text-md">Total Produk</span>
            <h6 class="fw-semibold text-primary-light mb-1">{{ $totalProducts }}</h6>
        </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card-body p-24 h-100 d-flex flex-column justify-content-center border">
            <span class="mb-1 fw-medium text-secondary-light text-md">Total Pelanggan</span>
            <h6 class="fw-semibold text-primary-light mb-1">{{ $totalCustomers }}</h6>
        </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card-body p-24 h-100 d-flex flex-column justify-content-center border">
            <span class="mb-1 fw-medium text-secondary-light text-md">Total Pesanan</span>
            <h6 class="fw-semibold text-primary-light mb-1">{{ $totalOrders }}</h6>
        </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card-body p-24 h-100 d-flex flex-column justify-content-center border">
            <span class="mb-1 fw-medium text-secondary-light text-md">Total Penjualan</span>
            <h6 class="fw-semibold text-primary-light mb-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h6>
        </div>
    </div>
     <div class="col-6 col-lg-3 col-md-6">
        <div class="card-body p-24 h-100 d-flex flex-column justify-content-center border">
            <span class="mb-1 fw-medium text-secondary-light text-md">Total Jasa</span>
            <h6 class="fw-semibold text-primary-light mb-1">{{ $totalJasa }}</h6>
        </div>
    </div>
    <div class="col-6 col-lg-3 col-md-6">
        <div class="card-body p-24 h-100 d-flex flex-column justify-content-center border">
            <span class="mb-1 fw-medium text-secondary-light text-md">Inquiry Baru</span>
            <h6 class="fw-semibold text-danger-main mb-1">{{ $newInquiriesCount }}</h6>
        </div>
    </div>


    {{-- Tabel Pesanan Terbaru --}}
    <div class="col-xxl-9 col-lg-6">
        <div class="card h-100">
            <div class="card-body p-24">
                <h6 class="mb-2 fw-bold text-lg mb-0">Pesanan Terbaru</h6>
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Pelanggan</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Total Harga</th>
                                <th scope="col" class="text-center">Status Pesanan</th>
                                <th scope="col" class="text-center">Status Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestOrders as $order)
                            <tr>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>#{{ $order->id }}</td>
                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $order->getStatusBadgeColor() }}">{{ $order->getStatusText() }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $order->getPaymentStatusBadgeColor() }}">{{ $order->getPaymentStatusText() }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada pesanan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Inquiry Jasa Terbaru --}}
    <div class="col-xxl-9 col-lg-6">
        <div class="card h-100">
            <div class="card-body p-24">
                <h6 class="mb-2 fw-bold text-lg mb-0">Permintaan Jasa Terbaru (Inquiries)</h6>
                 <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telepon</th>
                                <th scope="col">Jasa yang Diminati</th>
                                <th scope="col">Tanggal</th>
                            </tr>
                        </thead>
                         <tbody>
                            @forelse($latestInquiries as $inquiry)
                            <tr>
                                <td>{{ $inquiry->name }}</td>
                                <td>{{ $inquiry->email }}</td>
                                <td>{{ $inquiry->phone }}</td>
                                <td>{{ $inquiry->jasa->nama ?? 'N/A' }}</td>
                                <td>{{ $inquiry->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada permintaan jasa.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Anda bisa melanjutkan untuk bagian lainnya seperti Top Selling Product, dll --}}

</div>

@endsection