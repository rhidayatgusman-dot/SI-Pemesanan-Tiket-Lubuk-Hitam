<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Pesanan - Merepresentasikan pemesanan tiket oleh user
 * 
 * Tabel: pesanans
 * Kolom utama: user_id, tiket_id, tanggal_kunjungan, jumlah, total, 
 *              bukti_pembayaran, status, catatan
 * 
 * Alur Status Pesanan:
 * 1. pending    - Baru dibuat, menunggu upload bukti bayar
 * 2. diterima   - Admin verifikasi pembayaran & stok cukup
 * 3. ditolak    - Admin tolak (pembayaran tidak valid, dll)
 * 
 * Relasi:
 * - belongsTo User: Pesanan ini milik siapa
 * - belongsTo Tiket: Memesan tiket jenis apa
 */
class Pesanan extends Model
{
    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'user_id',
        'tiket_id',
        'tanggal_kunjungan',
        'jumlah',
        'total',
        'bukti_pembayaran',
        'status',
        'catatan',
    ];

    // Casting tipe data otomatis
    protected $casts = [
        'tanggal_kunjungan' => 'date', // String tanggal jadi objek Carbon
    ];

    /**
     * Relasi: Pesanan ini milik user siapa
     * Digunakan untuk menampilkan nama pemesan di detail pesanan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Pesanan ini untuk tiket jenis apa
     * Digunakan untuk menampilkan nama tiket, harga, kategori
     */
    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    /**
     * Accessor: Mendapatkan warna badge berdasarkan status
     * Dipakai di view untuk menampilkan warna yang sesuai
     * 
     * @return string warna (yellow/green/red/gray)
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',  // Menunggu verifikasi
            'diterima' => 'green',  // Sudah disetujui
            'ditolak' => 'red',     // Ditolak
            default => 'gray',      // Status lain
        };
    }
}
