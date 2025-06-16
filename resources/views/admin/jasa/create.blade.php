@extends('layouts.layout')
@section('title', 'Buat Jasa Baru') {{-- Set judul halaman browser --}}
@section('meta_description', 'Buat jasa baru untuk ditawarkan di platform kami.') {{-- Opsional, untuk SEO --}}
@section('meta_keywords', 'jasa, buat jasa, layanan baru') {{-- Opsional, untuk SEO --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Buat Jasa Baru</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.jasa.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Jasa</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Jasa</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga') }}" required>
                            @error('harga')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Utama Jasa (Thumbnail)</label>
                            <input class="form-control" type="file" id="image" name="image">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- INPUT BARU UNTUK GAMBAR GALERI --}}
                        <div class="mb-3">
                            <label for="gallery_images" class="form-label">Gambar Galeri (Bisa Lebih dari 1)</label>
                            <input class="form-control" type="file" id="gallery_images" name="gallery_images[]" multiple>
                            @error('gallery_images.*') {{-- Validasi untuk setiap file di array --}}
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Jasa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection