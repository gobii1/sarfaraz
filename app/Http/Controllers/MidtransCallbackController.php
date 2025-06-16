<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Events\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;

class MidtransCallbackController extends Controller
{
    public function receive(Request $request)
    {
        Log::info('=== MIDTRANS CALLBACK RECEIVED ===');
        Log::info('Request data: ' . json_encode($request->all()));

        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized', true);
        Config::$is3ds = config('midtrans.is3ds', true);
        
        // ================================================================
        // MENGEMBALIKAN LOGIKA SERVER KEY ANDA YANG SUDAH BENAR
        // ================================================================
        $serverKeyCorrectBytes = hex2bin('53422d4d69642d7365727665722d59524a6272706731465f2d454b565a41554343554f484e52');
        Config::$serverKey = $serverKeyCorrectBytes; 
        $serverKey = $serverKeyCorrectBytes; 

        try {
            $notificationData = $request->all();
            
            // Validasi signature menggunakan server key dari hex2bin
            $calculatedSignatureKey = hash('sha512', 
                $notificationData['order_id'] . 
                $notificationData['status_code'] . 
                $notificationData['gross_amount'] . 
                $serverKey
            );
            
            if ($notificationData['signature_key'] != $calculatedSignatureKey) {
                Log::error('❌ Invalid signature key for order: ' . $notificationData['order_id']);
                return response()->json(['message' => 'Invalid signature key'], 403);
            }

            Log::info('✅ Signature Key Valid for order: ' . $notificationData['order_id']);
            
            $order = Order::find($notificationData['order_id']);

            if (!$order) {
                Log::error('❌ Order not found: ' . $notificationData['order_id']);
                return response()->json(['message' => 'Order not found'], 404);
            }
            
            if ($order->status == 'completed' || $order->status == 'cancelled') {
                Log::info('Order ' . $order->id . ' already has a final status. Ignoring callback.');
                return response()->json(['message' => 'Order already processed'], 200);
            }
            
            $originalStatus = $order->status;
            $transactionStatus = $notificationData['transaction_status'];
            $paymentType = $notificationData['payment_type'];
            $fraudStatus = isset($notificationData['fraud_status']) ? $notificationData['fraud_status'] : null;

            Log::info('➡️ Processing order_id: ' . $order->id . ', status from Midtrans: ' . $transactionStatus);

            // Menggunakan kembali logika status Anda yang sudah benar
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
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $order->status = 'cancelled';
                $order->payment_status = $transactionStatus;
            }

            // Menyimpan metode pembayaran dan transaction ID
            $order->payment_method = $paymentType;
            $order->midtrans_transaction_id = $notificationData['transaction_id'];
            $order->save();
            
            Log::info('✅ Order ' . $order->id . ' status updated to: ' . $order->status . ' and payment status to: ' . $order->payment_status);

            // Mengirim notifikasi real-time
            if ($order->status == 'completed' && $originalStatus != 'completed') {
                event(new NewOrderNotification($order));
                Log::info('🚀 Broadcasting NewOrderNotification for Order ID: ' . $order->id);
            }

            return response()->json(['message' => 'Callback received successfully'], 200);

        } catch (\Exception $e) {
            Log::error('❌ Error processing Midtrans callback: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['message' => 'Error processing callback'], 500);
        }
    }
}