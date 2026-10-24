@extends('layouts.admin')

@section('title', 'Galeri Pengunjung')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Galeri Pengunjung</h1>
        <p class="text-gray-500 text-sm">Moderasi foto yang diunggah pengunjung</p>
    </div>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
    {{ session('success') }}
</div>
@endif

{{-- Filter & Search --}}
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" action="{{ route('admin.galeri.index') }}" class="flex flex-col sm:flex-row gap-3">
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau caption..."
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
        <button type="submit" class="bg-teal-500 text-white px-6 py-2 rounded-lg hover:bg-teal-600 transition-colors">Filter</button>
    </form>
</div>

{{-- Gallery Grid --}}
@if($galeris->count() > 0)
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($galeris as $g)
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        {{-- Foto --}}
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

        {{-- Info --}}
        <div class="p-4">
            <div class="mb-2">
                <p class="font-semibold text-gray-800">👤 {{ $g->user->name }}</p>
                <p class="text-xs text-gray-500">{{ $g->tanggal_kunjungan->format('d M Y') }} &bull; {{ $g->created_at->format('d M Y H:i') }}</p>
            </div>
            @if($g->caption)
            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $g->caption }}</p>
            @endif

            {{-- Actions --}}
            <div class="flex gap-2 flex-wrap">
                @if($g->status !== 'disetujui')
                <form method="POST" action="{{ route('admin.galeri.approve', $g->id) }}">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-green-600 transition-colors font-semibold">
                        ✓ Setujui
                    </button>
                </form>
                @endif
                @if($g->status !== 'ditolak')
                <form method="POST" action="{{ route('admin.galeri.reject', $g->id) }}">
                    @csrf
                    <button type="submit" class="bg-yellow-500 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-yellow-600 transition-colors font-semibold">
                        ✗ Tolak
                    </button>
                </form>
                @endif
                <form method="POST" action="{{ route('admin.galeri.destroy', $g->id) }}" onsubmit="return confirm('Yakin hapus foto ini? File juga akan dihapus dari server.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-red-600 transition-colors font-semibold">
                        🗑 Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-6">
    {{ $galeris->links() }}
</div>
@else
<div class="bg-white rounded-xl shadow p-12 text-center">
    <div class="text-6xl mb-4">📷</div>
    <p class="text-gray-500 text-lg">Belum ada foto yang diunggah.</p>
</div>
@endif
@endsection
