@extends('layouts.layout') {{-- Atau layout admin yang kamu gunakan --}}

@section('content')
<div class="container">
    <h1>Daftar Halaman Statis (Tes)</h1>
    <p>Jika ini muncul, view berhasil dimuat!</p>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">Tambah Halaman Baru</a>
    {{-- Nanti di sini akan ada tabel untuk menampilkan daftar halaman --}}
</div>
@endsection