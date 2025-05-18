<?php

// app/Models/Jasa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jasa extends Model
{
    use HasFactory;

   protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'category_id',
        'image',  // Tambahkan 'image' ke dalam $fillable
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
