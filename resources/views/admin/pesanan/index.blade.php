@extends('layouts.admin')
@section('title', 'Kelola Pesanan')
@section('content')
<div class="animate-fadeInUp">
    <h1 class="text-3xl font-bold mb-6">Kelola Pesanan</h1>
    <div class="bg-white rounded-xl shadow-md p-6">
        <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pemesan/tiket..." class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="diterima" {{ request('status')=='diterima'?'selected':'' }}>Diterima</option>
                <option value="ditolak" {{ request('status')=='ditolak'?'selected':'' }}>Ditolak</option>
            </select>
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700">Filter</button>
        </form>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemesan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tiket</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kunjungan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($pesanans as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm">{{ $p->user->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ Str::limit($p->tiket->nama_tiket, 20) }}</td>
                        <td class="px-4 py-3 text-sm">{{ $p->tanggal_kunjungan->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-sm font-semibold">Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                        <td class="px-4 py-3"><span class="px-2 py-1 rounded-full text-xs font-semibold @if($p->status=='pending') bg-yellow-100 text-yellow-700 @elseif($p->status=='diterima') bg-green-100 text-green-700 @else bg-red-100 text-red-700 @endif">{{ ucfirst($p->status) }}</span></td>
                        <td class="px-4 py-3"><a href="{{ route('admin.pesanan.show', $p->id) }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">Detail</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $pesanans->links() }}</div>
    </div>
</div>
@endsection
