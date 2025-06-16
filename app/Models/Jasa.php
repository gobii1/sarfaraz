<?php

// app/Models/Jasa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jasa extends Model
{
    use HasFactory;

    // Tambahkan 'gallery_images' ke dalam fillable
    protected $fillable = ['nama', 'deskripsi', 'harga', 'category_id', 'image', 'gallery_images'];

    // Tambahkan casting untuk 'gallery_images' sebagai array
    protected $casts = [
        'gallery_images' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}