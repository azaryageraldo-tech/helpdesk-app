<?php

namespace App\Events;

use App\Models\Reply;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewReplyNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public string $url;

    public function __construct(Reply $reply)
    {
        $this->message = "Balasan baru dari {$reply->user->name} pada tiket #{$reply->ticket->id}";
        $this->url = route('tickets.show', $reply->ticket->id);
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('notifications'),
        ];
    }
}
