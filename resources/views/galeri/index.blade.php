@extends('layouts.app')

@section('title', 'Galeri Pengunjung')

@section('content')
<div class="container mx-auto px-4 py-12 pt-24 relative z-10">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-teal-800 mb-3">Galeri Pengunjung</h1>
        <p class="text-gray-600 max-w-xl mx-auto">Momen-momen berharga pengunjung di Air Terjun Lubuk Hitam</p>
    </div>

    @if(session('success'))
    <div class="max-w-2xl mx-auto mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    @auth
    <div class="text-center mb-8">
        <a href="{{ route('galeri.saya') }}" class="inline-block border-2 border-teal-500 text-teal-700 px-8 py-3 rounded-full font-bold hover:bg-teal-50 transition-all">
            Foto Saya
        </a>
    </div>
    @endauth

    @if($galeris->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($galeris as $g)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
            <div class="h-56 overflow-hidden">
                <img src="{{ asset('storage/' . $g->foto) }}" alt="{{ $g->caption ?? 'Foto pengunjung' }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
            </div>
            <div class="p-4">
                @if($g->caption)
                <p class="text-gray-700 text-sm mb-2 line-clamp-2">{{ $g->caption }}</p>
                @endif
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <span>👤 {{ $g->user->name }}</span>
                    <span>{{ $g->tanggal_kunjungan->format('d M Y') }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $galeris->links() }}
    </div>
    @else
    <div class="text-center py-16">
        <div class="text-6xl mb-4">📷</div>
        <p class="text-gray-500 text-lg">Belum ada foto galeri pengunjung.</p>
        @auth
        <p class="text-gray-400 mt-2">Jadilah yang pertama mengunggah foto kunjungan Anda!</p>
        @endauth
    </div>
    @endif
</div>
@endsection
