<?php

namespace App\Notifications;

use App\Models\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewReplyReceived extends Notification implements ShouldBroadcast
{
    use Queueable;

    public Reply $reply;

    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast']; // Kirim ke database DAN broadcast
    }

    // Data yang disimpan di database
    public function toArray($notifiable): array
    {
        return [
            'message' => "Balasan baru dari {$this->reply->user->name}",
            'ticket_id' => $this->reply->ticket->id,
            'ticket_title' => $this->reply->ticket->title,
        ];
    }

    // Data yang disiarkan ke Pusher
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => "Balasan baru dari {$this->reply->user->name} pada tiket '{$this->reply->ticket->title}'",
            'url' => route('tickets.show', $this->reply->ticket->id),
        ]);
    }
}