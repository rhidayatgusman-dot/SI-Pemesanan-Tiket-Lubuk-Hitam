<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Admin\UserController - CRUD user/pengguna (khusus admin)
 * 
 * Fitur:
 * - index: Daftar user + search nama/no WhatsApp + filter role
 * - create/store: Tambah user baru (admin atau pengunjung)
 * - edit/update: Edit user (password opsional, bisa dikosongkan)
 * - destroy: Hapus user (tidak bisa hapus diri sendiri)
 */
class UserController extends Controller
{
    /**
     * Daftar user dengan search dan filter
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search berdasarkan nama atau no WhatsApp
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('no_wa', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15);
        return view('admin.user.index', compact('users'));
    }

    /**
     * Form tambah user baru
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Simpan user baru
     * Password di-hash sebelum disimpan
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'regex:/^[0-9]{10,15}$/', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,pengunjung'],
        ], [
            'no_wa.regex' => 'Nomor WhatsApp harus 10-15 digit angka.',
        ]);

        User::create([
            'name' => $validated['name'],
            'no_wa' => $validated['no_wa'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Form edit user
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update user
     * Password opsional - hanya diupdate jika diisi
     * No WhatsApp unique kecuali untuk user ini sendiri
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'regex:/^[0-9]{10,15}$/', 'unique:users,no_wa,' . $user->id],
            'role' => ['required', 'in:admin,pengunjung'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'no_wa.regex' => 'Nomor WhatsApp harus 10-15 digit angka.',
        ]);

        $data = [
            'name' => $validated['name'],
            'no_wa' => $validated['no_wa'],
            'role' => $validated['role'],
        ];

        // Hanya update password jika diisi
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate!');
    }

    /**
     * Hapus user
     * Tidak bisa hapus akun sendiri (mencegah admin terkunci)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cegah admin hapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus akun sendiri.']);
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus!');
    }
}
