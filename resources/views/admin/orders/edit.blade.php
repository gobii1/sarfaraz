@extends('layouts.layout') {{-- Sesuaikan dengan layout admin Anda jika berbeda --}}

@section('title', 'Edit Pesanan #' . $order->id)

@section('content')
{{-- <section class="page-header">
    <div class="page-header-bg" style="background-image: url({{ asset('assets/images/backgrounds/page-header-bg.jpg') }})">
    </div>
    <div class="container">
        <div class="page-header__inner">
            <ul class="thm-breadcrumb list-unstyled">
                <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li><span>/</span></li>
                <li><a href="{{ route('admin.orders.index') }}">Manajemen Pesanan</a></li>
                <li><span>/</span></li>
                <li>Edit Pesanan #{{ $order->id }}</li>
            </ul>
            <h2>Edit Pesanan #{{ $order->id }}</h2>
        </div>
    </div>
</section> --}}

<section class="edit-order-section py-5">
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
        @endif

        <div class="card mb-4">
            <div class="card-header">
                <h3>Form Edit Pesanan</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Penting untuk HTTP PUT --}}

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Pesanan</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="on hold" {{ old('status', $order->status) == 'on hold' ? 'selected' : '' }}>On Hold</option>
                            <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="refunded" {{ old('status', $order->status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            {{-- Tambahkan status lain jika ada (e.g., shipped, delivered, etc.) --}}
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="payment_status" class="form-label">Status Pembayaran</label>
                        <select class="form-select" id="payment_status" name="payment_status" required>
                            <option value="pending" {{ old('payment_status', $order->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ old('payment_status', $order->payment_status) == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="expired" {{ old('payment_status', $order->payment_status) == 'expired' ? 'selected' : '' }}>Expired</option>
                            <option value="cancelled" {{ old('payment_status', $order->payment_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="challenge" {{ old('payment_status', $order->payment_status) == 'challenge' ? 'selected' : '' }}>Challenge</option>
                            <option value="refunded" {{ old('payment_status', $order->payment_status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                        @error('payment_status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>
                    <h4>Detail Pesanan #{{ $order->id }}</h4>
                    <p><strong>Total Harga:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                    <p><strong>Dibuat oleh:</strong> {{ $order->user->name ?? 'User Dihapus' }} ({{ $order->user->email ?? 'N/A' }})</p>
                    <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>

                    <h5>Item Pesanan:</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="submit" class="thm-btn">Update Pesanan</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* Tambahkan CSS yang relevan untuk form admin jika ada */
    .form-select {
        padding: 0.375rem 2.25rem 0.375rem 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
</style>
@endsection