<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\User;
use App\Notifications\OrderStatusUpdated;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = collect(); // Inisialisasi collection kosong

        // Tentukan data pesanan yang akan diambil berdasarkan role user
        if (auth()->user()->role == 'admin') {
            // Admin bisa melihat semua pesanan
            $orders = Order::with('orderItems.product')
                            ->orderBy('created_at', 'desc')
                            ->get();
        } else { // Ini akan mencakup role 'client' dan lainnya yang bukan admin
            // Client hanya bisa melihat pesanan mereka sendiri
            $orders = Order::where('user_id', Auth::id())
                            ->with('orderItems.product')
                            ->orderBy('created_at', 'desc')
                            ->get();
        }

        // --- KUNCI PERUBAHAN DI SINI: Tentukan view mana yang akan dirender ---
        if (request()->routeIs('admin.orders.index')) {
            // Jika rute yang diakses adalah rute admin, render view admin
            return view('admin.orders.index', compact('orders'));
        } else {
            // Jika rute yang diakses adalah rute client (atau default lainnya), render view client
            return view('orders.index', compact('orders'));
        }
        // --- AKHIR KUNCI PERUBAHAN ---
    }

    /**
     * Show the checkout page.
     */
    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('client.cart.index')->with('error', 'Keranjang Anda kosong! Tidak bisa checkout.');
        }

        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        return view('orders.checkout', compact('cartItems', 'totalPrice'));
    }

    /**
     * Store a newly created order (Handle the checkout process).
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

            if ($cartItems->isEmpty()) {
                DB::rollBack();
                return redirect()->route('client.cart.index')->with('error', 'Keranjang Anda kosong! Tidak bisa checkout.');
            }

            $totalPrice = 0;
            foreach ($cartItems as $cartItem) {
                if (!$cartItem->product || $cartItem->quantity > $cartItem->product->stock) {
                    DB::rollBack();
                    $productName = $cartItem->product ? $cartItem->product->name : 'Produk Tidak Ditemukan';
                    $availableStock = $cartItem->product ? $cartItem->product->stock : 0;
                    return redirect()->route('client.cart.index')->with('error', 'Stok produk "' . $productName . '" tidak mencukupi. Hanya tersedia ' . $availableStock . ' unit.');
                }
                $totalPrice += $cartItem->price * $cartItem->quantity;
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                ]);

                $product = $cartItem->product;
                if ($product) {
                    $product->stock -= $cartItem->quantity;
                    $product->save();
                }
            }

            Log::info('--- Attempting to create Snap Token (OrderController@store) ---');
            Log::info('Order ID for Snap: ' . $order->id);
            Log::info('Total Price for Snap: ' . $order->total_price);

            $midtrans = new CreateSnapTokenService($order);
            $snapToken = $midtrans->getSnapToken();

            Log::info('Snap Token generated: ' . $snapToken);

            $order->snap_token = $snapToken;
            $order->save();

            foreach ($cartItems as $cartItem) {
                $cartItem->delete();
            }

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pemesanan berhasil! Silakan lakukan pembayaran.')
                ->with('snap_token', $snapToken);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation error (Snap Token): ' . $e->getMessage());
            Log::error('Stack trace (Order creation): ' . $e->getTraceAsString());
            return redirect()->route('client.cart.index')->with('error', 'Terjadi kesalahan saat membuat transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified order.
     */
    public function show(string $id)
    {
        $order = null;

        // --- KUNCI PERUBAHAN DI SINI: Deteksi Rute Admin atau Client ---
        if (request()->routeIs('admin.orders.show')) {
            // Untuk Admin:
            // Ambil semua pesanan, eager load order items, produk terkait, dan user pemesan
            $order = Order::with('orderItems.product', 'user')->findOrFail($id);
            // Render view untuk admin
            return view('admin.orders.show', compact('order'));
        } else {
            // Untuk Client (default jika bukan rute admin):
            // Hanya ambil pesanan yang dimiliki oleh user yang sedang login
            $order = Order::where('user_id', Auth::id())
                          ->with('orderItems.product')
                          ->findOrFail($id);
            // Render view untuk client
            return view('orders.show', compact('order'));
        }
        // --- AKHIR KUNCI PERUBAHAN ---
    }

    /**
     * Show the form for editing the specified order (Admin).
     */
    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage (Admin).
     */
   public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled,on hold,refunded',
            'payment_status' => 'required|in:pending,paid,failed,expired,cancelled,challenge,refunded',
        ]);

        // --- PERUBAHAN DI SINI: Eager load orderItems.product ---
        $order = Order::with('orderItems.product')->findOrFail($id);
        // --- AKHIR PERUBAHAN ---

        $order->status = strtolower($request->status);
        $order->payment_status = strtolower($request->payment_status);
        $order->save();

        if ($order->wasChanged('status') || $order->wasChanged('payment_status')) {
            if ($order->user) {
                // Sekarang $order yang dioper sudah punya relasi orderItems dan product
                $order->user->notify(new OrderStatusUpdated($order));
            } else {
                Log::warning('User not found for order ' . $order->id . '. Cannot send status update notification.');
            }
        }

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Handle Midtrans notification callback.
     */
    public function handleNotification(Request $request)
    {
        Log::info('Midtrans notification received: ' . json_encode($request->all()));

        $json = json_decode($request->getContent());

        if (!isset($json->order_id) || !isset($json->status_code) || !isset($json->gross_amount) || !isset($json->signature_key) || !isset($json->transaction_status) || !isset($json->payment_type) || !isset($json->fraud_status)) {
            Log::error('Invalid Midtrans notification payload: Missing required keys');
            return response()->json(['message' => 'Invalid notification payload'], 400);
        }

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $expected_signature_key = hash('sha512', $json->order_id . $json->status_code . $json->gross_amount . Config::$serverKey);

        if ($expected_signature_key != $json->signature_key) {
            Log::warning('Invalid signature key for order ' . $json->order_id);
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $order_id = $json->order_id;
        $order = Order::with('orderItems.product')->where('id', $order_id)->first();

        if (!$order) {
            Log::error('Order not found for ID: ' . $order_id . ' during notification handling.');
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $json->transaction_status;
        $paymentType = $json->payment_type;
        $fraudStatus = $json->fraud_status;

        DB::beginTransaction();
        try {
            $currentPaymentStatus = $order->payment_status;
            $currentOrderStatus = $order->status;

            if ($currentPaymentStatus == 'paid' && ($transactionStatus == 'settlement' || ($transactionStatus == 'capture' && $fraudStatus == 'accept'))) {
                Log::info('Order ' . $order->id . ' already paid. Skipping update.');
                DB::commit();
                return response()->json(['message' => 'Order already paid'], 200);
            }
            if ($currentOrderStatus == 'cancelled' && ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel')) {
                 Log::info('Order ' . $order->id . ' already cancelled/expired. Skipping update.');
                 DB::commit();
                 return response()->json(['message' => 'Order already cancelled/expired'], 200);
            }


            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $order->payment_status = 'challenge';
                        $order->status = 'on hold';
                    } else {
                        $order->payment_status = 'paid';
                        $order->status = 'completed';
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                $order->payment_status = 'paid';
                $order->status = 'completed';
            } elseif ($transactionStatus == 'pending') {
                $order->payment_status = 'pending';
                $order->status = 'pending';
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $order->payment_status = $transactionStatus;
                $order->status = 'cancelled';
                
                foreach ($order->orderItems as $item) {
                    $product = $item->product;
                    if ($product) {
                        $product->stock += $item->quantity;
                        $product->save();
                        Log::info('Restored stock for product ' . $product->id . ': ' . $item->quantity . ' units. New stock: ' . $product->stock);
                    } else {
                        Log::warning('Product with ID ' . $item->product_id . ' not found for order item ' . $item->id . ' during stock restore.');
                    }
                }
            } elseif ($transactionStatus == 'refund' || $transactionStatus == 'partial_refund') {
                $order->payment_status = 'refunded';
                $order->status = 'refunded';
            }

            $order->midtrans_transaction_id = $json->transaction_id;
            $order->save();

            DB::commit();

            if ($order->user) {
                 $order->user->notify(new OrderStatusUpdated($order));
                 Log::info('Notification sent to user ' . $order->user->id . ' for order ' . $order->id . '.');
            } else {
                Log::warning('User not found for order ' . $order->id . '. Cannot send notification.');
            }

            return response()->json(['message' => 'Notification handled successfully'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error handling Midtrans notification for order ' . $order->id . ': ' . $e->getMessage());
            Log::error('Stack trace (Notification Handler): ' . $e->getTraceAsString());
            return response()->json(['message' => 'Error handling notification'], 500);
        }
    }
}