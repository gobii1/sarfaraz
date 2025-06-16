@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Jasa: {{ $jasa->nama }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.jasa.update', $jasa->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Jasa</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $jasa->nama) }}" required>
                            @error('nama')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Jasa</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $jasa->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $jasa->harga) }}" required>
                            @error('harga')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Utama Jasa (Thumbnail)</label>
                            @if($jasa->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $jasa->image) }}" alt="Gambar Utama" width="150">
                                </div>
                            @endif
                            <input class="form-control" type="file" id="image" name="image">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- INPUT DAN TAMPILAN GAMBAR GALERI --}}
                        <div class="mb-3">
                            <label for="gallery_images" class="form-label">Gambar Galeri (Bisa Tambah Baru)</label>
                            @if($jasa->gallery_images)
                                <div class="mb-2 d-flex flex-wrap align-items-center">
                                    @foreach($jasa->gallery_images as $galImage)
                                        <div class="position-relative me-2 mb-2">
                                            <img src="{{ asset('storage/' . $galImage) }}" alt="Gambar Galeri" width="100" class="border">
                                            {{-- Jika ingin fungsi hapus per gambar, akan ada tombol di sini --}}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <input class="form-control" type="file" id="gallery_images" name="gallery_images[]" multiple>
                            @error('gallery_images.*')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Jasa</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection