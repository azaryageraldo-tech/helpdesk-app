<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Mengambil notifikasi yang belum dibaca milik pengguna.
     */
    public function fetch()
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * Menandai notifikasi sebagai sudah dibaca.
     */
    public function markAsRead(Request $request)
    {
        auth()->user()->unreadNotifications->where('id', $request->id)->markAsRead();

        return response()->noContent();
    }
}
