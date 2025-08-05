<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash; // <-- Tambahkan ini
use Illuminate\Validation\Rules;     // <-- Tambahkan ini

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // Fungsi ini hanya menampilkan halaman formulir
        return view('admin.users.create');
    }

    // ... (use statements dan fungsi index, create, store yang sudah ada) ...

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Route-model binding akan otomatis mengambil data user berdasarkan ID
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Email harus unik, KECUALI untuk user yang sedang diedit ini
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            // Password bersifat opsional, jika diisi, harus divalidasi
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'is_admin' => ['required', 'boolean'],
        ]);

        // 2. Siapkan data yang akan diupdate
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->is_admin,
        ];

        // 3. Cek apakah ada input password baru
        if ($request->filled('password')) {
            // Jika ada, hash password baru dan tambahkan ke data update
            $updateData['password'] = Hash::make($request->password);
        }

        // 4. Update data user di database
        $user->update($updateData);

        // 5. Redirect ke halaman daftar user dengan pesan sukses
        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    // ... (use statements dan fungsi-fungsi lain yang sudah ada) ...

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // 1. Cek apakah admin mencoba menghapus akunnya sendiri
        if (auth()->id() == $user->id) {
            // Jika ya, kembalikan dengan pesan error
            return redirect()->route('admin.users.index')
                             ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // 2. Jika bukan, hapus user dari database
        $user->delete();

        // 3. Redirect ke halaman daftar user dengan pesan sukses
        return redirect()->route('admin.users.index')
                         ->with('success', 'User berhasil dihapus.');
    }

    public function store(Request $request)
    {
        // 1. Validasi semua input dari form
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_admin' => ['required', 'boolean'],
        ]);

        // 2. Buat user baru di database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'is_admin' => $request->is_admin,
        ]);

        // 3. Arahkan kembali ke halaman daftar user dengan pesan sukses
        return redirect()->route('admin.users.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    // ... (fungsi show, edit, update, destroy biarkan kosong dulu)
}