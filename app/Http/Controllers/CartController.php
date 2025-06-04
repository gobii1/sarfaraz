<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $cartItems = Cart::where('user_id', Auth::id())
                          ->with('product')
                          ->when($search, function ($query) use ($search) {
                              return $query->whereHas('product', function ($query) use ($search) {
                                  $query->where('name', 'like', "%{$search}%");
                              });
                          })
                          ->get();

        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        return view('client.cart.index', compact('cartItems', 'totalPrice'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // --- VALIDASI STOK SAAT ADD KE KERANJANG ---
        if ($product->stock === 0) {
            return redirect()->back()->with('error', 'Stok produk "' . $product->name . '" sedang habis.');
        }

        // Cek apakah produk sudah ada di cart
        $existingItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $request->quantity;

            // --- VALIDASI STOK SAAT UPDATE QUANTITY DI KERANJANG (jika produk sudah ada) ---
            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', 'Jumlah produk "' . $product->name . '" di keranjang melebihi stok yang tersedia (' . $product->stock . ').');
            }

            // Update quantity jika produk sudah ada
            $existingItem->quantity = $newQuantity;
            $existingItem->save();
        } else {
            // --- VALIDASI STOK SAAT TAMBAH BARU KE KERANJANG (jika produk belum ada) ---
            if ($request->quantity > $product->stock) {
                return redirect()->back()->with('error', 'Jumlah produk "' . $product->name . '" yang diminta melebihi stok yang tersedia (' . $product->stock . ').');
            }

            // Tambahkan produk baru ke cart
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'price' => $product->price,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // --- METHOD UPDATE CART (jika Anda memiliki rute untuk update quantity langsung dari keranjang) ---
    // Saya lengkapi bagian ini, asumsi Anda memiliki method update untuk mengubah kuantitas item cart.
    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:0', // Min 0 agar bisa set quantity ke 0 untuk menghapus
        ]);

        $cartItem = Cart::where('id', $request->cart_item_id)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        $product = Product::findOrFail($cartItem->product_id);

        if ($request->quantity === 0) {
            // Jika quantity 0, hapus item dari cart
            $cartItem->delete();
            return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        // --- VALIDASI STOK SAAT UPDATE KUANTITAS ITEM KERANJANG ---
        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'Jumlah produk "' . $product->name . '" yang diminta melebihi stok yang tersedia (' . $product->stock . ').');
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'Kuantitas produk berhasil diperbarui.');
    }


    public function remove($id)
    {
        $cartItem = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->delete();

        return redirect()->route('client.cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}