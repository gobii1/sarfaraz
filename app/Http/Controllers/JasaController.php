<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk Storage

class JasaController extends Controller
{
    /**
     * Display a listing of the resource for admin.
     */
    public function index()
    {
        // Ambil semua data jasa untuk admin
        $jasas = Jasa::all();

        // Kirim data jasa ke view admin
        return view('admin.jasa.index', compact('jasas'));
    }

    /**
     * Display a listing of the resource for client.
     */
    public function clientIndex()
    {
        // Ambil semua data jasa untuk client
        $jasas = Jasa::all();

        // Kirim data jasa ke view client
        return view('client.jasa.index', compact('jasas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tampilkan form untuk membuat jasa baru
        // Anda mungkin perlu mengirim kategori ke sini jika ada dropdown kategori di form create
        $categories = Category::all(); // Contoh: ambil semua kategori
        return view('admin.jasa.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input termasuk gambar utama dan gambar galeri
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar utama
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar galeri, perhatikan '.*'
        ]);

        // Ambil kategori 'JASA', atau buat jika belum ada
        $category = Category::firstOrCreate(['name' => 'JASA']);

        // Menyimpan gambar utama jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Menyimpan gambar galeri jika ada
        $galleryImagePaths = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $galleryImagePaths[] = $file->store('images', 'public');
            }
        }

        // Menambahkan jasa baru dengan kategori dan gambar-gambar yang sudah ditentukan
        Jasa::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'image' => $imagePath,
            'gallery_images' => $galleryImagePaths, // Simpan array path gambar galeri
            'category_id' => $category->id,
        ]);

        return redirect()->route('admin.jasa.index')->with('success', 'Jasa berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data jasa berdasarkan ID
        $jasa = Jasa::findOrFail($id);
        $categories = Category::all(); // Contoh: ambil semua kategori
        // Tampilkan form untuk mengedit jasa, kirimkan juga kategori
        return view('admin.jasa.edit', compact('jasa', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input termasuk gambar utama dan gambar galeri
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar utama
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Gambar galeri
        ]);

        $jasa = Jasa::findOrFail($id);
        $category = Category::firstOrCreate(['name' => 'JASA']);

        // Mengelola gambar utama
        $imagePath = $jasa->image; // Default: pakai gambar lama
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($jasa->image) {
                Storage::delete('public/' . $jasa->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // Mengelola gambar galeri
        $currentGalleryImages = $jasa->gallery_images ?: []; // Ambil gambar galeri yang sudah ada
        $newGalleryImagePaths = [];

        // Hapus gambar galeri lama yang tidak ada di request (jika ada input untuk menghapus)
        // Untuk saat ini, kita hanya akan menambahkan yang baru. Implementasi penghapusan akan lebih kompleks
        // Jika Anda ingin fungsionalitas hapus per gambar, kita bisa bahas itu nanti.

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $newGalleryImagePaths[] = $file->store('images', 'public');
            }
        }
        
        // Gabungkan gambar galeri lama dengan yang baru
        // Jika Anda ingin mengganti total, cukup gunakan $newGalleryImagePaths.
        // Jika ingin menambah, gunakan array_merge.
        $finalGalleryImages = array_merge($currentGalleryImages, $newGalleryImagePaths);
        // Anda mungkin ingin menambahkan logika untuk menghindari duplikasi atau membatasi jumlah gambar

        // Update data jasa dengan gambar-gambar yang sudah ditentukan
        $jasa->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'category_id' => $category->id,
            'image' => $imagePath,
            'gallery_images' => $finalGalleryImages, // Simpan array path gambar galeri
        ]);

        return redirect()->route('admin.jasa.index')->with('success', 'Jasa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cari jasa berdasarkan ID
        $jasa = Jasa::findOrFail($id);

        // Hapus gambar utama dari storage jika ada
        if ($jasa->image) {
            Storage::delete('public/' . $jasa->image);
        }

        // Hapus gambar galeri dari storage jika ada
        if ($jasa->gallery_images) {
            foreach ($jasa->gallery_images as $galleryImage) {
                Storage::delete('public/' . $galleryImage);
            }
        }

        // Hapus jasa dari database
        $jasa->delete();

        return redirect()->route('admin.jasa.index')->with('success', 'Jasa berhasil dihapus.');
    }

    /**
     * Show the details of a jasa for client.
     */
    public function show($id)
    {
        // Ambil data jasa berdasarkan ID
        $jasa = Jasa::findOrFail($id);
        
        // Ambil jasa terkait untuk sidebar
        $relatedJasas = Jasa::where('id', '!=', $id)->take(5)->get();
        
        // Tampilkan view dengan data jasa
        return view('client.jasa.show', compact('jasa', 'relatedJasas'));
    }
}