<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalOperasional;
use Illuminate\Http\Request;

/**
 * Admin\JadwalController - Kelola jadwal operasional wisata (khusus admin)
 * 
 * Fitur:
 * - index: Tampilkan semua jadwal (Senin-Minggu)
 * - edit: Form edit jadwal per hari
 * - update: Simpan perubahan jam buka/tutup, status libur
 * 
 * Jadwal digunakan untuk:
 * - Menampilkan status buka/tutup di landing page
 * - Memberi informasi jam operasional ke pengunjung
 */
class JadwalController extends Controller
{
    /**
     * Tampilkan semua jadwal urut Senin -> Minggu
     */
    public function index()
    {
        $jadwals = JadwalOperasional::orderByRaw("
            CASE hari 
                WHEN 'Senin' THEN 1 
                WHEN 'Selasa' THEN 2 
                WHEN 'Rabu' THEN 3 
                WHEN 'Kamis' THEN 4 
                WHEN 'Jumat' THEN 5 
                WHEN 'Sabtu' THEN 6 
                WHEN 'Minggu' THEN 7 
            END
        ")->get();

        return view('admin.jadwal.index', compact('jadwals'));
    }

    /**
     * Form edit jadwal untuk satu hari
     */
    public function edit($id)
    {
        $jadwal = JadwalOperasional::findOrFail($id);
        return view('admin.jadwal.edit', compact('jadwal'));
    }

    /**
     * Update jadwal
     * - jam_buka/jam_tutup: format HH:MM (contoh: 08:00)
     * - is_libur: checkbox (checked = libur)
     * - keterangan: catatan tambahan (misal: "Libur Nasional")
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jam_buka' => ['nullable', 'date_format:H:i'],
            'jam_tutup' => ['nullable', 'date_format:H:i'],
            'is_libur' => ['boolean'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $jadwal = JadwalOperasional::findOrFail($id);
        $jadwal->update([
            'jam_buka' => $validated['jam_buka'] ?? null,
            'jam_tutup' => $validated['jam_tutup'] ?? null,
            'is_libur' => $request->has('is_libur'),  // Checkbox: true jika dicentang
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }
}
