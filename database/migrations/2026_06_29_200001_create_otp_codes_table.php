<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel otp_codes untuk menyimpan kode OTP registrasi.
     * Digunakan saat user mendaftar dengan nomor WhatsApp.
     * OTP dikirim via WhatsApp (simulasi di sistem ini).
     */
    public function up(): void
    {
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->id();
            $table->string('no_wa');           // Nomor WhatsApp tujuan
            $table->string('kode');             // Kode OTP 6 digit
            $table->timestamp('expired_at');    // Waktu kadaluarsa
            $table->boolean('sudah_dipakai')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_codes');
    }
};
