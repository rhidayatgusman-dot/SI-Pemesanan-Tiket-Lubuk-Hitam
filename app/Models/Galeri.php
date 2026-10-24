<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Model Galeri - Foto galeri pengunjung
 * 
 * Tabel: galeri
 * Kolom: id, user_id, foto, caption, tanggal_kunjungan, status, created_at, updated_at
 * 
 * Status: pending, disetujui, ditolak
 * Hanya foto berstatus 'disetujui' yang tampil di beranda
 */
class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = [
        'user_id',
        'foto',
        'caption',
        'tanggal_kunjungan',
        'status',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
    ];

    /**
     * Relasi: Galeri milik seorang user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: hanya yang disetujui
     */
    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    /**
     * Scope: hanya yang pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Hapus foto dari storage saat model dihapus
     */
    public function hapusFoto()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            Storage::disk('public')->delete($this->foto);
        }
    }
}
