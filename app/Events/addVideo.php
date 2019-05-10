<?php

namespace App\Events;

use App\Videos;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class addVideo
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $videoModel;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($videos=[])
    {
        //
        $this->videoModel = $videos;
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
