<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User - Merepresentasikan pengguna sistem (admin dan pengunjung)
 * 
 * Tabel: users
 * Kolom utama: name, no_wa (nomor WhatsApp), password, role (admin/pengunjung)
 * 
 * Autentikasi:
 * - Login: menggunakan nomor WhatsApp + password
 * - Registrasi: menggunakan nomor WhatsApp + OTP verifikasi
 * 
 * Relasi:
 * - hasMany Pesanan: Satu user bisa memiliki banyak pesanan tiket
 * 
 * Role:
 * - admin: Akses ke dashboard admin, kelola tiket, pesanan, laporan, user
 * - pengunjung: Bisa melihat tiket, membuat pesanan, upload bukti bayar
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'name',
        'no_wa',
        'password',
        'role',
    ];

    // Kolom yang disembunyikan saat convert ke array/JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting tipe data otomatis
    protected function casts(): array
    {
        return [
            'password' => 'hashed', // Password otomatis di-hash
        ];
    }

    /**
     * Relasi: User memiliki banyak pesanan
     * Digunakan untuk mengambil semua pesanan milik user ini
     */
    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }

    /**
     * Cek apakah user adalah admin
     * @return bool true jika role = admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
