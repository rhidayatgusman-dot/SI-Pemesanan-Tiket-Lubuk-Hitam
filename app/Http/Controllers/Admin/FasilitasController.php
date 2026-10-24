<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

/**
 * Admin FasilitasController - CRUD master data fasilitas
 */
class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitass = Fasilitas::orderBy('urutan')->get();
        return view('admin.fasilitas.index', compact('fasilitass'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:10'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        Fasilitas::create([
            'nama' => $validated['nama'],
            'icon' => $validated['icon'] ?? '🏢',
            'deskripsi' => $validated['deskripsi'] ?? null,
            'is_active' => true,
            'urutan' => $validated['urutan'] ?? 0,
        ]);

        return back()->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:10'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ]);

        $fasilitas->update([
            'nama' => $validated['nama'],
            'icon' => $validated['icon'] ?? '🏢',
            'deskripsi' => $validated['deskripsi'] ?? null,
            'urutan' => $validated['urutan'] ?? 0,
        ]);

        return back()->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function toggleActive($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->update(['is_active' => !$fasilitas->is_active]);

        return back()->with('success', 'Status fasilitas berhasil diubah.');
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        // Hapus semua foto terkait
        foreach ($fasilitas->galeriFotos as $foto) {
            $foto->hapusFoto();
        }
        $fasilitas->delete();

        return back()->with('success', 'Fasilitas berhasil dihapus.');
    }
}
