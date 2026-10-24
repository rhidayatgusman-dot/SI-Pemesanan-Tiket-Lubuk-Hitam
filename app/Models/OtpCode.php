<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model OtpCode - Menyimpan kode OTP untuk verifikasi registrasi
 * 
 * Tabel: otp_codes
 * Kolom: no_wa, kode, expired_at, sudah_dipakai
 * 
 * Alur:
 * 1. User minta OTP -> generate kode 6 digit random
 * 2. Simpan ke tabel dengan expired 5 menit
 * 3. User masukkan kode -> verifikasi di controller
 * 4. Jika valid -> tandai sudah_dipakai = true
 */
class OtpCode extends Model
{
    protected $table = 'otp_codes';

    protected $fillable = [
        'no_wa',
        'kode',
        'expired_at',
        'sudah_dipakai',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'sudah_dipakai' => 'boolean',
    ];

    /**
     * Generate kode OTP 6 digit acak
     * @return string kode 6 digit
     */
    public static function generateKode()
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Cek apakah OTP masih berlaku (belum expired dan belum dipakai)
     * @return bool
     */
    public function masihBerlaku()
    {
        return !$this->sudah_dipakai && $this->expired_at->isFuture();
    }
}
