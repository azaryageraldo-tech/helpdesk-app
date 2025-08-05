<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Cek jika pengguna adalah admin
        if (Auth::user()->is_admin) {
            // Jika admin, ambil data statistik
            $stats = [
                'openTickets' => Ticket::where('status', 'Open')->count(),
                'closedTickets' => Ticket::where('status', 'Closed')->count(),
                'totalTickets' => Ticket::count(),
                'totalUsers' => User::count(),
            ];
        } else {
            // Jika bukan admin, siapkan data statistik untuk user biasa
             $stats = [
                'openTickets' => Ticket::where('user_id', Auth::id())->where('status', 'Open')->count(),
                'closedTickets' => Ticket::where('user_id', Auth::id())->where('status', 'Closed')->count(),
                'totalTickets' => Ticket::where('user_id', Auth::id())->count(),
            ];
        }

        return view('dashboard', compact('stats'));
    }
}