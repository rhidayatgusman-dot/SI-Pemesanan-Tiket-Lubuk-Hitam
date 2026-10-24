<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Admin\TiketController - CRUD tiket wisata (khusus admin)
 * 
 * Fitur:
 * - index: Daftar tiket + search
 * - create/store: Tambah tiket baru + upload gambar
 * - edit/update: Edit tiket + ganti gambar (hapus gambar lama)
 * - destroy: Hapus tiket + hapus gambar
 * 
 * Gambar disimpan di: storage/app/public/tiket_images/
 */
class TiketController extends Controller
{
    /**
     * Daftar tiket dengan search
     */
    public function index(Request $request)
    {
        $query = Tiket::query();

        // Search berdasarkan nama tiket
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_tiket', 'like', '%' . $request->search . '%');
        }

        $tikets = $query->latest()->paginate(10);
        return view('admin.tiket.index', compact('tikets'));
    }

    /**
     * Form tambah tiket baru
     */
    public function create()
    {
        return view('admin.tiket.create');
    }

    /**
     * Simpan tiket baru
     * 1. Validasi semua field
     * 2. Upload gambar jika ada
     * 3. Simpan ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_tiket' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'kategori' => ['required', 'in:Reguler,Weekend,Grup'],  // Hanya 3 kategori
            'stok' => ['required', 'integer', 'min:0'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['gambar'] = $file->storeAs('tiket_images', $filename, 'public');
        }

        Tiket::create($validated);

        return redirect()->route('admin.tiket.index')->with('success', 'Tiket berhasil ditambahkan!');
    }

    /**
     * Form edit tiket
     */
    public function edit($id)
    {
        $tiket = Tiket::findOrFail($id);
        return view('admin.tiket.edit', compact('tiket'));
    }

    /**
     * Update tiket
     * 1. Validasi data
     * 2. Jika upload gambar baru, hapus gambar lama dulu
     * 3. Update database
     */
    public function update(Request $request, $id)
    {
        $tiket = Tiket::findOrFail($id);

        $validated = $request->validate([
            'nama_tiket' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'harga' => ['required', 'numeric', 'min:0'],
            'kategori' => ['required', 'in:Reguler,Weekend,Grup'],
            'stok' => ['required', 'integer', 'min:0'],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // Ganti gambar jika ada upload baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($tiket->gambar) {
                Storage::disk('public')->delete($tiket->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['gambar'] = $file->storeAs('tiket_images', $filename, 'public');
        }

        $tiket->update($validated);

        return redirect()->route('admin.tiket.index')->with('success', 'Tiket berhasil diupdate!');
    }

    /**
     * Hapus tiket beserta gambarnya
     */
    public function destroy($id)
    {
        $tiket = Tiket::findOrFail($id);

        // Hapus gambar dari storage
        if ($tiket->gambar) {
            Storage::disk('public')->delete($tiket->gambar);
        }

        $tiket->delete();

        return redirect()->route('admin.tiket.index')->with('success', 'Tiket berhasil dihapus!');
    }

    /**
     * Detail tiket
     */
    public function show($id)
    {
        $tiket = Tiket::findOrFail($id);
        return view('admin.tiket.show', compact('tiket'));
    }
}
