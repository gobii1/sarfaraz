{{-- resources/views/admin/orders/show.blade.php --}}
@extends('layouts.layout') {{-- Pastikan ini sesuai dengan layout admin Anda --}}

@section('title', 'Detail Pesanan #' . $order->id)
{{-- @section('subTitle', 'Pesanan Admin') --}} {{-- Opsional, sesuaikan jika x-breadcrumb butuh ini --}}

@section('content')
{{-- Anda bisa mengatur padding/margin section ini agar sesuai dengan tema Anda --}}
<section class="order-detail-admin-section py-5">
    <div class="container-fluid"> {{-- Gunakan container-fluid jika ingin full-width atau container biasa --}}
        
        {{-- CARD UTAMA: Sesuaikan kelas card Anda di sini --}}
        {{-- Cek di halaman lain tema Anda, mungkin ada kelas seperti 'card', 'box', 'panel', dll. --}}
        <div class="card custom-card-style"> {{-- Ganti 'custom-card-style' dengan kelas card tema Anda, misal: card, box, panel --}}
            
            {{-- CARD HEADER: Sesuaikan kelas header card --}}
            {{-- Mungkin ada 'card-header', 'box-header', 'panel-heading', dll. --}}
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Detail Pesanan #{{ $order->id }}</h3>
                <div>
                    {{-- TOMBOL: Sesuaikan kelas tombol Anda --}}
                    {{-- Misal: btn-success, btn-outline-primary, dll. --}}
                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-primary btn-sm">Edit Pesanan</a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">Kembali ke Daftar Pesanan</a>
                </div>
            </div>

            {{-- CARD BODY: Sesuaikan kelas body card --}}
            {{-- Mungkin ada 'card-body', 'box-body', 'panel-body', dll. --}}
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Informasi Pesanan</h4>
                        <p><strong>ID Pesanan Sistem:</strong> #{{ $order->id }}</p>
                        <p><strong>Nomor Pesanan Pengguna:</strong> #{{ $order->user_order_number ?? 'N/A' }}</p> {{-- Menampilkan user_order_number --}}
                        <p><strong>Dibuat Oleh User:</strong> {{ $order->user->name ?? 'User Dihapus' }} (ID: {{ $order->user_id }})</p>
                        <p><strong>Email User:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                        <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y H:i:s') }}</p>
                        <p><strong>Jumlah Total:</strong> Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <p><strong>Status Pesanan:</strong> 
                            <span class="badge 
                                @if($order->status == 'pending') bg-warning 
                                @elseif($order->status == 'processing') bg-info 
                                @elseif($order->status == 'completed') bg-success 
                                @else bg-danger @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                        <p><strong>Status Pembayaran:</strong> 
                            <span class="badge 
                                @if($order->payment_status == 'pending') bg-warning 
                                @elseif($order->payment_status == 'settlement' || $order->payment_status == 'capture') bg-success 
                                @else bg-danger @endif">
                                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                            </span>
                        </p>
                        <p><strong>ID Transaksi Midtrans:</strong> {{ $order->midtrans_transaction_id ?? 'Belum ada' }}</p>
                        {{-- <p><strong>Midtrans Raw Response:</strong> <pre>{{ json_encode($order->midtrans_response_raw, JSON_PRETTY_PRINT) }}</pre></p> --}}
                    </div>
                    <div class="col-md-6">
                        <h4>Item Pesanan</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->nama ?? 'Produk Dihapus' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td>Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada item dalam pesanan ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
{{-- Jika ada JavaScript khusus yang dibutuhkan untuk halaman detail, masukkan di sini --}}
@endsection

{{-- Bagian @section('styles') di bawah ini dihapus karena diasumsikan styling datang dari tema Anda --}}
{{-- Jangan lupa untuk memastikan CSS tema Anda sudah diload di <x-head /> --}}