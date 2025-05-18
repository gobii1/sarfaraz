<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use App\Models\Category;
use Illuminate\Http\Request;

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
        return view('admin.jasa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi input termasuk gambar
    $request->validate([
        'nama' => 'required',
        'deskripsi' => 'required',
        'harga' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
    ]);

    // Ambil kategori 'JASA', atau buat jika belum ada
    $category = Category::firstOrCreate(['name' => 'JASA']);

    // Menyimpan gambar jika ada
    $imagePath = null;
    if ($request->hasFile('image')) {
        // Simpan gambar dengan nama unik
        $imagePath = $request->file('image')->storeAs('images', time().'_'.$request->file('image')->getClientOriginalName(), 'public');
    }

    // Menambahkan jasa baru dengan kategori yang sudah ditentukan
    Jasa::create([
        'nama' => $request->nama,
        'deskripsi' => $request->deskripsi,
        'harga' => $request->harga,
        'image' => $imagePath,  // Menyimpan path gambar
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

        // Tampilkan form untuk mengedit jasa
        return view('admin.jasa.edit', compact('jasa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input termasuk gambar
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        $jasa = Jasa::findOrFail($id);
        $category = Category::firstOrCreate(['name' => 'JASA']);

        // Menyimpan gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($jasa->image) {
                \Storage::delete('public/' . $jasa->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            $imagePath = $jasa->image; // Jika tidak ada gambar baru, pakai gambar lama
        }

        // Update data jasa dengan gambar baru atau gambar lama
        $jasa->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'category_id' => $category->id,
            'image' => $imagePath,  // Menyimpan path gambar
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

        // Hapus gambar dari storage jika ada
        if ($jasa->image) {
            \Storage::delete('public/' . $jasa->image);
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
