<?php

namespace App\Mail;

use App\Models\Reply;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketReplied extends Mailable
{
    use Queueable, SerializesModels;

    // Properti untuk menyimpan data yang akan dikirim ke view
    public Ticket $ticket;
    public Reply $reply;

    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket, Reply $reply)
    {
        $this->ticket = $ticket;
        $this->reply = $reply;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Tentukan subjek emailnya
        $subject = "Re: Tiket #{$this->ticket->id} - {$this->ticket->title}";
        
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Tentukan file view mana yang akan digunakan sebagai template email
        return new Content(
            view: 'emails.tickets.replied',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}