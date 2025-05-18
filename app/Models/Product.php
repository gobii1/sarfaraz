<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Menambahkan kolom yang bisa diisi dengan mass assignment
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
    ];

    // Relasi dengan Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
