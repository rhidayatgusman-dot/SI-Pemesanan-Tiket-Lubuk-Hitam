<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * Model GaleriFasilitas - Foto galeri untuk setiap fasilitas
 * 
 * Tabel: galeri_fasilitas
 * Kolom: id, fasilitas_id, judul, deskripsi, foto, status, timestamps
 */
class GaleriFasilitas extends Model
{
    protected $table = 'galeri_fasilitas';

    protected $fillable = ['fasilitas_id', 'judul', 'deskripsi', 'foto', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }

    public function hapusFoto()
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            Storage::disk('public')->delete($this->foto);
        }
    }
}
