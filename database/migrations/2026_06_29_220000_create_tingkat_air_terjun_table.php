<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration: buat tabel tingkat_air_terjun
     * Menyimpan data 3 tingkat air terjun yang bisa dikelola admin
     */
    public function up(): void
    {
        Schema::create('tingkat_air_terjun', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('tingkat');              // 1, 2, atau 3
            $table->string('nama');                      // Nama tingkat (misal: "Kolam Penerimaan")
            $table->text('deskripsi');                   // Deskripsi lengkap
            $table->string('foto')->nullable();          // Path foto (storage)
            $table->string('tag1')->nullable();          // Tag fitur 1
            $table->string('tag2')->nullable();          // Tag fitur 2
            $table->string('tag3')->nullable();          // Tag fitur 3
            $table->string('gradient')->default('from-teal-400 via-cyan-500 to-blue-500'); // Gradient warna
            $table->string('emoji')->default('💧');      // Emoji ikon
            $table->boolean('is_active')->default(true); // Aktif/tidak ditampilkan
            $table->integer('urutan')->default(0);       // Urutan tampil
            $table->timestamps();
        });
    }

    /**
     * Rollback: hapus tabel tingkat_air_terjun
     */
    public function down(): void
    {
        Schema::dropIfExists('tingkat_air_terjun');
    }
};
