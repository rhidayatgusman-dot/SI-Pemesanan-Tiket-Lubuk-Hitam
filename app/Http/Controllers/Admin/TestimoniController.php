<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;

/**
 * Admin\TestimoniController - Mengelola testimoni dari pengunjung
 * 
 * Fitur:
 * - index: Tampilkan semua testimoni (approved & pending)
 * - approve: Set is_approved = true (testimoni tampil di beranda)
 * - reject: Hapus testimoni yang tidak sesuai
 */
class TestimoniController extends Controller
{
    /**
     * Tampilkan daftar semua testimoni
     * Urut: yang pending dulu, lalu yang sudah approved
     */
    public function index()
    {
        $testimonis = Testimoni::orderBy('is_approved')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.testimoni.index', compact('testimonis'));
    }

    /**
     * Approve testimoni (tampilkan di beranda)
     * Set is_approved = true
     */
    public function approve($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->update(['is_approved' => true]);

        return back()->with('success', 'Testimoni dari ' . $testimoni->nama . ' telah ditampilkan.');
    }

    /**
     * Reject/hapus testimoni
     */
    public function destroy($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->delete();

        return back()->with('success', 'Testimoni dari ' . $testimoni->nama . ' telah dihapus.');
    }
}
