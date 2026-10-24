@extends('layouts.admin')

@section('title', 'Jadwal Operasional')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-800">Jadwal Operasional</h1>
        <p class="text-gray-500 mt-1">Kelola jadwal buka dan tutup wisata air terjun</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hari</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Buka</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Tutup</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($jadwals as $jadwal)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $jadwal->hari }}</td>
                <td class="px-6 py-4">{{ $jadwal->jam_buka ?? '-' }}</td>
                <td class="px-6 py-4">{{ $jadwal->jam_tutup ?? '-' }}</td>
                <td class="px-6 py-4">
                    @if($jadwal->is_libur)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Libur</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Buka</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $jadwal->keterangan ?? '-' }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">Edit</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                    Belum ada jadwal. Silakan jalankan seeder terlebih dahulu.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
