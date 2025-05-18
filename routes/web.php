<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

/*
|---------------------------------------------------------------------- 
| Web Routes
|---------------------------------------------------------------------- 
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them 
| will be assigned to the "web" middleware group. Make something great!
*/

// Route untuk halaman welcome (landing page)
Route::get('/', function () {
    return view('welcome');
});

// Route untuk halaman contact yang tidak memerlukan autentikasi
Route::get('/contact', function() {
    return view('client.contact');
})->name('contact');

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
    
    // Rute untuk produk
    Route::resource('admin/products', ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    
    // Rute untuk kategori
    Route::resource('categories', CategoryController::class);
    
    // Rute untuk jasa
    Route::resource('admin/jasa', JasaController::class)->names([
        'index' => 'admin.jasa.index',
        'create' => 'admin.jasa.create',
        'store' => 'admin.jasa.store',
        'show' => 'admin.jasa.show',
        'edit' => 'admin.jasa.edit',
        'update' => 'admin.jasa.update',
        'destroy' => 'admin.jasa.destroy',
    ]);
    
    // Rute untuk order
    Route::resource('admin/orders', OrderController::class)->names([
        'index' => 'admin.orders.index',
        'show' => 'admin.orders.show',
        'edit' => 'admin.orders.edit',
        'update' => 'admin.orders.update',
    ]);
});

// Rute untuk Client (akses untuk client dan admin)
Route::middleware(['auth', 'role:client,admin'])->group(function () {
    Route::get('/client-dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
    
    // Rute untuk produk client
    Route::get('/products', [ProductController::class, 'clientIndex'])->name('products.index');
    Route::get('/products/{id}', [ProductController::class, 'clientShow'])->name('products.show');
    Route::get('/products/ajax/{product}', [ProductController::class, 'ajaxShow'])->name('products.ajax.show');
    
    // Jasa untuk client
    Route::get('/jasa', [JasaController::class, 'clientIndex'])->name('jasa.index');
    Route::get('/jasa/{id}', [JasaController::class, 'show'])->name('jasa.show');

    // Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('client.cart.index');
    Route::post('/cart', [CartController::class, 'add'])->name('cart.add');
    Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Route untuk Checkout - PERBAIKAN DISINI
    Route::get('checkout', [OrderController::class, 'checkout'])->name('client.cart.checkout');
Route::post('checkout', [OrderController::class, 'store'])->name('client.orders.store'); // Ubah nama route ini // Ubah nama route ini
    
    // Pesanan client
    Route::get('/orders', [OrderController::class, 'clientIndex'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::patch('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    
    // Rute untuk mengubah status pesanan
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update.status');
    
    // Halaman About
    Route::get('/about', function() {
        return view('client.about');
    })->name('client.about');

    // Checkout routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});
});

// Autentikasi
require __DIR__.'/auth.php';
