<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Jasa;
use App\Models\User;
use Illuminate\Http\Request;

class ClientDashboardController extends Controller
{
    public function index()
    {
        // Ambil statistik
        $totalOrders = Order::where('user_id', auth()->id())->count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'client')->count();
        
        // Ambil data produk
        $products = Product::all();
        
        // Ambil data jasa
        $jasas = Jasa::all();
        
        // Kirim semua data ke view
        return view('client.dashboard', compact(
            'totalOrders', 
            'totalProducts', 
            'totalCustomers',
            'products',
            'jasas'
        ));
    }
}
