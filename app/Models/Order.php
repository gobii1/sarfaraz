<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini jika belum ada
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Tambahkan ini
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini jika belum ada

class Order extends Model
{
    use HasFactory; // Tambahkan ini jika belum ada

    protected $fillable = [
        'user_id',
        'user_order_id',
        'total_price',
        'status',
        'payment_status',
        'snap_token',
        'midtrans_transaction_id', // Pastikan kolom ini ada di database dan ditambahkan di fillable
    ];

    /**
     * Get the user that owns the Order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items for the order.
     * Ini adalah relasi yang hilang yang menyebabkan error Anda.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


    // Helper methods Anda yang sudah ada
    public function needsPayment()
    {
        return $this->payment_status === 'pending';
    }

    public function isPaid()
    {
        return in_array($this->payment_status, ['settlement', 'capture']);
    }

    public function isPaymentFailed()
    {
        return in_array($this->payment_status, ['cancel', 'expire', 'deny']);
    }

    public function getStatusBadgeColor()
    {
        return match($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    public function getPaymentStatusBadgeColor()
    {
        return match($this->payment_status) {
            'pending' => 'warning',
            'settlement', 'capture' => 'success',
            'cancel', 'expire', 'deny' => 'danger',
            default => 'secondary'
        };
    }

    public function getStatusText()
    {
        return match($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'processing' => 'Sedang Diproses',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Unknown'
        };
    }

    public function getPaymentStatusText()
    {
        return match($this->payment_status) {
            'pending' => 'Menunggu Pembayaran',
            'settlement' => 'Pembayaran Berhasil',
            'capture' => 'Pembayaran Berhasil',
            'cancel' => 'Pembayaran Dibatalkan',
            'expire' => 'Pembayaran Kadaluarsa',
            'deny' => 'Pembayaran Ditolak',
            default => 'Unknown'
        };
    }
}