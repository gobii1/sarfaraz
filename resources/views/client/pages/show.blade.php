@extends('layouts.app') {{-- Atau layout frontend-mu --}}

@section('title', $page->title) {{-- Set judul halaman browser --}}
@section('meta_description', $page->meta_description) {{-- Opsional, untuk SEO --}}
@section('meta_keywords', $page->meta_keywords) {{-- Opsional, untuk SEO --}}


@section('content')
<div class="container mt-5 mb-5">
    <h1>{{ $page->title }}</h1>
    <div>
        {!! $page->content !!} {{-- Gunakan {!! !!} jika konten mengandung HTML dari editor --}}
    </div>
</div>
@endsection