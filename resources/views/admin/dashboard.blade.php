@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="animate-fadeInUp">
    <h1 class="text-3xl font-bold mb-8">Dashboard</h1>
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div><p class="text-gray-500 text-sm">Total Tiket</p><p class="text-3xl font-bold text-gray-800">{{ $totalTiket }}</p></div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div><p class="text-gray-500 text-sm">Total Pesanan</p><p class="text-3xl font-bold text-gray-800">{{ $totalPesanan }}</p></div>
                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div><p class="text-gray-500 text-sm">Pesanan Pending</p><p class="text-3xl font-bold text-yellow-600">{{ $pesananPending }}</p></div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between">
                <div><p class="text-gray-500 text-sm">Pendapatan</p><p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($pendapatan, 0, ',', '.') }}</p></div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>
    <!-- Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Pesanan Terbaru</h2>
            <table class="w-full">
                <thead><tr class="border-b"><th class="text-left py-2 text-sm text-gray-500">Pemesan</th><th class="text-left py-2 text-sm text-gray-500">Tiket</th><th class="text-left py-2 text-sm text-gray-500">Status</th></tr></thead>
                <tbody>
                    @foreach($pesananTerbaru as $p)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 text-sm">{{ $p->user->name }}</td>
                        <td class="py-3 text-sm">{{ Str::limit($p->tiket->nama_tiket, 20) }}</td>
                        <td class="py-3"><span class="px-2 py-1 rounded-full text-xs font-semibold @if($p->status=='pending') bg-yellow-100 text-yellow-700 @elseif($p->status=='diterima') bg-green-100 text-green-700 @else bg-red-100 text-red-700 @endif">{{ ucfirst($p->status) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">Tiket Terlaris</h2>
            <table class="w-full">
                <thead><tr class="border-b"><th class="text-left py-2 text-sm text-gray-500">Tiket</th><th class="text-left py-2 text-sm text-gray-500">Kategori</th><th class="text-right py-2 text-sm text-gray-500">Terjual</th></tr></thead>
                <tbody>
                    @foreach($tiketTerlaris as $t)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 text-sm">{{ Str::limit($t->nama_tiket, 25) }}</td>
                        <td class="py-3 text-sm">{{ $t->kategori }}</td>
                        <td class="py-3 text-sm text-right font-semibold">{{ $t->pesanans_count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
