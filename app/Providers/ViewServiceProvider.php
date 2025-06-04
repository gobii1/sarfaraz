<?php

namespace App\Providers;

use App\Models\Cart; // Pastikan model Cart diimport
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // --- UBAH DI SINI: Targetkan langsung 'layouts.partials.header' ---
        View::composer('layouts.partials.header', function ($view) {
            $cartCount = 0;
            if (Auth::check()) {
                // Asumsi: Model Cart menyimpan item keranjang, dan punya kolom 'quantity'
                $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            }
            $view->with('cartCount', $cartCount);
        });
        // --- AKHIR UBAH ---

        // Hapus atau komen kode View::composer lain yang menargetkan 'layouts.layout'
        // jika Anda tidak ingin mengirim $cartCount ke layout utama secara spesifik.
        // Atau biarkan jika layout utama juga butuh $cartCount.
    }
}