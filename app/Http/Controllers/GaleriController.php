<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * GaleriController - Upload & kelola foto galeri pengunjung
 * 
 * Alur:
 * 1. Pengunjung upload foto + caption + tanggal kunjungan
 * 2. Foto disimpan dengan status 'pending'
 * 3. Admin approve/reject di dashboard admin
 * 4. Foto yang disetujui tampil di beranda
 */
class GaleriController extends Controller
{
    /**
     * Halaman daftar galeri foto pengunjung (yang sudah disetujui)
     */
    public function index()
    {
        $galeris = Galeri::disetujui()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('galeri.index', compact('galeris'));
    }

    /**
     * Foto saya - pengunjung bisa lihat status foto yang diunggah
     */
    public function saya()
    {
        $galeris = Galeri::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('galeri.saya', compact('galeris'));
    }

    /**
     * Form upload foto - redirect ke halaman pesanan karena upload sekarang dari Detail Pesanan
     */
    public function create()
    {
        return redirect()->route('pesanan.index')
            ->with('info', 'Upload foto kunjungan dapat dilakukan dari halaman Detail Pesanan.');
    }

    /**
     * Simpan foto upload
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'caption' => ['nullable', 'string', 'max:255'],
            'tanggal_kunjungan' => ['required', 'date', 'before_or_equal:today'],
        ], [
            'foto.required' => 'Silakan pilih foto yang akan diunggah.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 5 MB.',
            'tanggal_kunjungan.required' => 'Tanggal kunjungan wajib diisi.',
            'tanggal_kunjungan.before_or_equal' => 'Tanggal kunjungan tidak boleh lebih dari hari ini.',
        ]);

        // Simpan foto dengan nama unik di folder gallery
        $file = $request->file('foto');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('gallery', $filename, 'public');

        // Simpan ke database
        Galeri::create([
            'user_id' => auth()->id(),
            'foto' => $path,
            'caption' => $validated['caption'] ?? null,
            'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
            'status' => 'pending',
        ]);

        return redirect()->route('galeri.saya')->with('success', 'Foto berhasil diunggah dan sedang menunggu persetujuan admin.');
    }

    /**
     * Hapus foto milik sendiri
     */
    public function destroy($id)
    {
        $galeri = Galeri::where('user_id', auth()->id())->findOrFail($id);
        $galeri->hapusFoto();
        $galeri->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
