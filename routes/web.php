<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\MidtransCallbackController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Landing Page
Route::get('/', function () {
    return view('welcome');
});

// 📞 Contact Page (tanpa login)
Route::get('/contact', function () {
    return view('client.contact');
})->name('contact');

// 📬 MIDTRANS CALLBACK — Jangan di-protect middleware (PENTING!)
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'receive'])->name('midtrans.callback');

// 🧭 Redirect Dashboard berdasarkan Role (setelah login)
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

    return redirect()->route('client.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 👤 Profile (untuk semua user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 🛠️ Admin Routes - HANYA UNTUK ROLE ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard'); // names 'admin.dashboard'

    // Manajemen Produk (Admin)
    Route::resource('products', ProductController::class)->names([
        'index'   => 'products.index',
        'create'  => 'products.create',
        'store'   => 'products.store',
        'show'    => 'products.show',
        'edit'    => 'products.edit',
        'update'  => 'products.update',
        'destroy' => 'products.destroy',
    ]);

    // Manajemen Kategori (Admin) - Sesuaikan jika ini juga harus punya prefix admin
    Route::resource('categories', CategoryController::class); // names 'categories.index', etc.

    // Manajemen Jasa (Admin)
    Route::resource('jasa', JasaController::class)->names([
        'index'   => 'jasa.index',
        'create'  => 'jasa.create',
        'store'   => 'jasa.store',
        'show'    => 'jasa.show',
        'edit'    => 'jasa.edit',
        'update'  => 'jasa.update',
        'destroy' => 'jasa.destroy',
    ]);

    // Manajemen Pesanan (Admin) - Ini akan mencakup edit, update, destroy
    Route::resource('orders', OrderController::class)->except(['create', 'store']); // Order dibuat oleh client, tidak oleh admin

    // Rute tambahan untuk update status order oleh admin (jika ingin terpisah dari resource update)
    // Method updateStatus() di OrderController Anda punya cek role 'admin', jadi cocok di sini.
    Route::patch('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update.status');
});

// 🧑‍💼 Client Routes - Untuk Client dan juga Admin (jika admin ingin akses tampilan client)
Route::middleware(['auth', 'role:client,admin'])->group(function () {
    // Dashboard Client
    Route::get('/client-dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');

    // Produk (Client)
    Route::get('/products', [ProductController::class, 'clientIndex'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'clientShow'])->name('products.show');
    // Jika Anda menggunakan AJAX untuk quick view produk, pastikan path-nya benar
    Route::get('/products/ajax/{product}', [ProductController::class, 'ajaxShow'])->name('products.ajax.show');

    // Jasa (Client)
    Route::get('/jasa', [JasaController::class, 'clientIndex'])->name('jasa.index');
    Route::get('/jasa/{id}', [JasaController::class, 'show'])->name('jasa.show');

    // Keranjang (Client)
    Route::get('/cart', [CartController::class, 'index'])->name('client.cart.index');
    Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout & Order (Client)
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('client.cart.checkout'); // Tampilkan form checkout
    Route::post('/checkout', [OrderController::class, 'store'])->name('client.orders.store');  // Proses checkout

    // Pesanan Client - HANYA VIEWING (index dan show)
    // Edit, update, destroy, updateStatus order oleh client TIDAK disarankan.
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index'); // Daftar pesanan user
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show'); // Detail pesanan user

    // --- DIHAPUS DARI GROUP CLIENT: Rute edit, update, dan destroy order oleh client
    // Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    // Route::patch('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    // Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    // Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update.status'); // Pindah ke admin group

    // Tentang (Client)
    Route::get('/about', function () {
        return view('client.about');
    })->name('client.about');
});

// 🔐 Auth routes (dari Breeze/Jetstream)
require __DIR__ . '/auth.php';