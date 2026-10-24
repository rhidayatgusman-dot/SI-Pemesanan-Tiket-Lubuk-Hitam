<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model TingkatAirTerjun - Mengelola data 3 tingkat air terjun
 * 
 * Tabel: tingkat_air_terjun
 * Kolom: id, tingkat (1-3), nama, deskripsi, foto, tag1-3, gradient, emoji, is_active, urutan
 * 
 * Fitur:
 * - Admin bisa CRUD tingkat air terjun (nama, deskripsi, foto, tag)
 * - Foto ditampilkan saat card tingkat di-klik (modal/lightbox)
 * - Hanya tingkat yang is_active = true yang tampil di beranda
 * - Urutan tampil bisa diatur admin
 */
class TingkatAirTerjun extends Model
{
    protected $table = 'tingkat_air_terjun';

    protected $fillable = [
        'tingkat',
        'nama',
        'deskripsi',
        'foto',
        'tag1',
        'tag2',
        'tag3',
        'gradient',
        'emoji',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope: hanya yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }

    /**
     * Ambil semua tag yang tidak null
     * @return array tag-tag fitur
     */
    public function getTagsAttribute()
    {
        return array_filter([$this->tag1, $this->tag2, $this->tag3]);
    }
}
