<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:Open,Closed,In Progress',
        ]);

        $ticket->update([
            'status' => $request->status,
        ]);

        return redirect()->route('tickets.show', $ticket)->with('success', 'Status tiket berhasil diperbarui.');
    }

    /**
     * Menugaskan tiket ke seorang admin.
     */
    public function assignTicket(Request $request, Ticket $ticket)
    {
        $request->validate([
            // Pastikan user yang dipilih ada dan merupakan seorang admin
            'admin_id' => 'required|exists:users,id',
        ]);

        $ticket->update([
            'assigned_to' => $request->admin_id,
        ]);

        return redirect()->route('tickets.show', $ticket)->with('success', 'Tiket berhasil ditugaskan.');
    }
}
