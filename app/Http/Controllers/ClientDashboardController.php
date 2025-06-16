<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Jasa; // <-- Pastikan ini ada
use App\Models\User;
use Illuminate\Http\Request;

class ClientDashboardController extends Controller
{
    public function index()
    {
        // Ambil statistik (jika ada dan relevan untuk dashboard)
        $totalOrders = Order::where('user_id', auth()->id())->count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'client')->count();
        
        // Ambil data produk (jika ada dan relevan untuk dashboard)
        $products = Product::all();
        
        // --- START PERUBAHAN DI SINI ---
        // Ambil data jasa untuk dropdown di form kontak
        $jasas = Jasa::all(); // <-- Ini akan mengambil semua jasa
        // --- END PERUBAHAN ---
        
        // Kirim semua data ke view
        return view('client.dashboard', compact(
            'totalOrders', 
            'totalProducts', 
            'totalCustomers',
            'products',
            'jasas' // <-- Pastikan 'jasas' ada di sini
        ));
    }
}