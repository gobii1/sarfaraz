<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout
     */
    public function index()
    {
        // Ambil item dari keranjang user yang sedang login
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('client.cart.index')
                ->with('error', 'Keranjang belanja kosong');
        }
        
        // Hitung total harga
        $total = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        
        return view('checkout.index', compact('cartItems', 'total'));
    }
    
    /**
     * Proses checkout
     */
    public function process(Request $request)
    {
        // Mulai transaksi database
        DB::beginTransaction();
        
        try {
            // Ambil item dari keranjang
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('client.cart.index')
                    ->with('error', 'Keranjang belanja kosong');
            }
            
            // Validasi stok produk (jika ada field stock di tabel products)
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);
                
                if (!$product) {
                    return redirect()->back()
                        ->with('error', 'Produk tidak tersedia');
                }
                
                // Uncomment jika ada field stock di tabel products
                // if ($product->stock < $item->quantity) {
                //     return redirect()->back()
                //         ->with('error', "Stok {$product->name} tidak mencukupi");
                // }
            }
            
            // Hitung total
            $total = $cartItems->sum(function($item) {
                return $item->price * $item->quantity;
            });
            
            // Buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'total_price' => $total
            ]);
            
            // Pindahkan item dari keranjang ke order_items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price
                ]);
                
                // Uncomment jika ingin mengurangi stok
                // $product = Product::find($item->product_id);
                // $product->stock -= $item->quantity;
                // $product->save();
            }
            
            // Hapus keranjang setelah checkout
            Cart::where('user_id', Auth::id())->delete();
            
            // Commit transaksi
            DB::commit();
            
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat!');
                
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat checkout. Silakan coba lagi.');
        }
    }
}
