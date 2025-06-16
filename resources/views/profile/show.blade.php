@extends('layouts.layout')

@php
    $title = 'Profil Saya';
    $subTitle = 'Kelola informasi akun Anda';
@endphp

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card radius-8 border-0">
            <div class="card-body p-24">
                <h5 class="mb-4">Informasi Profil</h5>

                {{-- Tampilkan pesan sukses jika ada --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role / Peran</label>
                        <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                        <div class="form-text">Role tidak dapat diubah.</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection