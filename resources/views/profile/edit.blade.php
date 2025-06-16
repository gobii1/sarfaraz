@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<section class="page-header">
    <div class="page-header-bg" style="background-image: url({{ asset('assets/images/backgrounds/page-header-bg.jpg') }});"></div>
    <div class="container">
        <div class="page-header__inner">
            <h2>My Profile</h2>
            <ul class="thm-breadcrumb list-unstyled">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><span>/</span></li>
                <li class="active">Profile</li>
            </ul>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row justify-content-center g-4">
        {{-- Update Profile --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-4">Update Profile Information</h5>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- Change Password --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-4">Change Password</h5>
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- Delete Account --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-4 text-danger">Delete Account</h5>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
