<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TingkatAirTerjun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Admin\TingkatController - Mengelola data 3 tingkat air terjun
 * 
 * Fitur:
 * - index: Tampilkan semua tingkat
 * - edit: Form edit tingkat (nama, deskripsi, foto, tag, dll)
 * - update: Simpan perubahan
 * - Admin bisa upload foto keindahan air terjun per tingkat
 * - Foto ditampilkan di beranda saat card di-klik
 */
class TingkatController extends Controller
{
    /**
     * Tampilkan daftar semua tingkat air terjun
     */
    public function index()
    {
        $tingkats = TingkatAirTerjun::orderBy('urutan')->get();
        return view('admin.tingkat.index', compact('tingkats'));
    }

    /**
     * Form edit tingkat
     * Jika belum ada data untuk tingkat tertentu, buat data baru
     */
    public function edit($id)
    {
        $tingkat = TingkatAirTerjun::findOrFail($id);
        return view('admin.tingkat.edit', compact('tingkat'));
    }

    /**
     * Update data tingkat air terjun
     * 1. Validasi input
     * 2. Upload foto jika ada
     * 3. Update database
     */
    public function update(Request $request, $id)
    {
        $tingkat = TingkatAirTerjun::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'min:10'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'tag1' => ['nullable', 'string', 'max:50'],
            'tag2' => ['nullable', 'string', 'max:50'],
            'tag3' => ['nullable', 'string', 'max:50'],
            'emoji' => ['nullable', 'string', 'max:10'],
            'is_active' => ['nullable'],
        ], [
            'nama.required' => 'Nama tingkat harus diisi.',
            'deskripsi.required' => 'Deskripsi harus diisi.',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        // Handle upload foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($tingkat->foto) {
                Storage::disk('public')->delete($tingkat->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_tingkat' . $tingkat->tingkat . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('tingkat_air_terjun', $filename, 'public');
            $validated['foto'] = $path;
        }

        // Handle checkbox is_active
        $validated['is_active'] = $request->has('is_active');

        $tingkat->update($validated);

        return redirect()->route('admin.tingkat.index')
            ->with('success', 'Data Tingkat ' . $tingkat->tingkat . ' berhasil diperbarui.');
    }

    /**
     * Hapus foto dari tingkat tertentu
     */
    public function hapusFoto($id)
    {
        $tingkat = TingkatAirTerjun::findOrFail($id);

        if ($tingkat->foto) {
            Storage::disk('public')->delete($tingkat->foto);
            $tingkat->update(['foto' => null]);
        }

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
