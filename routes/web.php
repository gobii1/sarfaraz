<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Publik
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/contact', function () {
    return view('client.contact');
})->name('contact');

Route::post('/midtrans/callback', [MidtransCallbackController::class, 'receive'])->name('midtrans.callback');
Route::post('/submit-inquiry', [ContactController::class, 'submit'])->name('inquiry.submit');

// Rute Redirect setelah Login
Route::get('/dashboard', function () {
    if (auth()->user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    }
    // Tambahkan redirect untuk operator dan owner di sini jika perlu
    if (auth()->user()->role == 'operator') {
        // Asumsi nama rute untuk operator dashboard
        return redirect()->route('operator.dashboard'); 
    }
    return redirect()->route('client.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ======================================================================
// --- RUTE-ROUTE UNTUK PENGGUNA YANG SUDAH LOGIN (CLIENT) ---
// ======================================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/client/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/products', [ProductController::class, 'clientIndex'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'clientShow'])->name('products.show');
    Route::get('/products/ajax/{product}', [ProductController::class, 'ajaxShow'])->name('products.ajax.show');

    Route::get('/jasa', [JasaController::class, 'clientIndex'])->name('jasa.index');
    Route::get('/jasa/{id}', [JasaController::class, 'show'])->name('jasa.show');

    Route::get('/cart', [CartController::class, 'index'])->name('client.cart.index');
    Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('client.cart.checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('client.orders.store');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('/about', function () {
        return view('client.about');
    })->name('about');
});


// ======================================================================
// --- RUTE-ROUTE KHUSUS UNTUK ADMIN ---
// ======================================================================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('orders', OrderController::class)->except(['create', 'store']);
    Route::resource('products', ProductController::class);
    Route::resource('jasa', JasaController::class);
    Route::resource('categories', CategoryController::class);

    // ================================================================
    // PERBAIKAN: MENAMBAHKAN KEMBALI RUTE INQUIRIES YANG HILANG
    // ================================================================
    Route::get('/inquiries', [ContactController::class, 'adminIndex'])->name('inquiries.index');
    Route::post('/inquiries/{id}/read', [ContactController::class, 'markAsRead'])->name('inquiries.markAsRead');
    Route::delete('/inquiries/{id}', [ContactController::class, 'destroy'])->name('inquiries.destroy');
});

// File rute untuk otentikasi
require __DIR__.'/auth.php';