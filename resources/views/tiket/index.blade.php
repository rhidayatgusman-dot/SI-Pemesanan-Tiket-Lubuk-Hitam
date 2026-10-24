@extends('layouts.app')

@section('title', 'Daftar Tiket')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-center mb-4 text-teal-800">Daftar Tiket</h1>
    <p class="text-center text-gray-600 mb-8">Pilih tiket wisata yang sesuai dengan keinginan Anda</p>

    <!-- Filter & Search -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('tiket.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tiket..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            </div>
            <div>
                <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>{{ $kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Urutkan</option>
                    <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Termahal</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Tiket Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($tikets as $tiket)
            <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                <div class="h-48 bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                    @if($tiket->gambar)
                        <img src="{{ asset('storage/' . $tiket->gambar) }}" alt="{{ $tiket->nama_tiket }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-emerald-600 font-semibold">{{ $tiket->kategori }}</span>
                        <span class="text-sm text-gray-600">Stok: {{ $tiket->stok }}</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">{{ $tiket->nama_tiket }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $tiket->deskripsi }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-emerald-600">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</span>
                        <a href="{{ route('tiket.show', $tiket->id) }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition-colors">
                            Pesan
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-600">Tidak ada tiket yang ditemukan</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $tikets->links() }}
    </div>
</div>
@endsection
