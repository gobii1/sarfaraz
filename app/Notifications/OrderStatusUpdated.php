<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage; // Pastikan ini diimport
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Determine the channels the notification should be sent on.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Get the database notification representation.
     *
     * @param  mixed  $notifiable
     * @return DatabaseMessage
     */
    public function toDatabase($notifiable)
    {
        // --- PERBAIKAN DI SINI: Akses nama produk melalui orderItems ---
        $productName = null;
        if ($this->order->orderItems->isNotEmpty()) {
            // Ambil nama produk dari item pertama, tambahkan fallback jika produk null
            $productName = $this->order->orderItems->first()->product->name ?? 'Produk Dihapus';
        } else {
            $productName = 'Tidak ada item produk'; // Jika pesanan tidak punya item
        }

        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,
            'product_name' => $productName, // Gunakan variabel productName yang sudah diperiksa
        ];
        // --- AKHIR PERBAIKAN ---
    }

    /**
     * Get the mail notification representation.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        // --- PERBAIKAN DI SINI: Konten email yang lebih detail ---
        $subject = 'Update Status Pesanan Anda: #' . $this->order->id;
        $greeting = 'Halo ' . $notifiable->name . ',';
        $line = 'Status pesanan Anda (ID: #' . $this->order->id . ') telah diperbarui menjadi **' . ucfirst($this->order->status) . '**.';

        if ($this->order->payment_status == 'paid') {
            $line .= ' Pembayaran Anda telah dikonfirmasi.';
        } elseif ($this->order->payment_status == 'pending') {
            $line .= ' Pembayaran Anda masih dalam status pending.';
        } elseif ($this->order->payment_status == 'failed' || $this->order->payment_status == 'expired' || $this->order->payment_status == 'cancelled') {
            $line .= ' Pembayaran Anda telah ' . ucfirst($this->order->payment_status) . '. Jika ada pertanyaan, silakan hubungi kami.';
        }

        // Menambahkan ringkasan produk di email
        $productSummary = '';
        if ($this->order->orderItems->isNotEmpty()) {
            $productSummary = 'Produk yang dipesan: ' . $this->order->orderItems->map(function($item) {
                // Pastikan produk tidak null sebelum mengambil nama
                return ($item->product->name ?? 'Produk Dihapus') . ' (' . $item->quantity . 'x)';
            })->implode(', ');
        }


        return (new MailMessage)
                    ->subject($subject)
                    ->greeting($greeting)
                    ->line($line)
                    ->line('Total Harga: Rp' . number_format($this->order->total_price, 0, ',', '.'))
                    ->line('Status Pembayaran: ' . ucfirst($this->order->payment_status))
                    ->line($productSummary) // Tambahkan ringkasan produk di email
                    ->action('Lihat Pesanan Anda', url('/orders/' . $this->order->id))
                    ->line('Terima kasih telah berbelanja di tempat kami!');
        // --- AKHIR PERBAIKAN ---
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            // Anda bisa mengisi ini jika Anda ingin data ini juga tersedia via API atau channel lain
        ];
    }
}