@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Keranjang Belanja</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(isset($cartItems) && count($cartItems) > 0)
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($cartItems as $item)
                                @php 
                                    $subtotal = $item->price * $item->quantity;
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary me-3" style="width: 80px; height: 80px;"></div>
                                            @endif
                                            <div>
                                                <h5 class="mb-0">{{ $item->product->name }}</h5>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="input-group" style="width: 120px;">
                                            <button class="btn btn-sm btn-outline-secondary update-quantity" data-id="{{ $item->id }}" data-action="decrease">-</button>
                                            <input type="text" class="form-control text-center quantity-input" value="{{ $item->quantity }}" data-id="{{ $item->id }}" readonly>
                                            <button class="btn btn-sm btn-outline-secondary update-quantity" data-id="{{ $item->id }}" data-action="increase">+</button>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                <td colspan="2" class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mb-4">
            <!-- Tombol Lanjutkan Belanja -->
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Lanjutkan Belanja
            </a>

            <!-- Tombol Checkout -->
            <form action="{{ route('client.orders.store') }}" method="POST">
    @csrf
    <!-- Tambahkan field yang diperlukan oleh OrderController::store -->
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-shopping-cart me-2"></i>Checkout
    </button>
</form>

            <!-- Tombol Order (Lihat Order) -->
            <a href="{{ route('orders.index') }}" class="btn btn-success ms-2">
                <i class="fas fa-box me-2"></i>Lihat Order
            </a>
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-shopping-cart fa-4x mb-3 text-muted"></i>
                <h3>Keranjang Belanja Kosong</h3>
                <p class="mb-4">Anda belum menambahkan produk apapun ke keranjang.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag me-2"></i>Belanja Sekarang
                </a>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk update quantity
        const updateButtons = document.querySelectorAll('.update-quantity');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        updateButtons.forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.dataset.id;
                const action = this.dataset.action;
                const quantityInput = this.parentElement.querySelector('.quantity-input');
                let quantity = parseInt(quantityInput.value);
                
                if (action === 'increase') {
                    quantity += 1;
                } else if (action === 'decrease' && quantity > 1) {
                    quantity -= 1;
                } else {
                    return; // Jangan lakukan apa-apa jika quantity sudah 1 dan action decrease
                }
                
                // Update quantity via AJAX
                fetch('{{ route('cart.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        id: itemId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
@endpush
@endsection
