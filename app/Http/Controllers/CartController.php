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
        
        // Cek apakah produk sudah ada di cart
        $existingItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();
        
        if ($existingItem) {
            // Update quantity jika produk sudah ada
            $existingItem->quantity += $request->quantity;
            $existingItem->save();
        } else {
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
    
    public function remove($id)
    {
        $cartItem = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $cartItem->delete();
        
        return redirect()->route('client.cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
    
    // Metode untuk update quantity
            public function update(Request $request)
{
    // Validasi input
    $request->validate([
        'id' => 'required|exists:carts,id', // Ubah dari cart_id menjadi id
        'quantity' => 'required|integer|min:1',
    ]);

    // Temukan item cart berdasarkan id dan user_id
    $cartItem = Cart::where('id', $request->id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    // Update quantity
    $cartItem->quantity = $request->quantity;
    $cartItem->save();

    // Return JSON response untuk AJAX
    return response()->json(['success' => true]);
}



public function checkout()
{
    $cartItems = Cart::where('user_id', Auth::id())
                     ->with('product')
                     ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('client.cart.index')->with('error', 'Keranjang Anda kosong! Tidak bisa melanjutkan ke checkout.');
    }

    // Logika checkout lainnya, misalnya memilih metode pembayaran, alamat pengiriman, dll.
    return view('client.checkout.index', compact('cartItems'));
}


}
