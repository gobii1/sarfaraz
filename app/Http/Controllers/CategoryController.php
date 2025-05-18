<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan daftar kategori (JASA, PRODUCTS)
    public function index()
    {
        // Ambil hanya kategori yang sudah ada, yaitu 'JASA' dan 'PRODUCTS'
        $categories = Category::whereIn('name', Category::getAvailableCategories())->get();
        return view('categories.index', compact('categories'));
    }

    // Menampilkan kategori tidak perlu menambah kategori baru, hanya tampilkan kategori yang ada
    public function create()
    {
        return redirect()->route('categories.index'); // Redirect ke daftar kategori
    }

    // Tidak perlu menambah atau mengupdate kategori karena sudah statis
    public function store(Request $request)
    {
        return redirect()->route('categories.index'); // Redirect ke daftar kategori
    }

    // Tidak ada perubahan pada kategori
    public function edit(Category $category)
    {
        return redirect()->route('categories.index'); // Redirect ke daftar kategori
    }

    // Tidak ada update pada kategori
    public function update(Request $request, Category $category)
    {
        return redirect()->route('categories.index'); // Redirect ke daftar kategori
    }

    // Hanya bisa menghapus kategori jika itu bukan 'JASA' atau 'PRODUCTS'
    public function destroy(Category $category)
    {
        if (in_array($category->name, Category::getAvailableCategories())) {
            return redirect()->route('categories.index')->with('error', 'You cannot delete the default categories.');
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
