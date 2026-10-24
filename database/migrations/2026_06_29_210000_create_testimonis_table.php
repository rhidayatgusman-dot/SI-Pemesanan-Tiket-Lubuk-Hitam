<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: buat tabel testimonis
     * Menyimpan testimoni/komentar dari pengunjung
     */
    public function up(): void
    {
        Schema::create('testimonis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');              // Nama pengunjung
            $table->string('email')->nullable(); // Email (opsional)
            $table->tinyInteger('rating');       // Rating 1-5
            $table->text('komentar');            // Isi testimoni
            $table->boolean('is_approved')->default(false); // Approval admin
            $table->timestamps();
        });
    }

    /**
     * Rollback: hapus tabel testimonis
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonis');
    }
};
