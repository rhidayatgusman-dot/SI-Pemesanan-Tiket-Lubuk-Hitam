<?php

namespace Database\Seeders;

use App\Models\Tiket;
use Illuminate\Database\Seeder;

class TiketSeeder extends Seeder
{
    public function run(): void
    {
        $tikets = [
            [
                'nama_tiket' => 'Tiket Masuk Reguler',
                'deskripsi' => 'Tiket masuk area air terjun Lubuk Hitam. Termasuk akses ke area pemandian dan spot foto utama.',
                'harga' => 12000,
                'kategori' => 'Reguler',
                'stok' => 200,
            ],
            [
                'nama_tiket' => 'Tiket Masuk Weekend',
                'deskripsi' => 'Tiket masuk khusus akhir pekan (Sabtu-Minggu). Termasuk akses ke semua area wisata air terjun.',
                'harga' => 15000,
                'kategori' => 'Weekend',
                'stok' => 150,
            ],
            [
                'nama_tiket' => 'Tiket Grup (10+ orang)',
                'deskripsi' => 'Tiket khusus rombongan minimal 10 orang. Harga per orang. Termasuk area khusus dan pemandu.',
                'harga' => 10000,
                'kategori' => 'Grup',
                'stok' => 100,
            ],
        ];

        foreach ($tikets as $tiket) {
            Tiket::create($tiket);
        }
    }
}
