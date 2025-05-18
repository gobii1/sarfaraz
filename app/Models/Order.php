<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'status', 
        'total_price',
        'address',
    ];

    // Relasi dengan OrderItem
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mengatur status order
    public function setStatus($status)
    {
        $this->status = $status;
        $this->save();
    }

    // Menghitung total harga pesanan
    public function calculateTotalPrice()
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->price * $item->quantity;
        }
        $this->total_price = $total;
        $this->save();
    }
}
