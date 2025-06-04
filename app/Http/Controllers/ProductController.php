<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // Pastikan ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource for admin.
     */
    public function index()
    {
        // Ambil semua produk beserta kategori untuk admin
        $products = Product::with('category')->get();

        // Kirim data produk ke view admin
        return view('admin.products.index', compact('products'));
    }

    /**
     * Display a listing of the resource for client.
     */
    public function clientIndex(Request $request)
    {
        // Paginasi produk dengan 10 produk per halaman (misalnya)
        $products = Product::paginate(10);  // Paginasi produk

        // Kirim data produk ke view client
        return view('client.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Karena category_id akan otomatis 'PRODUCTS', tidak perlu mengirimkan $categories ke view create.
        // Anda bisa hapus baris di bawah ini atau biarkan saja jika Anda ingin memanfaatkannya di tempat lain.
        // $categories = Category::all();

        // Tampilkan form untuk menambah produk
        return view('admin.products.create'); // Tidak perlu compact('categories') lagi
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // --- UBAH: category_id tidak lagi divalidasi dari request, karena akan diset otomatis ---
            // 'category_id' => 'required|exists:categories,id', // BARIS INI DIHAPUS/DIKOMENTARI
            'stock' => 'required|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Membuat produk baru
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'stock' => $request->stock,
            // --- BARU: Set category_id secara otomatis ke 2 (ID untuk 'PRODUCTS') ---
            'category_id' => 2, // Ganti dengan ID kategori 'PRODUCTS' yang sesuai di database Anda
        ]);

        // Redirect ke halaman produk
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Ambil data produk berdasarkan ID
        $product = Product::with('category')->findOrFail($id);

        // Tampilkan produk
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ambil data produk berdasarkan ID
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Ambil semua kategori (TETAP ADA UNTUK FORM EDIT)

        // Tampilkan form edit produk
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input (category_id TETAP ADA UNTUK UPDATE)
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id', // TETAP ADA UNTUK UPDATE
            'stock' => 'required|integer|min:0',
        ]);

        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari storage jika ada
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Update data produk
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'category_id' => $request->category_id,  // Mengambil category_id dari form (TETAP UNTUK UPDATE)
            'stock' => $request->stock,
        ]);

        // Redirect ke halaman produk
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus produk dari database
        $product->delete();

        // Redirect ke halaman produk
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Show the details of a product for client.
     */
    public function clientShow($id)
    {
        // Ambil detail produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Tampilkan detail produk untuk client
        return view('client.products.show', compact('product'));
    }
}