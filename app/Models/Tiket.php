<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Tiket - Merepresentasikan jenis tiket wisata
 * 
 * Tabel: tiket (custom table name, bukan 'tikets')
 * Kolom utama: nama_tiket, deskripsi, harga, kategori, stok, gambar
 * 
 * Kategori tiket:
 * - Reguler: Tiket biasa (warna hijau di cetak)
 * - Weekend: Tiket akhir pekan (warna biru di cetak)
 * - Grup: Tiket rombongan (warna teal di cetak)
 * 
 * Relasi:
 * - hasMany Pesanan: Satu jenis tiket bisa dipesan berkali-kali
 */
class Tiket extends Model
{
    // Custom table name karena default Laravel adalah 'tikets' (plural)
    protected $table = 'tiket';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'nama_tiket',
        'deskripsi',
        'harga',
        'kategori',
        'stok',
        'gambar',
    ];

    /**
     * Relasi: Tiket memiliki banyak pesanan
     * Digunakan untuk menghitung tiket terlaris, dll
     */
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }
}
