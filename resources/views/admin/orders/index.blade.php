@extends('layouts.layout') {{-- Pastikan ini sesuai dengan layout admin Anda --}}

{{-- Definisi title dan subTitle yang akan dioper ke x-breadcrumb --}}
@section('title', 'Manajemen Pesanan')
{{-- @section('subTitle', 'Daftar Pesanan') --}} {{-- Opsional, jika Anda ingin subTitle di breadcrumb --}}

@section('content')
{{-- Hapus seluruh kode <section class="page-header">...</section> dari sini.
    Yang akan merender breadcrumb dan title adalah <x-breadcrumb /> di layouts/layout.blade.php --}}

<section class="order-list-section py-5">
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
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Daftar Semua Pesanan</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Ringkasan Pesanan</th>
                                <th>User</th>
                                <th>Total Harga</th>
                                <th>Status Pesanan</th>
                                <th>Status Pembayaran</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
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
                                    <td>{{ $order->user->name ?? 'User Dihapus' }}</td>
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
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                            <iconify-icon icon="ri:eye-line"></iconify-icon>
                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <iconify-icon icon="ri:edit-line"></iconify-icon>
                                        </a>
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini? Aksi ini tidak dapat dibatalkan dan stok produk akan dikembalikan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <iconify-icon icon="ri:delete-bin-line"></iconify-icon>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada pesanan yang tersedia.</td>
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