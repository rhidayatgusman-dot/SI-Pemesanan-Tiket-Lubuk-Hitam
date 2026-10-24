<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Admin\LaporanController - Laporan pendapatan dan penjualan tiket
 * 
 * Fitur:
 * - index: Tampilkan laporan di halaman web (dengan filter tanggal)
 * - cetakPdf: Generate PDF laporan untuk di-download
 * 
 * Data laporan:
 * - Total pendapatan dan total tiket terjual
 * - Pendapatan per hari (untuk grafik)
 * - Detail semua pesanan dalam rentang tanggal
 * 
 * Hanya menghitung pesanan dengan status = 'diterima'
 */
class LaporanController extends Controller
{
    /**
     * Tampilkan laporan di halaman web
     * Filter: start_date dan end_date (default: bulan ini)
     */
    public function index(Request $request)
    {
        // Default: bulan ini
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Ambil semua pesanan dalam rentang tanggal (semua status)
        $pesanans = Pesanan::with(['user', 'tiket'])
            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung total (hanya yang diterima)
        $totalPendapatan = $pesanans->where('status', 'diterima')->sum('total');
        $totalTiketTerjual = $pesanans->where('status', 'diterima')->sum('jumlah');

        // Pendapatan per hari (untuk grafik)
        $pendapatanPerHari = Pesanan::whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->where('status', 'diterima')
            ->selectRaw('DATE(tanggal_kunjungan) as tanggal, SUM(total) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('admin.laporan', compact(
            'startDate',
            'endDate',
            'totalPendapatan',
            'totalTiketTerjual',
            'pesanans',
            'pendapatanPerHari'
        ));
    }

    /**
     * Generate PDF laporan
     * Data sama dengan index(), tapi di-render sebagai PDF
     * Output: Laporan-Air-Terjun-Lubuk-Hitam-{tanggal}.pdf
     */
    public function cetakPdf(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $pesanans = Pesanan::with(['user', 'tiket'])
            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPendapatan = $pesanans->where('status', 'diterima')->sum('total');
        $totalTiketTerjual = $pesanans->where('status', 'diterima')->sum('jumlah');

        $pendapatanPerHari = Pesanan::whereBetween('tanggal_kunjungan', [$startDate, $endDate])
            ->where('status', 'diterima')
            ->selectRaw('DATE(tanggal_kunjungan) as tanggal, SUM(total) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Generate PDF menggunakan barryvdh/laravel-dompdf
        $pdf = Pdf::loadView('admin.laporan-pdf', compact(
            'startDate',
            'endDate',
            'totalPendapatan',
            'totalTiketTerjual',
            'pesanans',
            'pendapatanPerHari'
        ));

        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Laporan-Air-Terjun-Lubuk-Hitam-' . date('Y-m-d') . '.pdf');
    }
}
