<?php

use Illuminate\Support\Facades\Broadcast;

// ...

// routes/channels.php
Broadcast::channel('admin-channel', function ($user) {
    // Mengubah role menjadi huruf kecil sebelum membandingkan
    return strtolower($user->role) === 'admin'; 
});