<?php

namespace Database\Seeders;

use App\Models\Pesanan;
use App\Models\Tiket;
use App\Models\User;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        $pengunjung = User::where('role', 'pengunjung')->get();
        $tikets = Tiket::all();
        $statuses = ['pending', 'diterima', 'ditolak'];

        for ($i = 0; $i < 25; $i++) {
            $tiket = $tikets->random();
            $jumlah = rand(1, 5);
            $total = $tiket->harga * $jumlah;
            $status = $statuses[array_rand($statuses)];

            Pesanan::create([
                'user_id' => $pengunjung->random()->id,
                'tiket_id' => $tiket->id,
                'tanggal_kunjungan' => now()->addDays(rand(1, 30))->format('Y-m-d'),
                'jumlah' => $jumlah,
                'total' => $total,
                'status' => $status,
                'bukti_pembayaran' => $status === 'diterima' ? 'bukti_pembayaran/sample_' . ($i + 1) . '.jpg' : null,
                'catatan' => $status === 'ditolak' ? 'Pembayaran tidak valid' : null,
            ]);
        }
    }
}
