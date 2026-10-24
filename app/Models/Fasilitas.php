<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Fasilitas - Master data fasilitas wisata
 * 
 * Tabel: fasilitas
 * Kolom: id, nama, icon, deskripsi, is_active, urutan, timestamps
 */
class Fasilitas extends Model
{
    protected $table = 'fasilitas';

    protected $fillable = ['nama', 'icon', 'deskripsi', 'is_active', 'urutan'];

    protected $casts = ['is_active' => 'boolean'];

    public function galeriFotos()
    {
        return $this->hasMany(GaleriFasilitas::class);
    }

    public function galeriAktif()
    {
        return $this->hasMany(GaleriFasilitas::class)->where('status', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('urutan');
    }
}
