<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'stock', // Ini sudah benar
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer', // Pastikan 'stock' di-cast ke integer
    ];

    // ... relasi atau method lainnya ...

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}