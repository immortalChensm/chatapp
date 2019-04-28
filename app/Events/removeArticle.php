<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class removeArticle
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $article = '';
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($articleHtml)
    {
        //
        $this->article = $articleHtml;
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
