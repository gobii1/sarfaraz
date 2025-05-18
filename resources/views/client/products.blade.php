{{-- resources/views/client/products.blade.php --}}
@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        @foreach ($products as $product)
        <div class="col-md-4">
            <div class="card">
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">${{ number_format($product->price, 2) }}</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">View Details</button>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel{{ $product->id }}">{{ $product->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="img-fluid">
                        <p>{{ $product->description }}</p>
                        <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
