@extends('layouts.admin')
@section('title', 'Edit Tingkat ' . $tingkat->tingkat)
@section('content')
<div class="animate-fadeInUp max-w-3xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold">Edit Tingkat {{ $tingkat->tingkat }}</h1>
            <p class="text-gray-500">Kelola data dan foto keindahan air terjun tingkat {{ $tingkat->tingkat }}</p>
        </div>
        <a href="{{ route('admin.tingkat.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
            ← Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.tingkat.update', $tingkat->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-xl shadow-md p-6 space-y-6">
            <!-- Preview Foto -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Tingkat {{ $tingkat->tingkat }}</label>
                <div class="mb-3">
                    @if($tingkat->foto)
                        <div class="relative inline-block">
                            <img src="{{ asset('storage/' . $tingkat->foto) }}" alt="Foto tingkat {{ $tingkat->tingkat }}" class="w-full max-h-64 rounded-lg object-cover">
                            <a href="{{ route('admin.tingkat.hapus-foto', $tingkat->id) }}" 
                               onclick="return confirm('Yakin hapus foto ini?')"
                               class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs font-semibold">
                                Hapus Foto
                            </a>
                        </div>
                    @else
                        <div class="h-48 bg-gradient-to-br {{ $tingkat->gradient }} rounded-lg flex items-center justify-center">
                            <div class="text-center text-white">
                                <div class="text-5xl mb-2">{{ $tingkat->emoji }}</div>
                                <span class="bg-white bg-opacity-25 px-3 py-1 rounded-full text-sm">Belum ada foto</span>
                            </div>
                        </div>
                    @endif
                </div>
                <input type="file" name="foto" accept="image/*" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('foto') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG, WebP. Maksimal 5MB.</p>
                @error('foto')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Nama -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Tingkat</label>
                <input type="text" name="nama" value="{{ old('nama', $tingkat->nama) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('nama') border-red-500 @enderror">
                @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="4" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $tingkat->deskripsi) }}</textarea>
                @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Tag Fitur -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tag Fitur 1</label>
                    <input type="text" name="tag1" value="{{ old('tag1', $tingkat->tag1) }}" placeholder="Contoh: Kolam Renang Alami"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tag Fitur 2</label>
                    <input type="text" name="tag2" value="{{ old('tag2', $tingkat->tag2) }}" placeholder="Contoh: Air Jernih"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tag Fitur 3</label>
                    <input type="text" name="tag3" value="{{ old('tag3', $tingkat->tag3) }}" placeholder="Contoh: Aman untuk Anak"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
            </div>

            <!-- Emoji & Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Emoji Ikon</label>
                    <input type="text" name="emoji" value="{{ old('emoji', $tingkat->emoji) }}" maxlength="10"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    <p class="text-xs text-gray-500 mt-1">Emoji untuk ditampilkan di card (jika belum ada foto)</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <label class="flex items-center mt-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $tingkat->is_active) ? 'checked' : '' }}
                            class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                        <span class="ml-3 text-gray-700">Tampilkan di beranda</span>
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <div class="pt-4 border-t">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
