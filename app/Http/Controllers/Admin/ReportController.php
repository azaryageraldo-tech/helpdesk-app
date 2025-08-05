<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Ambil statistik umum
        $stats = [
            'openTickets' => Ticket::where('status', 'Open')->count(),
            'closedTickets' => Ticket::where('status', 'Closed')->count(),
            'totalTickets' => Ticket::count(),
            'totalUsers' => User::where('is_admin', false)->count(),
        ];

        // Siapkan data untuk grafik tiket per kategori
        $categories = Category::withCount('tickets')->get();

        $categoryLabels = $categories->pluck('name');
        $categoryData = $categories->pluck('tickets_count');

        return view('admin.reports.index', compact('stats', 'categoryLabels', 'categoryData'));
    }
}