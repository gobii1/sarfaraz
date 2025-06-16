{{-- File: resources/views/components/head.blade.php (Versi Final untuk Production) --}}
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Sarfaraz' }}</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/images/safaraz/logosarfaraz1.png') }}">
    
    {{-- Link CSS dari template asli Anda --}}
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/dataTables.min.css') }}">
    {{-- ... dan link-link CSS statis lainnya dari template Anda ... --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    {{-- ================================================================ --}}
    {{-- PINTU MASUK UNTUK ASET LARAVEL VITE --}}
    {{-- Ini akan memuat app.css dan app.js dari folder public/build --}}
    {{-- ================================================================ --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>