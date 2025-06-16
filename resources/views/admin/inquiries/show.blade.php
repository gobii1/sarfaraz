{{-- File: resources/views/admin/inquiries/show.blade.php --}}
@extends('layouts.layout')

@section('title', 'Detail Pesan dari ' . $inquiry->name)

@section('content')
<section class="inquiry-detail-section py-5">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Detail Pesan Masuk</h3>
                <a href="{{ route('admin.inquiries.index') }}" class="btn btn-secondary">
                    <iconify-icon icon="ri:arrow-left-line"></iconify-icon> Kembali ke Inbox
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1">Dari:</p>
                        <h5>{{ $inquiry->name }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1">Tanggal Diterima:</p>
                        <h5>{{ $inquiry->created_at->format('d M Y, H:i:s') }}</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1">Email:</p>
                        <h5><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p class="text-muted mb-1">Telepon:</p>
                        <h5>{{ $inquiry->phone }}</h5>
                    </div>
                    <div class="col-md-12 mb-3">
                        <p class="text-muted mb-1">Terkait Jasa:</p>
                        <h5>{{ $inquiry->jasa->name ?? 'Umum' }}</h5>
                    </div>
                </div>
                <hr>
                <h5 class="mt-4">Isi Pesan:</h5>
                <div class="p-3 bg-light rounded border">
                    {{-- Menggunakan nl2br untuk menghormati baris baru pada pesan --}}
                    <p style="white-space: pre-wrap;">{!! nl2br(e($inquiry->message)) !!}</p>
                </div>
            </div>
            <div class="card-footer text-end">
                <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pesan ini secara permanen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <iconify-icon icon="ri:delete-bin-line"></iconify-icon> Hapus Pesan Ini
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection