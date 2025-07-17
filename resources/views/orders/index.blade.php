{{-- resources/views/orders/index.blade.php (untuk client) --}}
@extends('layouts.app')

@section('title', 'Daftar Pesanan Saya')

@section('content')
<section class="page-header">
    <div class="page-header-bg" style="background-image: url({{ asset('assets/images/backgrounds/page-header-bg.jpg') }})">
    </div>
    <div class="container">
        <div class="page-header__inner">
            <ul class="thm-breadcrumb list-unstyled">
                <li><a href="{{ route('client.dashboard') }}">Home</a></li>
                <li><span>/</span></li>
                <li>Pesanan Saya</li>
            </ul>
            <h2>Pesanan Saya</h2>
        </div>
    </div>
</section>

<section class="my-order-list-section py-5">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @enderror

        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Daftar Pesanan Anda</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th> {{-- Judul kolom tetap --}}
                                <th>Ringkasan Pesanan</th>
                                <th>Total Harga</th>
                                <th>Status Pesanan</th>
                                <th>Status Pembayaran</th>
                                <th>Tanggal Pesan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    {{-- INI PERUBAHANNYA: Tampilkan user_order_id --}}
                                    <td>#{{ $order->user_order_id }}</td>
                                    
                                    <td>
                                        @if ($order->orderItems->isNotEmpty())
                                            <strong>{{ $order->orderItems->first()->product->name ?? 'Produk Dihapus' }}</strong>
                                            @if ($order->orderItems->count() > 1)
                                                <br>+ {{ $order->orderItems->count() - 1 }} produk lainnya
                                            @endif
                                        @else
                                            Tidak ada item
                                        @endif
                                    </td>
                                    <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{
                                            $order->status == 'pending' ? 'bg-warning' :
                                            ($order->status == 'completed' ? 'bg-success' :
                                            ($order->status == 'cancelled' ? 'bg-danger' :
                                            ($order->status == 'on hold' ? 'bg-info' : 'bg-secondary')))
                                        }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{
                                            $order->payment_status == 'pending' ? 'bg-warning' :
                                            ($order->payment_status == 'paid' ? 'bg-success' :
                                            ($order->payment_status == 'failed' || $order->payment_status == 'expired' ? 'bg-danger' :
                                            ($order->payment_status == 'challenge' ? 'bg-info' : 'bg-secondary')))
                                        }}">{{ ucfirst($order->payment_status) }}</span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        {{-- LINK INI HARUS TETAP MENGGUNAKAN $order->id --}}
                                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Anda belum memiliki pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
{{-- Style tidak perlu diubah, biarkan saja --}}
<style>
    .badge { padding: 0.35em 0.65em; font-size: 0.75em; font-weight: 700; line-height: 1; color: #fff; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: 0.25rem; }
    .bg-warning { background-color: #ffc107 !important; color: #000 !important; }
    .bg-success { background-color: #28a745 !important; }
    .bg-danger { background-color: #dc3545 !important; }
    .bg-info { background-color: #17a2b8 !important; }
    .bg-secondary { background-color: #6c757d !important; }
    .btn-primary { color: #fff; background-color: #007bff; border-color: #007bff; }
</style>
@endsection