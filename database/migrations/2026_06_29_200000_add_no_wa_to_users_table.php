<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Menambahkan kolom no_wa ke tabel users untuk autentikasi via WhatsApp.
     * Catatan: SQLite tidak mendukung ALTER COLUMN, jadi email tetap NOT NULL di level schema
     * tapi bisa diisi null di aplikasi (Laravel tidak enforce NOT NULL di SQLite).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_wa')->unique()->nullable()->after('email');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('no_wa');
        });
    }
};
