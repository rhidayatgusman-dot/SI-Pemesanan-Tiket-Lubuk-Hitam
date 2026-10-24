<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Testimoni - Menyimpan komentar/testimoni dari pengunjung
 * 
 * Tabel: testimonis
 * Kolom: id, nama, rating (1-5), komentar, is_approved
 * 
 * Alur:
 * - Pengunjung (guest) bisa kirim testimoni via form di beranda
 * - Testimoni baru default is_approved = false (menunggu approval admin)
 * - Admin bisa approve/reject testimoni di halaman admin
 * - Hanya testimoni yang approved yang tampil di beranda
 */
class Testimoni extends Model
{
    protected $table = 'testimonis';

    protected $fillable = [
        'nama',
        'rating',
        'komentar',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Scope: hanya testimoni yang sudah di-approve
     * Digunakan di beranda untuk menampilkan testimoni
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Generate bintang rating untuk ditampilkan (HTML string)
     * @return string bintang (★ dan ☆)
     */
    public function getBintangAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }

    /**
     * Inisial huruf pertama dari nama (untuk avatar)
     * @return string huruf kapital
     */
    public function getInisialAttribute()
    {
        return strtoupper(substr($this->nama, 0, 1));
    }
}
