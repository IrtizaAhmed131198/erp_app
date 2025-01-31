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

    public $dataTarget;
    public $inStockFinish;

    public function __construct($dataTarget, $inStockFinish)
    {
        $this->dataTarget = $dataTarget;
        $this->inStockFinish = $inStockFinish;
        \Log::info('Broadcasting event controller: ' . $this->dataTarget);
        \Log::info('Broadcasting event controller: ' . $this->inStockFinish);
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
