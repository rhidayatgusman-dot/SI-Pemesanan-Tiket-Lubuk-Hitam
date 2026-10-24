@extends('layouts.admin')
@section('title', 'Laporan')
@section('content')
<div class="animate-fadeInUp">
    <h1 class="text-3xl font-bold mb-6">Laporan</h1>
    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
            </div>
            <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition-colors">Filter</button>
            <a href="{{ route('admin.laporan.cetak-pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="bg-gradient-to-r from-red-600 to-rose-600 text-white px-6 py-2 rounded-lg hover:from-red-700 hover:to-rose-700 transition-colors text-center font-semibold flex items-center justify-center gap-2">
                📄 Cetak PDF
            </a>
        </form>
    </div>
    <!-- Summary -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <p class="text-gray-500 text-sm">Total Pendapatan</p>
            <p class="text-3xl font-bold text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6">
            <p class="text-gray-500 text-sm">Total Tiket Terjual</p>
            <p class="text-3xl font-bold text-blue-600">{{ $totalTiketTerjual }}</p>
        </div>
    </div>
    <!-- Chart -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Grafik Pendapatan</h2>
        <canvas id="chart" height="100"></canvas>
    </div>
    <!-- Detail Table -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold mb-4">Detail Pesanan</h2>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px]">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Booking</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Pengunjung</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nomor WhatsApp</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Tiket</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Kunjungan</th>
                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                        <th class="px-3 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Pembayaran</th>
                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pemesanan</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($pesanans as $index => $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-3 text-sm">{{ $index + 1 }}</td>
                        <td class="px-3 py-3 text-sm font-mono text-teal-700">#{{ str_pad($p->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-3 py-3 text-sm font-medium">{{ $p->user->name }}</td>
                        <td class="px-3 py-3 text-sm">{{ $p->user->no_wa }}</td>
                        <td class="px-3 py-3 text-sm">{{ $p->tiket->nama_tiket }}</td>
                        <td class="px-3 py-3 text-sm">{{ $p->tanggal_kunjungan->format('d-m-Y') }}</td>
                        <td class="px-3 py-3 text-sm text-center">{{ $p->jumlah }}</td>
                        <td class="px-3 py-3 text-sm text-right font-semibold">Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                        <td class="px-3 py-3 text-center">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($p->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($p->status == 'diterima') bg-green-100 text-green-700
                                @else bg-red-100 text-red-700 @endif">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td class="px-3 py-3 text-sm">{{ $p->created_at->format('d-m-Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="10" class="px-4 py-8 text-center text-gray-500">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chart').getContext('2d');
const data = @json($pendapatanPerHari);
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: data.map(d => d.tanggal),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: data.map(d => d.total),
            backgroundColor: 'rgba(16, 185, 129, 0.5)',
            borderColor: 'rgb(16, 185, 129)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endpush
@endsection
