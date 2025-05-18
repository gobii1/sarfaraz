<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Inside your AdminController

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

public function dashboard()
{
    // Calculate total revenue (sum of all orders' total price)
    $totalRevenue = Order::sum('price');

    // Calculate total expense (this might come from another model or calculation)
    $totalExpense = 20000; // Example static value, replace with actual logic

    // Calculate total products
    $totalProducts = Product::count();

    // Calculate total customers
    $totalCustomers = User::where('role', 'client')->count();

    // Calculate total orders
    $totalOrders = Order::count();

    // Pass data to the view
    return view('admin.dashboard', compact('totalRevenue', 'totalExpense', 'totalProducts', 'totalCustomers', 'totalOrders'));
}

}
