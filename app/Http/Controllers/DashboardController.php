<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Jasa;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Data yang sudah Anda miliki ---
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'client')->count();
        $latestOrders = Order::with('user')->latest()->take(5)->get();

        // --- Data Jasa & Inquiry ---
        $totalJasa = Jasa::count();
        $newInquiriesCount = Inquiry::where('is_read', false)->count();
        $latestInquiries = Inquiry::with('jasa')->latest()->take(5)->get();

        // <<< INI DIA PERBAIKANNYA >>>
        // Tambahkan baris ini untuk menghitung total semua pesanan
        $totalOrders = Order::count();

        // Kirim semua data (termasuk variabel baru) ke view
        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalProducts',
            'totalCustomers',
            'latestOrders',
            'totalJasa',
            'newInquiriesCount',
            'latestInquiries',
            'totalOrders' // <-- Tambahkan variabelnya di sini
        ));
    }
}