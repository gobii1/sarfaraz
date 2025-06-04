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
                    {{-- Misal: btn-success, btn-outline-primary, btn-info-fill, dll. --}}
                    <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-primary theme-btn-edit"> {{-- Ganti 'btn-primary theme-btn-edit' --}}
                        <iconify-icon icon="ri:edit-line"></iconify-icon> Edit Status
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary theme-btn-back"> {{-- Ganti 'btn-secondary theme-btn-back' --}}
                        <iconify-icon icon="ri:arrow-go-back-line"></iconify-icon> Kembali ke Daftar
                    </a>
                </div>
            </div>

            {{-- CARD BODY: Sesuaikan kelas body card --}}
            {{-- Mungkin ada 'card-body', 'box-body', 'panel-body', dll. --}}
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Informasi Pesanan</h4>
                        {{-- LIST GROUP: Sesuaikan kelas list group --}}
                        {{-- Mungkin ada 'list-group', 'list-unstyled', 'custom-list-style', dll. --}}
                        <ul class="list-group list-group-flush custom-list-style"> {{-- Ganti 'custom-list-style' --}}
                            <li class="list-group-item"><strong>ID Pesanan:</strong> #{{ $order->id }}</li>
                            <li class="list-group-item"><strong>User:</strong> {{ $order->user->name ?? 'User Dihapus' }} ({{ $order->user->email ?? 'N/A' }})</li>
                            <li class="list-group-item"><strong>Total Harga:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</li>
                            <li class="list-group-item">
                                <strong>Status Pesanan:</strong>
                                {{-- BADGE: Sesuaikan kelas badge Anda --}}
                                {{-- Mungkin ada 'badge badge-success', 'label label-warning', 'status-tag pending', dll. --}}
                                <span class="badge {{
                                    $order->status == 'pending' ? 'bg-warning' :
                                    ($order->status == 'completed' ? 'bg-success' :
                                    ($order->status == 'cancelled' ? 'bg-danger' :
                                    ($order->status == 'on hold' ? 'bg-info' : 'bg-secondary')))
                                }} custom-badge-style">{{ ucfirst($order->status) }}</span> {{-- Ganti 'custom-badge-style' --}}
                            </li>
                            <li class="list-group-item">
                                <strong>Status Pembayaran:</strong>
                                <span class="badge {{
                                    $order->payment_status == 'pending' ? 'bg-warning' :
                                    ($order->payment_status == 'paid' ? 'bg-success' :
                                    ($order->payment_status == 'failed' || $order->payment_status == 'expired' ? 'bg-danger' :
                                    ($order->payment_status == 'challenge' ? 'bg-info' : 'bg-secondary')))
                                }} custom-badge-style">{{ ucfirst($order->payment_status) }}</span> {{-- Ganti 'custom-badge-style' --}}
                            </li>
                            <li class="list-group-item"><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y H:i') }}</li>
                            <li class="list-group-item"><strong>Tanggal Diperbarui:</strong> {{ $order->updated_at->format('d M Y H:i') }}</li>
                            <li class="list-group-item"><strong>Snap Token (Midtrans):</strong> {{ $order->snap_token ?? '-' }}</li>
                            <li class="list-group-item"><strong>Transaction ID (Midtrans):</strong> {{ $order->midtrans_transaction_id ?? '-' }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4>Item Pesanan</h4>
                        {{-- RESPONSIVE TABLE CONTAINER: Cek apakah tema Anda punya div responsif tabel khusus --}}
                        {{-- Misal: 'table-responsive', 'scrollable-table', dll. --}}
                        <div class="table-responsive custom-table-wrapper"> {{-- Ganti 'custom-table-wrapper' --}}
                            {{-- TABEL: Sesuaikan kelas tabel Anda --}}
                            {{-- Misal: 'table table-hover', 'table-bordered', 'data-table', dll. --}}
                            <table class="table table-sm table-bordered custom-data-table"> {{-- Ganti 'custom-data-table' --}}
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Kuantitas</th>
                                        <th>Harga Satuan</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name ?? 'Produk Dihapus' }}</td>
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