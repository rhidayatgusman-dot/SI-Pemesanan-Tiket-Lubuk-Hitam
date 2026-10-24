@extends('layouts.admin')
@section('title', 'Kelola User')
@section('content')
<div class="animate-fadeInUp">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">Kelola User</h1>
        <a href="{{ route('admin.user.create') }}" class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white px-5 py-2.5 rounded-lg hover:from-teal-700 hover:to-cyan-700 transition-all font-semibold shadow-md flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah User
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-md p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau no WhatsApp..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="pengunjung" {{ request('role') == 'pengunjung' ? 'selected' : '' }}>Pengunjung</option>
                </select>
            </div>
            <button type="submit" class="bg-teal-600 text-white px-5 py-2 rounded-lg hover:bg-teal-700 transition-colors">Filter</button>
            @if(request('search') || request('role'))
            <a href="{{ route('admin.user.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2">Reset</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase">No</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase">Nama</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase">No WhatsApp</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase">Role</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase">Terdaftar</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase">Pesanan</th>
                    <th class="px-5 py-3 text-center text-xs font-semibold uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $index => $user)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-4 text-sm text-gray-500">{{ $users->firstItem() + $index }}</td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-800">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-600">{{ $user->no_wa }}</td>
                    <td class="px-5 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $user->role === 'admin' ? 'bg-amber-100 text-amber-700' : 'bg-teal-100 text-teal-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-4 text-sm text-gray-600 font-semibold">{{ $user->pesanans->count() }}</td>
                    <td class="px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="text-teal-600 hover:text-teal-800 text-sm font-medium">Edit</a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.user.destroy', $user->id) }}" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Hapus</button>
                            </form>
                            @else
                            <span class="text-gray-400 text-sm italic">Anda</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-12 text-center text-gray-500">Tidak ada user ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
