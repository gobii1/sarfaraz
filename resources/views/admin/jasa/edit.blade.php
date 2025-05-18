<!-- resources/views/admin/jasa/edit.blade.php -->

@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>Edit Jasa</h2>

        <form action="{{ route('admin.jasa.update', $jasa->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')  <!-- Method PUT untuk update data -->
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $jasa->nama) }}" required>
    </div>
    <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" required>{{ old('deskripsi', $jasa->deskripsi) }}</textarea>
    </div>
    <div class="mb-3">
        <label for="harga" class="form-label">Harga</label>
        <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $jasa->harga) }}" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Gambar</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>
    @if ($jasa->image)
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Saat Ini</label><br>
            <img src="{{ asset('storage/' . $jasa->image) }}" alt="current-image" width="100">
        </div>
    @endif
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>

    </div>
@endsection
