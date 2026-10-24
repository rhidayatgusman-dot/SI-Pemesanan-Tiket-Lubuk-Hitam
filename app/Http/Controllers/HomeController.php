<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\JadwalOperasional;
use App\Models\Testimoni;
use App\Models\TingkatAirTerjun;
use App\Models\Tiket;

/**
 * HomeController - Menangani halaman beranda/landing page
 * 
 * Alur:
 * 1. Ambil 6 tiket random untuk ditampilkan di beranda
 * 2. Cek status buka/tutup wisata sekarang
 * 3. Ambil jadwal hari ini dan semua jadwal (urut Senin-Minggu)
 * 4. Tampilkan view beranda dengan data tersebut
 */
class HomeController extends Controller
{
    public function index()
    {
        // Ambil 6 tiket secara acak untuk ditampilkan
        $tikets = Tiket::inRandomOrder()->limit(6)->get();
        
        // Cek apakah wisata sedang buka sekarang
        $isOpen = JadwalOperasional::isOpenNow();
        
        // Ambil jadwal untuk hari ini
        $jadwalHariIni = JadwalOperasional::getHariIni();
        
        // Ambil semua jadwal urut Senin -> Minggu
        $allJadwal = JadwalOperasional::orderByRaw("
            CASE hari 
                WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 
                WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 
                WHEN 'Minggu' THEN 7 
            END
        ")->get();

        // Ambil testimoni yang sudah di-approve (max 6, urut terbaru)
        $testimonis = Testimoni::approved()
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Ambil data tingkat air terjun yang aktif
        $tingkats = TingkatAirTerjun::active()->get();

        // Ambil galeri foto yang sudah disetujui (max 12, urut terbaru)
        $galeris = Galeri::disetujui()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();

        // Hitung total galeri untuk tombol "Lihat Semua"
        $totalGaleri = Galeri::disetujui()->count();

        // Ambil fasilitas aktif beserta galeri foto aktif
        $fasilitass = Fasilitas::active()->with(['galeriAktif' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->get();
        
        // Siapkan data JSON untuk modal foto tingkat air terjun
        $tingkatJson = $tingkats->map(function($t) {
            return [
                'tingkat' => $t->tingkat,
                'nama' => $t->nama,
                'foto' => $t->foto ? asset('storage/' . $t->foto) : '',
                'deskripsi' => $t->deskripsi,
                'emoji' => $t->emoji,
            ];
        });
        
        return view('beranda', compact('tikets', 'isOpen', 'jadwalHariIni', 'allJadwal', 'testimonis', 'tingkats', 'tingkatJson', 'galeris', 'totalGaleri', 'fasilitass'));
    }
}
