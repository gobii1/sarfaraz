@extends('layouts.layout') {{-- Atau layout adminmu --}}

@section('content')
<div class="container">
    <h1>Buat Halaman Statis Baru</h1>
    <form action="{{ route('admin.pages.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug (opsional, akan dibuat otomatis jika kosong)</label>
            <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Konten</label>
            {{-- Idealnya, gunakan editor WYSIWYG di sini --}}
            <textarea class="form-control" id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="meta_description" class="form-label">Meta Deskripsi (SEO)</label>
            <input type="text" class="form-control" id="meta_description" name="meta_description" value="{{ old('meta_description') }}">
        </div>
         <div class="mb-3">
            <label for="meta_keywords" class="form-label">Meta Keywords (SEO, pisahkan dengan koma)</label>
            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}">
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" checked>
            <label class="form-check-label" for="is_published">
                Publikasikan
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection