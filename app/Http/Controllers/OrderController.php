<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            // Client hanya bisa melihat pesanan mereka sendiri
            $orders = Order::where('user_id', auth()->id())->get();
        }

        return view('client.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource (Checkout).
     */
    public function checkout()
    {
        // Mengambil item cart milik pengguna yang sedang login
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('client.cart.index')->with('error', 'Keranjang Anda kosong! Tidak bisa melanjutkan ke checkout.');
        }

        // Menghitung total harga
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->price * $cartItem->quantity;
        });

        return view('client.checkout.index', compact('cartItems', 'totalPrice'));
    }

    /**
     * Store a newly created order (Handle the checkout process).
     */
            public function store(Request $request)
{
    // Hapus validasi address jika memang tidak diperlukan
    // $request->validate([
    //     'address' => 'required|string|max:255',
    // ]);

    // Mulai transaksi untuk menjaga integritas data
    DB::beginTransaction();
    try {
        // Membuat order baru
        $order = Order::create([
            'user_id' => Auth::id(),
            // 'address' => $request->address, // Hapus jika tidak diperlukan
            'total_price' => 0, // Total harga akan dihitung nanti
            'status' => 'pending', // Tambahkan status default
        ]);

        // Ambil item cart milik pengguna
        $cartItems = Cart::where('user_id', Auth::id())->get();
        $totalPrice = 0;

        foreach ($cartItems as $cartItem) {
            // Jika kamu tidak memiliki model OrderItem, gunakan cara lain untuk menyimpan detail order
            // Misalnya, tambahkan kolom product_details di tabel orders sebagai JSON
            
            // Menghitung total harga
            $totalPrice += $cartItem->price * $cartItem->quantity;
            
            // Hapus item cart setelah pesanan dibuat
            $cartItem->delete();
        }

        // Update total harga pada order
        $order->total_price = $totalPrice;
        $order->save();
        
        // Commit transaksi
        DB::commit();
        
        // Redirect ke halaman order dengan pesan sukses
        return redirect()->route('orders.show', $order->id)->with('success', 'Pemesanan berhasil!');
    } catch (\Exception $e) {
        // Rollback jika ada error
        DB::rollBack();
        
        // Log error untuk debugging
        \Log::error('Checkout error: ' . $e->getMessage());
        
        return redirect()->route('client.cart.index')->with('error', 'Terjadi kesalahan, pesanan gagal dibuat: ' . $e->getMessage());
    }
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
