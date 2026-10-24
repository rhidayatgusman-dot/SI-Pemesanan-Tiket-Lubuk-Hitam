@extends('layouts.admin')
@section('title', 'Kelola Tingkat Air Terjun')
@section('content')
<div class="animate-fadeInUp">
    <h1 class="text-3xl font-bold mb-2">Kelola Tingkat Air Terjun</h1>
    <p class="text-gray-500 mb-6">Kelola data dan foto keindahan air terjun 3 tingkat</p>

    <!-- Info -->
    <div class="bg-teal-50 border border-teal-200 rounded-lg p-4 mb-6">
        <p class="text-sm text-teal-700">
            <strong>Cara kerja:</strong> Admin bisa mengedit nama, deskripsi, foto, dan tag fitur untuk setiap tingkat air terjun. 
            Foto yang diupload akan ditampilkan di beranda saat pengunjung mengklik card tingkat. 
            Hanya tingkat yang <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-semibold">Aktif</span> yang tampil di beranda.
        </p>
    </div>

    <!-- Daftar Tingkat -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($tingkats as $t)
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <!-- Preview Foto -->
            <div class="h-48 bg-gradient-to-br {{ $t->gradient }} flex items-center justify-center relative">
                @if($t->foto)
                    <img src="{{ asset('storage/' . $t->foto) }}" alt="{{ $t->nama }}" class="w-full h-full object-cover">
                @else
                    <div class="text-center text-white">
                        <div class="text-5xl mb-2">{{ $t->emoji }}</div>
                        <span class="bg-white bg-opacity-25 px-3 py-1 rounded-full text-sm">Tingkat {{ $t->tingkat }}</span>
                    </div>
                @endif
                <!-- Status Badge -->
                <div class="absolute top-3 right-3">
                    @if($t->is_active)
                        <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full font-semibold">Aktif</span>
                    @else
                        <span class="bg-gray-500 text-white text-xs px-2 py-1 rounded-full font-semibold">Nonaktif</span>
                    @endif
                </div>
            </div>
            <!-- Info -->
            <div class="p-4">
                <h3 class="font-bold text-gray-800 mb-1">Tingkat {{ $t->tingkat }} - {{ $t->nama }}</h3>
                <p class="text-gray-500 text-sm line-clamp-2 mb-3">{{ $t->deskripsi }}</p>
                @if($t->tags)
                <div class="flex flex-wrap gap-1 mb-3">
                    @foreach($t->tags as $tag)
                        <span class="bg-teal-50 text-teal-700 text-xs px-2 py-0.5 rounded-full">{{ $tag }}</span>
                    @endforeach
                </div>
                @endif
                <a href="{{ route('admin.tingkat.edit', $t->id) }}" class="block w-full text-center bg-teal-600 hover:bg-teal-700 text-white py-2 rounded-lg font-semibold transition-colors">
                    Edit
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
