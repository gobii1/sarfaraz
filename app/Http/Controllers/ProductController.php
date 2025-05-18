<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

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
        // Ambil semua kategori untuk ditampilkan di dropdown (tapi tidak perlu ditampilkan untuk kategori 'PRODUCTS')
        $categories = Category::all();

        // Tampilkan form untuk menambah produk
        return view('admin.products.create', compact('categories'));
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
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        // Ambil kategori 'PRODUCTS', atau buat jika belum ada
        $category = Category::firstOrCreate(['name' => 'PRODUCTS']);

        // Menyimpan gambar
        $imagePath = $request->file('image')->store('images', 'public');

        // Membuat produk baru
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath, // Menyimpan path gambar
            'category_id' => $category->id,  // Set category_id otomatis ke 'PRODUCTS'
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
        $categories = Category::all(); // Ambil semua kategori

        // Tampilkan form edit produk
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar opsional
        ]);

        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Ambil kategori 'PRODUCTS' atau buat jika belum ada
        $category = Category::firstOrCreate(['name' => 'PRODUCTS']);

        // Update data produk
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $category->id;  // Pastikan kategori 'PRODUCTS'

        // Jika ada gambar baru, simpan gambar dan update path-nya
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image = $imagePath;
        }

        // Simpan perubahan
        $product->save();

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
            \Storage::delete('public/' . $product->image);
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
