@extends('layouts.app')
@section('title', 'Pesanan Saya')
@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-8">Pesanan Saya</h1>
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Tanggal Pesan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Tiket</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Kunjungan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($pesanans as $pesanan)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $pesanan->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $pesanan->tiket->nama_tiket }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $pesanan->tanggal_kunjungan->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $pesanan->jumlah }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-800">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($pesanan->status == 'pending') bg-yellow-100 text-yellow-700
                            @elseif($pesanan->status == 'diterima') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($pesanan->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-3">
                            <a href="{{ route('pesanan.show', $pesanan->id) }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">Detail</a>
                            @if($pesanan->status == 'diterima')
                            <a href="{{ route('pesanan.cetak', $pesanan->id) }}" target="_blank" class="text-cyan-600 hover:text-cyan-700 text-sm font-medium">🖨️ Cetak</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-600">Belum ada pesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $pesanans->links() }}</div>
</div>
@endsection
