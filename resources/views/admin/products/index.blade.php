@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Products</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Add New Product</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
                        </td>
                        <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <!-- Form untuk delete produk -->
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE') <!-- Menandakan bahwa ini adalah request DELETE -->
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
