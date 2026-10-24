@extends('layouts.admin')
@section('title', 'Kelola Tiket')
@section('content')
<div class="animate-fadeInUp">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Kelola Tiket</h1>
        <a href="{{ route('admin.tiket.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition-colors">+ Tambah Tiket</a>
    </div>
    <div class="bg-white rounded-xl shadow-md p-6">
        <form method="GET" class="mb-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tiket..." class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
        </form>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($tikets as $tiket)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $tiket->nama_tiket }}</td>
                    <td class="px-4 py-3"><span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-full text-xs">{{ $tiket->kategori }}</span></td>
                    <td class="px-4 py-3">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">{{ $tiket->stok }}</td>
                    <td class="px-4 py-3">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.tiket.edit', $tiket->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.tiket.destroy', $tiket->id) }}" onsubmit="return confirm('Yakin hapus tiket ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada tiket</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $tikets->links() }}</div>
    </div>
</div>
@endsection
