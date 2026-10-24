@extends('layouts.admin')
@section('title', 'Galeri Fasilitas')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-teal-800">Galeri Foto Fasilitas</h1>
        <a href="{{ route('admin.galeri-fasilitas.create') }}" class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-teal-700 hover:to-cyan-700 transition-all shadow-md">
            + Tambah Foto
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
        <form method="GET" class="flex flex-wrap items-center gap-3">
            <label class="text-sm font-semibold text-gray-700">Filter Fasilitas:</label>
            <select name="fasilitas_id" onchange="this.form.submit()" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                <option value="">Semua Fasilitas</option>
                @foreach($fasilitass as $f)
                <option value="{{ $f->id }}" {{ request('fasilitas_id') == $f->id ? 'selected' : '' }}>{{ $f->icon }} {{ $f->nama }}</option>
                @endforeach
            </select>
            @if(request('fasilitas_id'))
            <a href="{{ route('admin.galeri-fasilitas.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Reset</a>
            @endif
        </form>
    </div>

    {{-- Grid Galeri --}}
    @if($galeris->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($galeris as $galeri)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="relative">
                <img src="{{ asset('storage/' . $galeri->foto) }}" alt="{{ $galeri->judul }}" class="w-full h-40 object-cover">
                <span class="absolute top-2 right-2 px-2 py-1 rounded-full text-xs font-semibold {{ $galeri->status ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                    {{ $galeri->status ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            <div class="p-3">
                <p class="text-xs text-gray-500 mb-1">{{ $galeri->fasilitas->icon }} {{ $galeri->fasilitas->nama }}</p>
                <p class="font-semibold text-sm text-gray-800">{{ $galeri->judul ?? 'Tanpa Judul' }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $galeri->deskripsi ?? '-' }}</p>
                <div class="flex items-center justify-between mt-3 pt-3 border-t">
                    <a href="{{ route('admin.galeri-fasilitas.edit', $galeri->id) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">Edit</a>
                    <a href="{{ route('admin.galeri-fasilitas.toggle-status', $galeri->id) }}" class="text-amber-600 hover:text-amber-800 text-xs font-semibold">
                        {{ $galeri->status ? 'Nonaktifkan' : 'Aktifkan' }}
                    </a>
                    <form method="POST" action="{{ route('admin.galeri-fasilitas.destroy', $galeri->id) }}" class="inline" onsubmit="return confirm('Hapus foto ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $galeris->links() }}</div>
    @else
    <div class="bg-white rounded-xl shadow-lg p-8 text-center text-gray-500">
        <p class="text-4xl mb-4">📷</p>
        <p>Belum ada foto galeri.</p>
        <a href="{{ route('admin.galeri-fasilitas.create') }}" class="text-teal-600 font-semibold hover:underline">Tambah Foto Pertama</a>
    </div>
    @endif
</div>
@endsection
