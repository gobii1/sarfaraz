@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->user_order_id)

@section('content')
<section class="page-header">
    <div class="page-header-bg" style="background-image: url({{ asset('assets/images/backgrounds/page-header-bg.jpg') }})">
    </div>
    <div class="container">
        <div class="page-header__inner">
            <ul class="thm-breadcrumb list-unstyled">
                <li><a href="{{ route('client.dashboard') }}">Home</a></li>
                <li><span>/</span></li>
                <li><a href="{{ route('orders.index') }}">Pesanan Saya</a></li>
                <li><span>/</span></li>
                <li>Detail</li>
            </ul>
            <h2>Detail Pesanan #{{ $order->user_order_id }}</h2>
        </div>
    </div>
</section>

<section class="order-details-section py-5">
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
                <h3>Ringkasan Pesanan</h3>
            </div>
            <div class="card-body">
                <p><strong>ID Pesanan:</strong> #{{ $order->user_order_id }} (Ref: {{ $order->id }})</p>
                <p><strong>Total Harga:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                <p><strong>Status Pesanan:</strong> <span class="badge {{ $order->status == 'completed' ? 'bg-success' : ($order->status == 'cancelled' ? 'bg-danger' : 'bg-warning') }}">{{ ucfirst($order->status) }}</span></p>
                <p><strong>Status Pembayaran:</strong> <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : ($order->payment_status == 'pending' ? 'bg-warning' : 'bg-danger') }}">{{ ucfirst($order->payment_status) }}</span></p>
                <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>

                @if ($order->payment_status == 'pending' && $order->snap_token)
                    <hr>
                    <h4>Lanjutkan Pembayaran</h4>
                    <p>Silakan selesaikan pembayaran Anda melalui Midtrans.</p>
                    <button class="thm-btn" id="pay-button">Bayar Sekarang</button>
                @elseif ($order->payment_status == 'paid')
                    <hr>
                    <div class="alert alert-success">Pembayaran telah berhasil!</div>
                @elseif ($order->payment_status == 'failed' || $order->payment_status == 'expired' || $order->payment_status == 'cancelled')
                    <hr>
                    <div class="alert alert-danger">Pembayaran gagal, kadaluarsa, atau dibatalkan.</div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Detail Produk</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
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
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total Akhir:</th>
                                <th>Rp{{ number_format($order->total_price, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('orders.index') }}" class="thm-btn thm-btn--base">Kembali ke Daftar Pesanan</a>
        </div>
    </div>
</section>
@endsection

@section('scripts')
@if ($order->payment_status == 'pending' && $order->snap_token)
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            snap.pay('{{ $order->snap_token }}', {
                onSuccess: function(result){
                    alert("Pembayaran berhasil!"); console.log(result); window.location.reload();
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda!"); console.log(result);
                },
                onError: function(result){
                    alert("Pembayaran gagal!"); console.log(result);
                },
                onClose: function(){
                    alert('Anda menutup pop-up tanpa menyelesaikan pembayaran.');
                }
            });
        };
    </script>
@endif
@endsection

@section('styles')
<style>
    .badge { padding: 0.5em 0.75em; border-radius: 0.25rem; font-size: 0.85em; font-weight: 700; color: #fff; }
    .bg-success { background-color: #28a745; }
    .bg-warning { background-color: #ffc107; }
    .bg-danger { background-color: #dc3545; }
    .table-responsive { margin-top: 20px; }
    .card-header h3 { margin-bottom: 0; }
</style>
@endsection