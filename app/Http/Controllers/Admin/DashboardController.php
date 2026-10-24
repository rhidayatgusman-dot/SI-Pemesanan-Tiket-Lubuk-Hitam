<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Tiket;
use App\Models\User;

/**
 * Admin\DashboardController - Menampilkan dashboard admin
 * 
 * Data yang ditampilkan:
 * - Total tiket, total pesanan, pesanan pending
 * - Total pendapatan (dari pesanan diterima)
 * - 5 pesanan terbaru
 * - 5 tiket terlaris (paling banyak dipesan)
 */
class DashboardController extends Controller
{
    public function index()
    {
        // Statistik umum
        $totalTiket = Tiket::count();
        $totalPesanan = Pesanan::count();
        $pesananPending = Pesanan::where('status', 'pending')->count();
        $pendapatan = Pesanan::where('status', 'diterima')->sum('total');  // Hanya dari pesanan diterima

        // 5 pesanan terbaru
        $pesananTerbaru = Pesanan::with(['user', 'tiket'])
            ->latest()
            ->limit(5)
            ->get();

        // 5 tiket terlaris (hitung jumlah pesanan per tiket)
        $tiketTerlaris = Tiket::withCount('pesanans')
            ->orderBy('pesanans_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalTiket',
            'totalPesanan',
            'pesananPending',
            'pendapatan',
            'pesananTerbaru',
            'tiketTerlaris'
        ));
    }
}
