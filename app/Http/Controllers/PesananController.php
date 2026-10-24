<?php

namespace App\Http\Controllers;

use App\Models\JadwalOperasional;
use App\Models\Pesanan;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * PesananController - Menangani pemesanan tiket oleh user/pengunjung
 * 
 * Alur pemesanan:
 * 1. User pilih tiket -> form pemesanan (create)
 * 2. Submit form -> buat pesanan status='pending' (store)
 * 3. User upload bukti pembayaran (bayar)
 * 4. Admin verifikasi -> terima/tolak
 * 5. Jika diterima -> user bisa cetak tiket (cetak)
 * 
 * Catatan:
 * - User hanya bisa lihat pesanan sendiri (where user_id = auth()->id())
 * - Stok tiket dikurangi saat admin terima pesanan
 */
class PesananController extends Controller
{
    /**
     * Daftar pesanan user yang sedang login
     * Hanya tampilkan pesanan milik user ini, urut terbaru
     */
    public function index()
    {
        $pesanans = Pesanan::where('user_id', auth()->id())
            ->with('tiket')  // Eager load relasi tiket
            ->latest()       // Urut dari yang terbaru
            ->paginate(10);  // 10 per halaman

        return view('pesanan.index', compact('pesanans'));
    }

    /**
     * Form pemesanan tiket
     * Ambil tiket dari parameter tiket_id (dari URL atau session)
     * Cek juga status buka/tutup wisata
     */
    public function create(Request $request)
    {
        $tiket = Tiket::findOrFail($request->tiket_id ?? session('tiket_id'));
        $isOpen = JadwalOperasional::isOpenNow();
        return view('pesanan.create', compact('tiket', 'isOpen'));
    }

    /**
     * Simpan pesanan baru ke database
     * 1. Cek apakah wisata sedang buka (jam operasional)
     * 2. Validasi input (tiket_id, tanggal, jumlah)
     * 3. Cek stok tiket cukup
     * 4. Hitung total = harga x jumlah
     * 5. Buat pesanan dengan status 'pending'
     */
    public function store(Request $request)
    {
        // Cek apakah wisata sedang buka - jika tutup, blokir pemesanan
        if (!JadwalOperasional::isOpenNow()) {
            return back()->withErrors([
                'jumlah' => 'Maaf, pemesanan tiket tidak dapat dilakukan saat wisata tutup. Silakan coba lagi pada jam operasional.',
            ])->withInput();
        }

        // Validasi input
        $validated = $request->validate([
            'tiket_id' => ['required', 'exists:tiket,id'],
            'tanggal_kunjungan' => ['required', 'date', 'after_or_equal:today'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $tiket = Tiket::findOrFail($validated['tiket_id']);

        // Cek stok tersedia
        if ($tiket->stok < $validated['jumlah']) {
            return back()->withErrors(['jumlah' => 'Stok tiket tidak mencukupi. Stok tersedia: ' . $tiket->stok]);
        }

        // Hitung total pembayaran
        $total = $tiket->harga * $validated['jumlah'];

        // Buat pesanan baru
        Pesanan::create([
            'user_id' => auth()->id(),
            'tiket_id' => $validated['tiket_id'],
            'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
            'jumlah' => $validated['jumlah'],
            'total' => $total,
            'status' => 'pending',  // Default pending, menunggu verifikasi
        ]);

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dibuat! Silakan upload bukti pembayaran.');
    }

    /**
     * Detail pesanan user
     * Hanya bisa lihat pesanan sendiri
     */
    public function show($id)
    {
        $pesanan = Pesanan::where('user_id', auth()->id())->findOrFail($id);
        $pesanan->load('tiket');

        return view('pesanan.show', compact('pesanan'));
    }

    /**
     * Cetak tiket (e-ticket) dalam bentuk HTML yang bisa di-print
     * Hanya bisa cetak jika status = 'diterima'
     */
    public function cetak($id)
{
    $pesanan = Pesanan::where('user_id', auth()->id())
        ->with(['tiket', 'user'])
        ->findOrFail($id);

    // Tidak bisa cetak jika belum diterima
    if ($pesanan->status !== 'diterima') {
        return redirect()
            ->route('pesanan.show', $id)
            ->withErrors([
                'error' => 'Tiket hanya dapat dicetak setelah pesanan diterima.'
            ]);
    }

    // Data unik yang akan disimpan di dalam QR Code
    $qrData = route('pesanan.show', $pesanan->id);

    // Generate QR Code
    $qrCode = QrCode::size(200)
        ->margin(2)
        ->generate($qrData);

    return view('pesanan.cetak', compact(
        'pesanan',
        'qrCode'
    ));
}

    /**
     * Upload bukti pembayaran
     * 1. Cek pesanan masih pending
     * 2. Validasi file (jpg/jpeg/png/pdf, max 2MB)
     * 3. Simpan file ke storage/bukti_pembayaran
     * 4. Update path file di database
     */
    public function bayar(Request $request, $id)
    {
        $pesanan = Pesanan::where('user_id', auth()->id())->findOrFail($id);

        // Tidak bisa bayar jika bukan pending
        if ($pesanan->status !== 'pending') {
            return back()->withErrors(['error' => 'Pesanan sudah diproses atau tidak dapat dibayar.']);
        }

        // Validasi file bukti pembayaran
        $request->validate([
            'bukti_pembayaran' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        // Simpan file
        $file = $request->file('bukti_pembayaran');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

        // Update database
        $pesanan->update([
            'bukti_pembayaran' => $path,
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}
