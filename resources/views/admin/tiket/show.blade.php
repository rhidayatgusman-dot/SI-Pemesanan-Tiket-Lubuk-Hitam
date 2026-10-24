@extends('layouts.admin')
@section('title', 'Detail Tiket')
@section('content')
<div class="animate-fadeInUp max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Detail Tiket</h1>
    <div class="bg-white rounded-xl shadow-md p-8">
        @if($tiket->gambar)
        <img src="{{ asset('storage/' . $tiket->gambar) }}" class="w-full h-64 object-cover rounded-lg mb-6" alt="{{ $tiket->nama_tiket }}">
        @endif
        <div class="space-y-3">
            <div class="flex justify-between py-2 border-b"><span class="text-gray-500">Nama</span><span class="font-medium">{{ $tiket->nama_tiket }}</span></div>
            <div class="flex justify-between py-2 border-b"><span class="text-gray-500">Kategori</span><span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-sm">{{ $tiket->kategori }}</span></div>
            <div class="flex justify-between py-2 border-b"><span class="text-gray-500">Harga</span><span class="font-bold text-emerald-600">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</span></div>
            <div class="flex justify-between py-2 border-b"><span class="text-gray-500">Stok</span><span class="font-medium">{{ $tiket->stok }}</span></div>
            <div class="py-2"><span class="text-gray-500 block mb-1">Deskripsi</span><p>{{ $tiket->deskripsi }}</p></div>
        </div>
        <div class="mt-6 flex space-x-4">
            <a href="{{ route('admin.tiket.edit', $tiket->id) }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">Edit</a>
            <a href="{{ route('admin.tiket.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors">Kembali</a>
        </div>
    </div>
</div>
@endsection
