@extends('layouts.admin')
@section('title', 'Kelola Testimoni')
@section('content')
<div class="animate-fadeInUp">
    <h1 class="text-3xl font-bold mb-2">Kelola Testimoni</h1>
    <p class="text-gray-500 mb-6">Kelola komentar/testimoni dari pengunjung Air Terjun Lubuk Hitam</p>

    <!-- Info -->
    <div class="bg-teal-50 border border-teal-200 rounded-lg p-4 mb-6">
        <p class="text-sm text-teal-700">
            <strong>Cara kerja:</strong> Pengunjung mengirim testimoni melalui form di beranda. 
            Testimoni yang baru akan berstatus <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded text-xs font-semibold">Pending</span>. 
            Klik tombol <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-semibold">Tampilkan</span> untuk menyetujui testimoni agar tampil di beranda.
        </p>
    </div>

    <!-- Tabel Testimoni -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Nama</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Rating</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Komentar</th>
                    <th class="text-center py-3 px-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-center py-3 px-4 text-sm font-semibold text-gray-600">Tanggal</th>
                    <th class="text-center py-3 px-4 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonis as $t)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-xs mr-2">
                                {{ $t->inisial }}
                            </div>
                            <span class="text-sm font-medium text-gray-800">{{ $t->nama }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <span class="text-amber-400 text-sm">{{ $t->bintang }}</span>
                    </td>
                    <td class="py-3 px-4">
                        <p class="text-sm text-gray-600 max-w-xs truncate">{{ $t->komentar }}</p>
                    </td>
                    <td class="py-3 px-4 text-center">
                        @if($t->is_approved)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">Tampil</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">Pending</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-center text-sm text-gray-500">{{ $t->created_at->format('d M Y') }}</td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            @if(!$t->is_approved)
                            <form method="POST" action="{{ route('admin.testimoni.approve', $t->id) }}">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-semibold transition-colors">
                                    Tampilkan
                                </button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('admin.testimoni.destroy', $t->id) }}" onsubmit="return confirm('Hapus testimoni dari {{ $t->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-400">Belum ada testimoni dari pengunjung.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($testimonis->hasPages())
    <div class="mt-4">
        {{ $testimonis->links() }}
    </div>
    @endif
</div>
@endsection
