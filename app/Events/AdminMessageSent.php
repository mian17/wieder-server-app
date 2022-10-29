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

class AdminMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $content;
    public string $uuid;
    public string $admin_uuid;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $content, string $uuid, string $admin_uuid)
    {
        $this->content = $content;
        $this->uuid = $uuid;
        $this->admin_uuid = $admin_uuid;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat-channel');
    }

    public function broadcastAs()
    {
        $uuid = User::findOrFail($this->uuid)->uuid;
//        return 'my-event';
        return (string)$uuid;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['content' => $this->content, 'uuid' => $this->admin_uuid];
    }
}
