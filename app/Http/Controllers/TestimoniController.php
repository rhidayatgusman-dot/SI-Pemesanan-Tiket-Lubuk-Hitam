<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;

/**
 * TestimoniController - Menangani komentar/testimoni dari pengunjung
 * 
 * Alur:
 * 1. Pengunjung (guest/user) isi form: nama, rating, komentar
 * 2. Submit -> simpan ke database dengan is_approved = false
 * 3. Admin approve -> testimoni tampil di beranda
 * 
 * Note: Pengunjung tidak perlu login untuk mengirim testimoni
 */
class TestimoniController extends Controller
{
    /**
     * Simpan testimoni baru dari pengunjung
     * 1. Validasi input (nama, rating, komentar)
     * 2. Simpan ke database (is_approved = false)
     * 3. Redirect kembali dengan pesan sukses
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'komentar' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'nama.required' => 'Nama harus diisi.',
            'rating.required' => 'Rating harus diisi.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'komentar.required' => 'Komentar harus diisi.',
            'komentar.min' => 'Komentar minimal 10 karakter.',
            'komentar.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        Testimoni::create([
            'nama' => $validated['nama'],
            'rating' => $validated['rating'],
            'komentar' => $validated['komentar'],
            'is_approved' => false, // Menunggu approval admin
        ]);

        return redirect()->route('beranda')
            ->with('success', 'Terima kasih! Testimoni Anda akan ditampilkan setelah diverifikasi oleh admin.');
    }
}
