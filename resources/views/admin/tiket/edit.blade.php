@extends('layouts.admin')
@section('title', 'Edit Tiket')
@section('content')
<div class="animate-fadeInUp max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Edit Tiket</h1>
    <div class="bg-white rounded-xl shadow-md p-8">
        <form method="POST" action="{{ route('admin.tiket.update', $tiket->id) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tiket</label>
                <input type="text" name="nama_tiket" value="{{ old('nama_tiket', $tiket->nama_tiket) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                @error('nama_tiket')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">{{ old('deskripsi', $tiket->deskripsi) }}</textarea>
                @error('deskripsi')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <input type="number" name="harga" value="{{ old('harga', $tiket->harga) }}" required min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    @error('harga')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $tiket->stok) }}" required min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    @error('stok')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                    @foreach(['Reguler','Weekend','Grup'] as $k)
                    <option value="{{ $k }}" {{ old('kategori', $tiket->kategori)==$k?'selected':'' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
                @if($tiket->gambar)
                <div class="mb-2"><img src="{{ asset('storage/' . $tiket->gambar) }}" class="h-24 rounded-lg" alt="Current image"></div>
                @endif
                <input type="file" name="gambar" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah gambar</p>
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition-colors">Update</button>
                <a href="{{ route('admin.tiket.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
