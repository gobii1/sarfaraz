<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Import Facade View
use App\Models\Inquiry; // Import Model Inquiry

class AppServiceProvider extends ServiceProvider
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
        // --- START PERUBAHAN: Mengirim data ke View ---
        // Memastikan ini hanya berjalan jika aplikasi tidak di-console (misal saat migrasi)
        if (! $this->app->runningInConsole()) {
            View::composer('*', function ($view) {
                // Ambil jumlah inquiry yang belum dibaca
                $unreadInquiriesCount = Inquiry::where('is_read', false)->count();
                // Ambil beberapa inquiry terbaru yang belum dibaca untuk ditampilkan di dropdown
                $latestUnreadInquiries = Inquiry::where('is_read', false)
                                                ->orderBy('created_at', 'desc')
                                                ->take(5) // Ambil 5 terbaru
                                                ->get();

                // Kirim data ini ke semua view
                $view->with('unreadInquiriesCount', $unreadInquiriesCount)
                     ->with('latestUnreadInquiries', $latestUnreadInquiries);
            });
        }
        // --- END PERUBAHAN ---
    }
}