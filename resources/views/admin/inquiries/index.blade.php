{{-- resources/views/admin/inquiries/index.blade.php --}}
@extends('layouts.layout') {{-- Pastikan ini sesuai dengan layout admin Anda --}}

@section('title', 'Admin Inbox')
{{-- @section('subTitle', 'Daftar Inquiry') --}} {{-- Opsional, sesuaikan jika x-breadcrumb butuh ini --}}

@section('content')
<section class="inquiries-admin-section py-5">
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @enderror

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Inbox (Daftar Pesan Masuk)</h3>
                {{-- Anda bisa tambahkan tombol filter atau search di sini jika diperlukan --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pengirim</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Jasa Terkait</th>
                                <th>Pesan</th>
                                <th>Tanggal Masuk</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($inquiries as $inquiry)
                                <tr class="{{ $inquiry->is_read ? '' : 'table-warning' }}"> {{-- Baris belum dibaca akan disorot --}}
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $inquiry->name }}</td>
                                    <td>{{ $inquiry->email }}</td>
                                    <td>{{ $inquiry->phone ?? '-' }}</td>
                                    <td>{{ $inquiry->jasa->nama ?? 'Tidak Disebutkan' }}</td> {{-- Menampilkan nama jasa --}}
                                    <td>{{ Str::limit($inquiry->message, 50) }}</td> {{-- Tampilkan 50 karakter pertama pesan --}}
                                    <td>{{ $inquiry->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $inquiry->is_read ? 'bg-success' : 'bg-danger' }}">
                                            {{ $inquiry->is_read ? 'Sudah Dibaca' : 'Belum Dibaca' }}
                                        </span>
                                    </td>
                                    <td>
                                        {{-- Tombol Detail (opsional, jika nanti ada halaman detail inquiry terpisah) --}}
                                        {{-- <a href="{{ route('admin.inquiries.show', $inquiry->id) }}" class="btn btn-sm btn-info" title="Detail">
                                            <iconify-icon icon="ri:eye-line"></iconify-icon>
                                        </a> --}}

                                        @if(!$inquiry->is_read)
                                            <form action="{{ route('admin.inquiries.markAsRead', $inquiry->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tandai sebagai sudah dibaca?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary" title="Tandai Sudah Dibaca">
                                                    <iconify-icon icon="ri:mail-open-line"></iconify-icon>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus inquiry ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <iconify-icon icon="ri:delete-bin-line"></iconify-icon>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada pesan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    /* Styling dasar untuk badge, sesuaikan dengan tema Admin Anda */
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }
    .badge.bg-success { background-color: #28a745 !important; }
    .badge.bg-danger { background-color: #dc3545 !important; }
    .table-warning {
        background-color: #fff3cd !important; /* Warna kuning lembut untuk baris belum dibaca */
    }
</style>
@endsection

@section('scripts')
{{-- Jika Anda menggunakan DataTables.js, aktifkan di sini --}}
{{-- <script>
    $(document).ready(function() {
        $('.table').DataTable();
    });
</script> --}}
@endsection