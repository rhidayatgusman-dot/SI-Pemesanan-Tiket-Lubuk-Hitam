@extends('layouts.admin')
@section('title', 'Detail Pesanan')
@section('content')
<div class="animate-fadeInUp max-w-3xl">
    <h1 class="text-3xl font-bold mb-6">Detail Pesanan #{{ $pesanan->id }}</h1>
    <div class="bg-white rounded-xl shadow-md p-8">
        <div class="mb-6">
            <span class="px-4 py-2 rounded-full text-sm font-semibold @if($pesanan->status=='pending') bg-yellow-100 text-yellow-700 @elseif($pesanan->status=='diterima') bg-green-100 text-green-700 @else bg-red-100 text-red-700 @endif">
                Status: {{ ucfirst($pesanan->status) }}
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="font-semibold text-gray-500 mb-2">Info Pemesan</h3>
                <div class="space-y-2">
                    <p><span class="text-gray-500">Nama:</span> <span class="font-medium">{{ $pesanan->user->name }}</span></p>
                    <p><span class="text-gray-500">WhatsApp:</span> <span class="font-medium">{{ $pesanan->user->no_wa }}</span></p>
                </div>
            </div>
            <div>
                <h3 class="font-semibold text-gray-500 mb-2">Info Pesanan</h3>
                <div class="space-y-2">
                    <p><span class="text-gray-500">Tiket:</span> <span class="font-medium">{{ $pesanan->tiket->nama_tiket }}</span></p>
                    <p><span class="text-gray-500">Kunjungan:</span> <span class="font-medium">{{ $pesanan->tanggal_kunjungan->format('d M Y') }}</span></p>
                    <p><span class="text-gray-500">Jumlah:</span> <span class="font-medium">{{ $pesanan->jumlah }} tiket</span></p>
                    <p><span class="text-gray-500">Total:</span> <span class="font-bold text-emerald-600">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</span></p>
                </div>
            </div>
        </div>
        @if($pesanan->bukti_pembayaran)
        <div class="mb-6">
            <h3 class="font-semibold text-gray-500 mb-2">Bukti Pembayaran</h3>
            @if(str_ends_with($pesanan->bukti_pembayaran, '.pdf'))
                <a href="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" target="_blank" class="text-emerald-600 hover:underline">Lihat PDF</a>
            @else
                <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" class="max-w-md rounded-lg shadow" alt="Bukti Pembayaran">
            @endif
        </div>
        @endif
        @if($pesanan->catatan)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-blue-800 mb-1">Catatan:</h3>
            <p class="text-blue-700">{{ $pesanan->catatan }}</p>
        </div>
        @endif
        @if($pesanan->status == 'pending')
        <div class="border-t pt-6">
            <h3 class="font-semibold mb-4">Aksi</h3>
            <div class="flex space-x-4">
                <form method="POST" action="{{ route('admin.pesanan.terima', $pesanan->id) }}">
                    @csrf
                    <input type="hidden" name="catatan" value="Pesanan diterima oleh admin.">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors" onclick="return confirm('Terima pesanan ini?')">Terima</button>
                </form>
                <form method="POST" action="{{ route('admin.pesanan.tolak', $pesanan->id) }}">
                    @csrf
                    <input type="hidden" name="catatan" value="Pesanan ditolak oleh admin.">
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors" onclick="return confirm('Tolak pesanan ini?')">Tolak</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
