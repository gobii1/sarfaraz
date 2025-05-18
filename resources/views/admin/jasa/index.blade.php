<!-- resources/views/admin/jasa/index.blade.php -->

@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2>Daftar Jasa</h2>
        <a href="{{ route('admin.jasa.create') }}" class="btn btn-primary mb-3">Tambah Jasa</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Gambar</th> <!-- Kolom Gambar -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jasas as $jasa)
                    <tr>
                        <td>{{ $jasa->nama }}</td>
                        <td>{{ $jasa->deskripsi }}</td>
                        <td>Rp {{ number_format($jasa->harga, 0, ',', '.') }}</td>
                        <td>
                            @if ($jasa->image)
                                <img src="{{ asset('storage/' . $jasa->image) }}" alt="jasa-image" width="100">
                            @else
                                <span>No Image</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.jasa.edit', $jasa->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.jasa.destroy', $jasa->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
