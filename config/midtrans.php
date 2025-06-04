<?php

return [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => true,
    'is_3ds' => true,
];
// Pastikan Anda mengisi MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY di .env Anda
// Contoh:
// MIDTRANS_SERVER_KEY=YOUR_SERVER_KEY
// MIDTRANS_CLIENT_KEY=YOUR_CLIENT_KEY
// MIDTRANS_IS_PRODUCTION=true
// MIDTRANS_IS_SANITIZED=true
// MIDTRANS_IS_3DS=true
// c:\laragon\www\sarfaraz\config\midtrans.php
