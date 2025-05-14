<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            // Admin bisa melihat semua pemesanan
            $orders = Order::all();
        } else {
            // Client hanya bisa melihat pemesanannya sendiri
            $orders = Order::where('user_id', auth()->id())->get();
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan daftar produk yang bisa dipesan
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'total_price' => 'required|numeric',
        ]);

        // Membuat pemesanan baru
        $order = Order::create([
            'user_id' => auth()->id(), // ID pengguna (client)
            'product_id' => $request->product_id,
            'total_price' => $request->total_price,
            'status' => 'pending', // Status awal pemesanan
        ]);

        // Kirim notifikasi ke Owner setelah pemesanan dibuat
        $owner = User::where('role', 'owner')->first();
        $owner->notify(new OrderStatusUpdated($order));

        return redirect()->route('orders.index')->with('success', 'Pemesanan berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::findOrFail($id);

        // Pastikan client hanya bisa melihat pesanan mereka sendiri
        if (auth()->user()->role == 'client' && $order->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::findOrFail($id);

        // Pastikan hanya admin yang bisa mengedit status pemesanan
        if (auth()->user()->role != 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        // Validasi status
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        // Mengubah status pemesanan
        $order->status = $request->status;
        $order->save();

        // Kirim notifikasi kepada Owner dan Client setelah status berubah
        $owner = User::where('role', 'owner')->first();
        $owner->notify(new OrderStatusUpdated($order)); // Notifikasi ke owner

        $order->user->notify(new OrderStatusUpdated($order)); // Notifikasi ke client

        return redirect()->route('orders.index')->with('success', 'Status pemesanan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        // Pastikan hanya admin yang bisa menghapus pemesanan
        if (auth()->user()->role != 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Pemesanan berhasil dihapus');
    }
}
