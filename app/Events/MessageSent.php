<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $content;
    public string $uuid;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $content, string $uuid)
    {
        $this->content = $content;
        $this->uuid = $uuid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat-channel');
//        return ['my-channel'];
    }

    public function broadcastAs()
    {
        $uuid = User::findOrFail($this->uuid)->uuid;
//        return 'my-event';
        return (string)$uuid;
    }
}
