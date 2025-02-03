<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class StockUpdate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $stockUpdates;

    public function __construct(array $stockUpdates)
    {
        $this->stockUpdates = $stockUpdates; // Store multiple updates

        \Log::info('Broadcasting event with data:', $this->stockUpdates);
    }

    public function broadcastOn()
    {
        // return new Channel('erp-app');
        return [env('PUSHER_APP_CHANNEL')];
    }

    public function broadcastAs()
    {
        return 'StockUpdate';
    }
}
