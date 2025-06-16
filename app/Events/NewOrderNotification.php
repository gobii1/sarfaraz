<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderNotification implements ShouldBroadcast
{
       use Dispatchable, InteractsWithSockets, SerializesModels;

public $order;

/**
 * Create a new event instance.
 */
public function __construct(Order $order)
{
    $this->order = $order;
}

/**
 * Get the channels the event should broadcast on.
 *
 * @return array<int, \Illuminate\Broadcasting\Channel>
 */
public function broadcastOn(): array
{
    // Kita broadcast ke channel privat bernama 'admin-channel'
    // Hanya admin yang bisa mendengarkan ini
    return [
        new PrivateChannel('admin-channel'),
    ];
}

/**
 * Nama event yang akan di-broadcast.
 */
public function broadcastAs()
{
    return 'new-order';
}

/**
 * Data yang akan dikirim bersama event.
 */
public function broadcastWith(): array
{
    return [
        'order_id' => $this->order->id,
        'customer_name' => $this->order->customer_name,
        'message' => "Pesanan baru #{$this->order->id} telah diterima.",
        'url' => route('admin.orders.show', $this->order->id)
    ];
}
}

