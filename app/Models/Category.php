<?php

// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['name'];

    // Menambahkan pembatasan agar hanya kategori yang sudah ada yang bisa digunakan
    public static function getAvailableCategories()
    {
        return ['JASA', 'PRODUCTS'];
    }

    // Mencegah perubahan kategori yang sudah ada
    public static function boot()
    {
        parent::boot();

        // Prevent deletion of default categories
        static::deleting(function ($category) {
            // Hanya izinkan menghapus jika kategori bukan 'JASA' atau 'PRODUCTS'
            if (in_array($category->name, self::getAvailableCategories())) {
                return false;  // Prevent delete
            }
        });
    }
}
