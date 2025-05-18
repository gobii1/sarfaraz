@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>{{ $jasa->nama }}</h2>
        <p>{{ $jasa->deskripsi }}</p>
        <p>Price: Rp {{ number_format($jasa->harga, 0, ',', '.') }}</p>
        <a href="{{ route('jasa.index') }}" class="btn btn-secondary">Back to Services</a>
    </div>
@endsection
