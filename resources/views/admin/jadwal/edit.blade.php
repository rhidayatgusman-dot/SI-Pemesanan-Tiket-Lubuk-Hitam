@extends('layouts.admin')

@section('title', 'Edit Jadwal')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Edit Jadwal - {{ $jadwal->hari }}</h1>
    <p class="text-gray-500 mt-1">Atur jam operasional untuk hari {{ $jadwal->hari }}</p>
</div>

<div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl">
    <form method="POST" action="{{ route('admin.jadwal.update', $jadwal->id) }}">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Hari</label>
                <input type="text" value="{{ $jadwal->hari }}" disabled class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-100 text-gray-600">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Buka</label>
                    <input type="time" name="jam_buka" value="{{ old('jam_buka', $jadwal->jam_buka) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-gray-50 focus:bg-white">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jam Tutup</label>
                    <input type="time" name="jam_tutup" value="{{ old('jam_tutup', $jadwal->jam_tutup) }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-gray-50 focus:bg-white">
                </div>
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_libur" value="1" {{ old('is_libur', $jadwal->is_libur) ? 'checked' : '' }} class="w-5 h-5 text-red-500 focus:ring-red-400 border-gray-300 rounded">
                    <span class="ml-3 text-sm font-semibold text-gray-700">Tandai sebagai hari libur (tutup)</span>
                </label>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan (opsional)</label>
                <textarea name="keterangan" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent bg-gray-50 focus:bg-white" placeholder="Contoh: Libur nasional, maintenance, dll">{{ old('keterangan', $jadwal->keterangan) }}</textarea>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="bg-gradient-to-r from-emerald-600 to-cyan-600 text-white px-8 py-3 rounded-xl hover:from-emerald-700 hover:to-cyan-700 transition-all font-semibold shadow-lg">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.jadwal.index') }}" class="bg-gray-100 text-gray-700 px-8 py-3 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    Kembali
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
