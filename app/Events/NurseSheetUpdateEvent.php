<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NurseSheetUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nurse_sheet_update;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($nurse_sheet_update)
    {
        $this->nurse_sheet_update = $nurse_sheet_update;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
