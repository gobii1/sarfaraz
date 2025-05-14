<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route default yang mengarahkan ke halaman dashboard berdasarkan role
Route::get('/dashboard', function () {
    if (auth()->user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->role == 'operator') {
        return redirect()->route('operator.dashboard');
    }

    if (auth()->user()->role == 'owner') {
        return redirect()->route('owner.dashboard');
    }

    return redirect()->route('client.dashboard');  // Untuk client
})->middleware(['auth', 'verified'])->name('dashboard');

// Middleware untuk Profile pengguna (untuk mengedit profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rute untuk Admin (hanya bisa diakses oleh admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', function () {
        return view('admin.dashboard'); // Dashboard khusus admin
    })->name('admin.dashboard');
    
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
});

// Rute untuk Operator (hanya bisa diakses oleh operator)
Route::middleware(['auth', 'role:operator'])->group(function () {
    Route::get('/operator-dashboard', function () {
        return view('operator.dashboard'); // Dashboard khusus operator
    })->name('operator.dashboard');
    
    Route::resource('orders', OrderController::class); // Akses ke pemesanan oleh operator
});

// Rute untuk Owner (hanya bisa diakses oleh owner)
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner-dashboard', function () {
        return view('owner.dashboard'); // Dashboard khusus owner
    })->name('owner.dashboard');
    
    Route::resource('orders', OrderController::class); // Akses pemesanan oleh owner
});

// Rute untuk Client (akses untuk client)
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client-dashboard', function () {
        return view('client.dashboard'); // Dashboard khusus client
    })->name('client.dashboard');
});

// Autentikasi
require __DIR__.'/auth.php';
