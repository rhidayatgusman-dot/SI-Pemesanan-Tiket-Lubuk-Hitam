<?php

namespace Database\Seeders;

use App\Models\JadwalOperasional;
use Illuminate\Database\Seeder;

class JadwalOperasionalSeeder extends Seeder
{
    public function run(): void
    {
        $jadwal = [
            ['hari' => 'Senin', 'jam_buka' => '08:00', 'jam_tutup' => '17:00', 'is_libur' => false, 'keterangan' => null],
            ['hari' => 'Selasa', 'jam_buka' => '08:00', 'jam_tutup' => '17:00', 'is_libur' => false, 'keterangan' => null],
            ['hari' => 'Rabu', 'jam_buka' => '08:00', 'jam_tutup' => '17:00', 'is_libur' => false, 'keterangan' => null],
            ['hari' => 'Kamis', 'jam_buka' => '08:00', 'jam_tutup' => '17:00', 'is_libur' => false, 'keterangan' => null],
            ['hari' => 'Jumat', 'jam_buka' => '08:00', 'jam_tutup' => '17:00', 'is_libur' => false, 'keterangan' => null],
            ['hari' => 'Sabtu', 'jam_buka' => '07:00', 'jam_tutup' => '18:00', 'is_libur' => false, 'keterangan' => 'Jam extended weekend'],
            ['hari' => 'Minggu', 'jam_buka' => '07:00', 'jam_tutup' => '18:00', 'is_libur' => false, 'keterangan' => 'Jam extended weekend'],
        ];

        foreach ($jadwal as $data) {
            JadwalOperasional::create($data);
        }
    }
}
