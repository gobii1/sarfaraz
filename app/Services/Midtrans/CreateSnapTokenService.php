<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config as LaravelConfig; // Alias untuk Config Laravel
use Midtrans\Config; // Pastikan Midtrans\Config diimport

class CreateSnapTokenService extends Midtrans
{
    protected $order;

    public function __construct($order)
    {
        parent::__construct(); // Panggil constructor parent (Midtrans.php)

        // ====================================================================
        // HACK UNTUK MEMAKSA SERVER KEY AGAR DIANGGAP BENAR DI FASE GENERATE TOKEN
        // Ini mengatasi masalah strlen yang aneh di lingkungan Anda untuk Config::$serverKey
        // ====================================================================
        $serverKeyCorrectBytes = hex2bin('53422d4d69642d7365727665722d59524a6272706731465f2d454b565a41554343554f484e52');
        Config::$serverKey = $serverKeyCorrectBytes; // Timpa dengan versi byte yang kita tahu benar
        
        // Pastikan konfigurasi Midtrans lainnya juga diambil dengan benar
        Config::$isProduction = LaravelConfig::get('midtrans.isProduction'); // Ambil dari config/midtrans.php
        Config::$isSanitized = LaravelConfig::get('midtrans.isSanitized', true);
        Config::$is3ds = LaravelConfig::get('midtrans.is3ds', true);
        // ====================================================================

        $this->order = $order;
    }

    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => $this->order->id,
                'gross_amount' => $this->order->total_price,
            ],
            'customer_details' => [
                'first_name' => $this->order->user->name,
                'email' => $this->order->user->email,
                'phone' => $this->order->user->phone ?? '081234567890',
            ],
            'callbacks' => [
                'finish' => LaravelConfig::get('app.url') . '/orders/' . $this->order->id . '?status=success',
                'error' => LaravelConfig::get('app.url') . '/orders/' . $this->order->id . '?status=error',
                'pending' => LaravelConfig::get('app.url') . '/orders/' . $this->order->id . '?status=pending',
            ],
            // 'item_details' => $this->getItemDetails(), // Uncomment jika Anda punya method ini
        ];

        Log::info('Midtrans Snap Params:', $params); // Log ini akan menunjukkan params lengkap, termasuk callbacks

        try {
            $snapToken = Snap::getSnapToken($params); 
            Log::info('Snap Token generated for order ' . $this->order->id . ': ' . $snapToken);
            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Failed to get Snap Token for order ' . $this->order->id . ': ' . $e->getMessage());
            Log::error('Stack trace (CreateSnapTokenService): ' . $e->getTraceAsString()); // Tambahkan stack trace
            throw $e; // Re-throw the exception to be caught in OrderController
        }
    }

    // Jika Anda memiliki method getItemDetails() di sini, biarkan saja.
    // protected function getItemDetails()
    // {
    //     $items = [];
    //     foreach ($this->order->orderItems as $item) {
    //         $items[] = [
    //             'id' => $item->product->id,
    //             'price' => $item->price,
    //             'quantity' => $item->quantity,
    //             'name' => $item->product->name,
    //         ];
    //     }
    //     return $items;
    // }
}