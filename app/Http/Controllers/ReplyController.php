<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User; // <-- Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // <-- Tambahkan ini

class ReplyController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate(['body' => 'required|string']);

        // 1. Simpan balasan ke database
        $reply = $ticket->replies()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
        ]);

        // =======================================================
        // 2. LOGIKA PENGIRIMAN EMAIL
        // =======================================================
        try {
            if ($reply->user->is_admin) {
                // Skenario 1: Admin yang membalas, kirim email ke User
                $recipient = $ticket->user;
                $subject = "Re: Tiket #{$ticket->id} - {$ticket->title}";
                $body = "Halo {$recipient->name},\n\n" .
                        "Admin telah memberikan balasan baru untuk tiket Anda dengan judul \"{$ticket->title}\".\n\n" .
                        "Isi Balasan:\n\"{$reply->body}\"\n\n" .
                        "Silakan cek aplikasi untuk detail lebih lanjut.";
                
                Mail::raw($body, function ($message) use ($recipient, $subject) {
                    $message->to($recipient->email)
                            ->subject($subject);
                });

            } else {
                // Skenario 2: User yang membalas, kirim email ke semua Admin
                $admins = User::where('is_admin', true)->get();
                $subject = "Balasan Baru Pengguna untuk Tiket #{$ticket->id}";
                
                foreach ($admins as $admin) {
                    $body = "Halo {$admin->name},\n\n" .
                            "Pengguna {$reply->user->name} telah memberikan balasan baru pada tiket #{$ticket->id} dengan judul \"{$ticket->title}\".\n\n" .
                            "Isi Balasan:\n\"{$reply->body}\"\n\n" .
                            "Mohon untuk segera ditindaklanjuti.";

                    Mail::raw($body, function ($message) use ($admin, $subject) {
                        $message->to($admin->email)
                                ->subject($subject);
                    });
                }
            }
        } catch (\Exception $e) {
            // Jika email gagal dikirim, proses tetap lanjut tapi bisa dicatat errornya
            // (Untuk production, Anda bisa menggunakan Log::error($e->getMessage());)
        }
        // =======================================================

        // 3. Arahkan kembali ke halaman detail tiket
        return redirect()->route('tickets.show', $ticket)->with('success', 'Balasan Anda telah dikirim.');
    }
}