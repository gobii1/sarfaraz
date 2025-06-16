{{-- File: resources/views/admin/orders/index.blade.php --}}
@extends('layouts.layout')

@section('title', 'Manajemen Pesanan')

@section('content')
<section class="order-list-section py-5">
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                                <th>Nama Pelanggan</th>
                                <th>Total Harga</th>
                                <th>Status Pesanan</th>
                                <th>Status Pembayaran</th>
                                <th>Metode Pembayaran</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    {{-- PERBAIKAN #1: Menampilkan ID Pesanan dengan benar --}}
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-primary fw-bold">#{{ $order->id }}</a>
                                    </td>
                                    <td>
                                        <h5 class="font-14 my-1 fw-normal">{{ $order->customer_name }}</h5>
                                        {{-- PERBAIKAN #2: Memberi nilai default jika user tidak ada --}}
                                        <span class="text-muted font-13">{{ $order->user->email ?? 'User Tamu/Dihapus' }}</span>
                                    </td>
                                    {{-- INFO: Kode ini sudah benar, masalah Rp 0 ada di data lama --}}
                                    <td>Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                            <iconify-icon icon="ri:eye-line"></iconify-icon>
                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <iconify-icon icon="ri:edit-line"></iconify-icon>
                                        </a>
                                        {{-- PERBAIKAN #3: Memastikan form hapus ada dan berfungsi --}}
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini? Aksi ini tidak dapat dibatalkan.');">
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