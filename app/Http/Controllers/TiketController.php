<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;

/**
 * TiketController - Menampilkan daftar tiket untuk user/pengunjung
 * 
 * Fungsi:
 * - index: Daftar tiket dengan filter kategori, search, dan sorting
 * - show: Detail satu tiket
 */
class TiketController extends Controller
{
    /**
     * Daftar tiket dengan filter dan sorting
     * Filter: kategori (Reguler/Weekend/Grup)
     * Search: nama tiket
     * Sort: termurah/termahal (default: terbaru)
     */
    public function index(Request $request)
    {
        $query = Tiket::query();

        // Filter berdasarkan kategori jika ada
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // Search berdasarkan nama tiket
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_tiket', 'like', '%' . $request->search . '%');
        }

        // Sorting harga atau default terbaru
        if ($request->has('sort')) {
            if ($request->sort == 'termurah') {
                $query->orderBy('harga', 'asc');
            } elseif ($request->sort == 'termahal') {
                $query->orderBy('harga', 'desc');
            }
        } else {
            $query->latest();  // Default: urut terbaru
        }

        $tikets = $query->paginate(12);  // 12 per halaman
        $kategoris = Tiket::distinct()->pluck('kategori');  // Daftar kategori untuk filter

        return view('tiket.index', compact('tikets', 'kategoris'));
    }

    /**
     * Detail satu tiket
     */
    public function show($id)
    {
        $tiket = Tiket::findOrFail($id);
        return view('tiket.show', compact('tiket'));
    }
}
