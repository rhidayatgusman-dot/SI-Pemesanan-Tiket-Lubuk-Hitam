@extends('layouts.app')

@section('title', 'Foto Saya')

@section('content')
<div class="container mx-auto px-4 py-12 pt-24 relative z-10">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-teal-800 mb-3">Foto Saya</h1>
        <p class="text-gray-600 max-w-xl mx-auto">Kelola dan pantau status foto kunjungan Anda</p>
    </div>

    @if(session('success'))
    <div class="max-w-2xl mx-auto mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-2xl mx-auto mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        {{ session('error') }}
    </div>
    @endif

    @if(session('info'))
    <div class="max-w-2xl mx-auto mb-6 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg">
        {{ session('info') }}
    </div>
    @endif

    {{-- Info --}}
    <div class="text-center mb-8">
        <p class="text-gray-600">Upload foto kunjungan dapat dilakukan dari halaman <a href="{{ route('pesanan.index') }}" class="text-teal-600 font-semibold hover:underline">Pesanan Saya</a> &rarr; Detail Pesanan.</p>
    </div>

    @if($galeris->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($galeris as $g)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="h-48 overflow-hidden relative">
                <img src="{{ asset('storage/' . $g->foto) }}" alt="{{ $g->caption ?? 'Foto' }}" class="w-full h-full object-cover">
                {{-- Status Badge --}}
                <div class="absolute top-2 right-2">
                    @if($g->status === 'pending')
                        <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">Pending</span>
                    @elseif($g->status === 'disetujui')
                        <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">Disetujui</span>
                    @else
                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">Ditolak</span>
                    @endif
                </div>
            </div>
            <div class="p-4">
                @if($g->caption)
                <p class="text-gray-700 text-sm mb-2 line-clamp-2">{{ $g->caption }}</p>
                @endif
                <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                    <span>📅 {{ $g->tanggal_kunjungan->format('d M Y') }}</span>
                    <span>{{ $g->created_at->format('d M Y') }}</span>
                </div>

                {{-- Status Info --}}
                <div class="text-xs mb-3">
                    @if($g->status === 'pending')
                        <p class="text-yellow-600">⏳ Menunggu persetujuan admin</p>
                    @elseif($g->status === 'disetujui')
                        <p class="text-green-600">✅ Foto ditampilkan di galeri</p>
                    @else
                        <p class="text-red-600">❌ Foto tidak disetujui</p>
                    @endif
                </div>

                {{-- Hapus --}}
                <form method="POST" action="{{ route('galeri.destroy', $g->id) }}" onsubmit="return confirm('Yakin hapus foto ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 text-xs hover:text-red-700 font-semibold">
                        🗑 Hapus Foto
                    </button>
                </form>
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
        <p class="text-gray-500 text-lg">Anda belum mengunggah foto.</p>
        <p class="text-gray-400 mt-2">Upload foto kunjungan Anda sekarang!</p>
    </div>
    @endif
</div>
@endsection
