<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model JadwalOperasional - Mengatur jam buka/tutup wisata per hari
 * 
 * Tabel: jadwal_operasional
 * Kolom utama: hari, jam_buka, jam_tutup, is_libur, keterangan
 * 
 * Fungsi:
 * - Menampilkan status buka/tutup di landing page
 * - Admin bisa edit jadwal per hari (Senin-Minggu)
 * - Bisa menandai hari tertentu sebagai hari libur
 */
class JadwalOperasional extends Model
{
    // Custom table name
    protected $table = 'jadwal_operasional';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'hari',
        'jam_buka',
        'jam_tutup',
        'is_libur',
        'keterangan',
    ];

    // Casting: is_libur otomatis jadi boolean (0/1)
    protected $casts = [
        'is_libur' => 'boolean',
    ];

    /**
     * Mendapatkan jadwal untuk hari ini
     * Mengkonversi nama hari dari English ke Indonesia
     * 
     * @return JadwalOperasional|null jadwal hari ini atau null jika tidak ada
     */
    public static function getHariIni()
    {
        // Mapping nama hari English -> Indonesia
        $hariIndonesia = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        // Dapatkan nama hari sekarang dalam bahasa Inggris
        $hariInggris = now()->locale('en')->dayName;
        $hari = $hariIndonesia[$hariInggris];

        // Cari jadwal untuk hari ini
        return self::where('hari', $hari)->first();
    }

    /**
     * Cek apakah wisata sedang buka hari ini
     * Logika: Cek jadwal hari ini -> jika ada dan bukan libur, berarti buka
     * Status buka/tutup disesuaikan dengan jadwal yang dikelola admin
     * 
     * @return bool true jika hari ini ada jadwal dan bukan hari libur
     */
    public static function isOpenNow()
    {
        $jadwal = self::getHariIni();

        // Jika tidak ada jadwal atau hari libur, berarti tutup
        if (!$jadwal || $jadwal->is_libur) {
            return false;
        }

        // Jika ada jadwal dan bukan libur, berarti buka
        return true;
    }
}
