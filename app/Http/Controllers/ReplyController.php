<?php

namespace App\Http\Controllers;

use App\Mail\TicketReplied;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Events\NewReplyNotification;

class ReplyController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Ticket $ticket)
    {
        // 1. Validasi input balasan
        $request->validate(['body' => 'required|string']);

        // 2. Simpan balasan ke database
        $reply = $ticket->replies()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        // 3. Kirim notifikasi email menggunakan Mailable Class
        try {
            if ($reply->user->is_admin) {
                // Jika admin yang membalas, kirim email ke user pemilik tiket
                Mail::to($ticket->user->email)->send(new TicketReplied($ticket, $reply));
            } else {
                // Jika user yang membalas, kirim email ke semua admin
                $admins = User::where('is_admin', true)->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->send(new TicketReplied($ticket, $reply));
                }
            }
        } catch (\Exception $e) {
            // Tangani error jika email gagal dikirim.
            // Untuk aplikasi produksi, Anda bisa mencatat error ini:
            // \Log::error('Gagal mengirim email notifikasi balasan: ' . $e->getMessage());
        }

        // 4. Arahkan kembali ke halaman detail tiket dengan pesan sukses
        return redirect()->route('tickets.show', $ticket)->with('success', 'Balasan Anda telah dikirim.');
    }
}
