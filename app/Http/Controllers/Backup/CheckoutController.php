<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Midtrans\CreateSnapTokenService;
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
        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('client.cart.index')
                ->with('error', 'Keranjang belanja kosong');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Proses checkout dan buat Snap Token Midtrans
     */
    public function process(Request $request)
    {
        DB::beginTransaction();

        try {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product')
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('client.cart.index')
                    ->with('error', 'Keranjang belanja kosong');
            }

            // Validasi stok produk (jika ada field stock)
            foreach ($cartItems as $item) {
                $product = Product::find($item->product_id);

                if (!$product) {
                    return redirect()->back()->with('error', 'Produk tidak tersedia');
                }

                // if ($product->stock < $item->quantity) {
                //     return redirect()->back()->with('error', "Stok {$product->name} tidak mencukupi");
                // }
            }

            $total = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            // Buat order baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'payment_status' => 'pending',
                'total_price' => $total,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                // Kurangi stok jika perlu
                // $product->stock -= $item->quantity;
                // $product->save();
            }

            // Kosongkan keranjang
            Cart::where('user_id', Auth::id())->delete();

            // Generate Snap Token Midtrans
            $midtrans = new CreateSnapTokenService($order);
            $snapToken = $midtrans->getSnapToken();

            // Simpan Snap Token ke database (opsional)
            $order->snap_token = $snapToken;
            $order->save();

            DB::commit();

            // Redirect ke halaman detail order
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat!')
                ->with('snap_token', $snapToken);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat checkout. Silakan coba lagi.');
        }
    }
}
