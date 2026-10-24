<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

/**
 * Admin\PesananController - Verifikasi dan kelola pesanan (khusus admin)
 * 
 * Alur verifikasi:
 * 1. Admin lihat daftar pesanan (index) + filter status
 * 2. Admin buka detail pesanan (show) -> lihat bukti bayar
 * 3. Admin terima -> kurangi stok tiket, ubah status = 'diterima'
 *    Admin tolak -> ubah status = 'ditolak'
 * 
 * Catatan:
 * - Stok tiket HANYA dikurangi saat admin terima pesanan
 * - Pesanan yang sudah diproses tidak bisa diubah lagi
 */
class PesananController extends Controller
{
    /**
     * Daftar semua pesanan dengan filter
     * Filter: status (pending/diterima/ditolak)
     * Search: nama user atau nama tiket
     */
    public function index(Request $request)
    {
        $query = Pesanan::with(['user', 'tiket']);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search: nama user atau nama tiket
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })->orWhereHas('tiket', function ($q) use ($search) {
                $q->where('nama_tiket', 'like', '%' . $search . '%');
            });
        }

        $pesanans = $query->latest()->paginate(15);
        return view('admin.pesanan.index', compact('pesanans'));
    }

    /**
     * Detail pesanan (lihat bukti bayar, data pemesan, dll)
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'tiket'])->findOrFail($id);
        return view('admin.pesanan.show', compact('pesanan'));
    }

    /**
     * Terima pesanan
     * 1. Cek status masih pending
     * 2. Cek stok tiket cukup
     * 3. Kurangi stok tiket
     * 4. Ubah status = 'diterima'
     */
    public function terima(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Hanya bisa terima pesanan pending
        if ($pesanan->status !== 'pending') {
            return back()->withErrors(['error' => 'Pesanan tidak dapat diterima.']);
        }

        $tiket = $pesanan->tiket;
        // Cek stok cukup
        if ($tiket->stok < $pesanan->jumlah) {
            return back()->withErrors(['error' => 'Stok tiket tidak mencukupi.']);
        }

        // Kurangi stok tiket
        $tiket->decrement('stok', $pesanan->jumlah);

        // Update status pesanan
        $pesanan->update([
            'status' => 'diterima',
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Pesanan berhasil diterima!');
    }

    /**
     * Tolak pesanan
     * 1. Cek status masih pending
     * 2. Ubah status = 'ditolak'
     * 3. Stok TIDAK dikurangi
     */
    public function tolak(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Hanya bisa tolak pesanan pending
        if ($pesanan->status !== 'pending') {
            return back()->withErrors(['error' => 'Pesanan tidak dapat ditolak.']);
        }

        $pesanan->update([
            'status' => 'ditolak',
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Pesanan berhasil ditolak!');
    }
}
