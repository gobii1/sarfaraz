<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config; // Pastikan Midtrans\Config diimport
use Midtrans\Notification; // Pastikan Midtrans\Notification diimport jika Anda menggunakannya di luar try-catch

class MidtransCallbackController extends Controller
{
    public function receive(Request $request)
    {
        Log::info('=== MIDTRANS CALLBACK RECEIVED ===');
        Log::info('Request data: ' . json_encode($request->all()));

        // ====================================================================
        // SET KONFIGURASI UNTUK MIDTRANS SDK
        // (Tetap ambil dari config/midtrans.php untuk isProduction, dll.)
        // ====================================================================
        Config::$isProduction = config('midtrans.isProduction'); // Ambil dari config/midtrans.php
        Config::$isSanitized = config('midtrans.isSanitized', true); // Pastikan ini juga diambil dari config jika ada
        Config::$is3ds = config('midtrans.is3ds', true); // Pastikan ini juga diambil dari config jika ada

        // ====================================================================
        // HACK UNTUK MEMAKSA SERVER KEY AGAR DIANGGAP BENAR
        // Ini mengatasi masalah strlen yang aneh di lingkungan Anda
        // ====================================================================
        $serverKeyCorrectBytes = hex2bin('53422d4d69642d7365727665722d59524a6272706731465f2d454b565a41554343554f484e52');
        
        // Tetapkan server key untuk Midtrans SDK
        Config::$serverKey = $serverKeyCorrectBytes; 
        
        // Gunakan juga untuk variabel lokal yang akan dipakai untuk perhitungan signature
        $serverKey = $serverKeyCorrectBytes; 

        Log::info('DEBUG SERVER KEY LENGTH (FORCED BYTES): ' . strlen($serverKey)); // Ini HARUSNYA 39 sekarang!
        Log::info('DEBUG SERVER KEY RAW (FORCED BYTES): ' . bin2hex($serverKey)); // Ini HARUSNYA sama persis dengan hex awal

        try {
            // Ambil semua data notifikasi dari request
            $notificationData = $request->all();
            
            // Verifikasi signature key
            // Pastikan Anda menggunakan $serverKey (yang sudah kita paksa benar panjangnya)
            // Sesuaikan parameter hash() sesuai dokumentasi Midtrans: order_id + status_code + gross_amount + server_key
            $calculatedSignatureKey = hash('sha512', 
                $notificationData['order_id'] . 
                $notificationData['status_code'] . 
                $notificationData['gross_amount'] . 
                $serverKey
            );
            
            $receivedSignatureKey = $notificationData['signature_key'];

            Log::info('Hash Check - Order ID: ' . $notificationData['order_id']);
            Log::info('Hash Check - Status Code: ' . $notificationData['status_code']);
            Log::info('Hash Check - Gross Amount: ' . $notificationData['gross_amount']);
            Log::info('Hash Check - Server Key (for hash): ' . $serverKey);
            Log::info('Hash Check - Calculated Signature: ' . $calculatedSignatureKey);
            Log::info('Hash Check - Received Signature: ' . $receivedSignatureKey);

            if ($receivedSignatureKey != $calculatedSignatureKey) {
                Log::error('❌ Invalid signature key for order: ' . $notificationData['order_id']);
                Log::error('Calculated: ' . $calculatedSignatureKey);
                Log::error('Received: ' . $receivedSignatureKey);
                return response()->json(['message' => 'Invalid signature key'], 403);
            }

            Log::info('✅ Signature Key Valid for order: ' . $notificationData['order_id']);
            Log::info('➡️ Processing order_id: ' . $notificationData['order_id'] . ', status: ' . $notificationData['transaction_status']);

            $order = Order::find($notificationData['order_id']);

            if (!$order) {
                Log::error('❌ Order not found: ' . $notificationData['order_id']);
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Update status order berdasarkan transaction_status Midtrans
            $transactionStatus = $notificationData['transaction_status'];
            $paymentType = $notificationData['payment_type'];
            $fraudStatus = $notificationData['fraud_status'];

            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $order->status = 'pending';
                        $order->payment_status = 'challenge';
                    } else {
                        $order->status = 'completed';
                        $order->payment_status = 'paid';
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                $order->status = 'completed';
                $order->payment_status = 'paid';
            } elseif ($transactionStatus == 'pending') {
                $order->status = 'pending';
                $order->payment_status = 'pending';
            } elseif ($transactionStatus == 'deny') {
                $order->status = 'cancelled';
                $order->payment_status = 'failed';
            } elseif ($transactionStatus == 'expire') {
                $order->status = 'cancelled';
                $order->payment_status = 'expired';
            } elseif ($transactionStatus == 'cancel') {
                $order->status = 'cancelled';
                $order->payment_status = 'cancelled';
            }

            $order->midtrans_transaction_id = $notificationData['transaction_id'];
            $order->save();
            
            Log::info('✅ Order ' . $order->id . ' status updated to: ' . $order->status . ' and payment status to: ' . $order->payment_status);

            return response()->json(['message' => 'Callback received successfully'], 200);

        } catch (\Exception $e) {
            Log::error('❌ Error processing Midtrans callback: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString()); // Tambahkan stack trace untuk debugging lebih lanjut
            return response()->json(['message' => 'Error processing callback'], 500);
        }
    }
}