{{-- File: resources/views/profile/edit.blade.php --}}
@extends('layouts.layout')

@php
    $title = 'Profile';
    $subTitle = 'Kelola informasi akun Anda';
@endphp

@section('content')
    <div class="space-y-6">
        <div class="card radius-8 border-0">
            <div class="card-body p-24">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <div class="card radius-8 border-0">
            <div class="card-body p-24">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="card radius-8 border-0">
            <div class="card-body p-24">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection