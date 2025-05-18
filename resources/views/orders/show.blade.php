@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Detail Pesanan #{{ $order->id }}</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Informasi Pesanan</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="mb-1"><strong>ID Pesanan:</strong> #{{ $order->id }}</p>
                    <p class="mb-1"><strong>Tanggal Pemesanan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                    <p class="mb-1"><strong>Status:</strong> 
                        <span class="badge {{ $order->status == 'pending' ? 'bg-warning' : ($order->status == 'accepted' ? 'bg-success' : 'bg-danger') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><strong>Nama Pemesan:</strong> {{ $order->user->name }}</p>
                    <p class="mb-1"><strong>Email:</strong> {{ $order->user->email }}</p>
                    @if(isset($order->address))
                    <p class="mb-1"><strong>Alamat Pengiriman:</strong> {{ $order->address }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">Detail Produk</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($order->orderItems) && count($order->orderItems) > 0)
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary me-3" style="width: 60px; height: 60px;"></div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $item->product ? $item->product->name : 'Produk tidak tersedia' }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada detail produk</td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total:</td>
                            <td class="fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
