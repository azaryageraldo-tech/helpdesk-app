<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\NewReplyReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // 3. Kirim notifikasi menggunakan sistem notifikasi Laravel
        if ($reply->user->is_admin) {
            // Jika admin yang membalas, kirim notifikasi ke user pemilik tiket
            // Pastikan user tidak mengirim notifikasi ke dirinya sendiri
            if ($ticket->user->id !== $reply->user->id) {
                $ticket->user->notify(new NewReplyReceived($reply));
            }
        } else {
            // Jika user yang membalas, kirim notifikasi ke semua admin
            $admins = User::where('is_admin', true)->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewReplyReceived($reply));
            }
        }

        // 4. Arahkan kembali ke halaman detail tiket dengan pesan sukses
        return redirect()->route('tickets.show', $ticket)->with('success', 'Balasan Anda telah dikirim.');
    }
}
