<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

/**
 * Admin GaleriController - Moderasi foto galeri pengunjung
 * 
 * Fitur:
 * - Lihat semua foto yang diunggah pengunjung
 * - Approve (setujui) foto
 * - Reject (tolak) foto
 * - Hapus foto (termasuk file dari storage)
 */
class GaleriController extends Controller
{
    /**
     * Daftar semua foto galeri dengan filter status
     */
    public function index(Request $request)
    {
        $query = Galeri::with('user');

        // Filter status jika ada
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Cari berdasarkan nama pengunggah atau caption
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%');
                })->orWhere('caption', 'like', '%' . $search . '%');
            });
        }

        $galeris = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('admin.galeri.index', compact('galeris'));
    }

    /**
     * Setujui foto
     */
    public function approve($id)
    {
        $galeri = Galeri::findOrFail($id);
        $galeri->update(['status' => 'disetujui']);

        return back()->with('success', 'Foto berhasil disetujui.');
    }

    /**
     * Tolak foto
     */
    public function reject($id)
    {
        $galeri = Galeri::findOrFail($id);
        $galeri->update(['status' => 'ditolak']);

        return back()->with('success', 'Foto berhasil ditolak.');
    }

    /**
     * Hapus foto beserta file dari storage
     */
    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        $galeri->hapusFoto();
        $galeri->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
