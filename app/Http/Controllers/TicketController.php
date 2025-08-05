<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Menampilkan daftar tiket.
     */
    public function index(): View
    {
        // Cek apakah pengguna adalah admin
        if (Auth::user()->is_admin) {
            // Jika admin, ambil semua tiket beserta relasi user & kategori-nya
            $tickets = Ticket::with('user', 'category')->latest()->get();
        } else {
            // Jika bukan admin, hanya ambil tiket milik pengguna yang sedang login
            $tickets = Ticket::where('user_id', Auth::id())->with('category')->latest()->get();
        }

        // Kirim data tiket ke view 'tickets.index'
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Menampilkan halaman formulir untuk membuat tiket baru.
     */
    public function create(): View
    {
        // Ambil semua kategori untuk ditampilkan di dropdown
        $categories = Category::all();
        return view('tickets.create', compact('categories'));
    }

    /**
     * Menyimpan tiket baru yang dibuat ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:Low,Medium,High',
            'category_id' => 'required|exists:categories,id', // Validasi untuk kategori
        ]);

        // Buat tiket baru di database
        Ticket::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id, // Simpan ID kategori
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'Open',
        ]);
        
        // Arahkan kembali ke halaman daftar tiket dengan pesan sukses
        return redirect()->route('tickets.index')->with('success', 'Tiket Anda telah berhasil dibuat!');
    }

    /**
     * Menampilkan detail dari satu tiket spesifik.
     */
    public function show(Ticket $ticket): View
    {
        // Muat relasi user, kategori, dan semua balasan beserta user pembuat balasan
        $ticket->load('user', 'category', 'replies.user');
        
        return view('tickets.show', compact('ticket'));
    }
}