<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User; // <-- KESALAHANNYA DI SINI, BARIS INI HILANG
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Menampilkan daftar tiket.
     */
    public function index(Request $request): View
    {
        $query = Ticket::with('user', 'category', 'assignedTo');

        // Terapkan filter berdasarkan peran dan input
        if (Auth::user()->is_admin) {
            // Filter untuk admin
            $query->when($request->filter == 'mine', function ($q) {
                return $q->where('assigned_to', Auth::id());
            })->when($request->filter == 'unassigned', function ($q) {
                return $q->whereNull('assigned_to');
            });
        } else {
            // Filter untuk user biasa (hanya tiket miliknya)
            $query->where('user_id', Auth::id());
        }

        // Terapkan filter pencarian jika ada
        $query->when($request->search, function ($q, $search) {
            return $q->where('title', 'like', "%{$search}%");
        });

        $tickets = $query->latest()->paginate(10)->withQueryString();

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Menampilkan halaman formulir untuk membuat tiket baru.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('tickets.create', compact('categories'));
    }

    /**
     * Menyimpan tiket baru yang dibuat ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
            'category_id' => 'required|exists:categories,id',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
        }

        Ticket::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'attachment' => $path,
            'priority' => $request->priority,
            'status' => 'Open',
        ]);
        
        return redirect()->route('tickets.index')->with('success', 'Tiket Anda telah berhasil dibuat!');
    }

    /**
     * Menampilkan detail dari satu tiket spesifik.
     */
    public function show(Ticket $ticket): View
    {
        $ticket->load('user', 'category', 'replies.user', 'assignedTo');
        
        // Ambil daftar semua admin untuk dropdown penugasan
        $admins = User::where('is_admin', true)->get();
        
        return view('tickets.show', compact('ticket', 'admins'));
    }
}
