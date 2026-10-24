@extends('layouts.admin')
@section('title', 'Master Fasilitas')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-teal-800">Master Fasilitas</h1>
        <button onclick="openAddModal()" class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white px-6 py-2 rounded-lg font-semibold hover:from-teal-700 hover:to-cyan-700 transition-all shadow-md">
            + Tambah Fasilitas
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">No</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Icon</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nama</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Urutan</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Status</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Foto</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($fasilitass as $idx => $fasilitas)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm">{{ $idx + 1 }}</td>
                    <td class="px-6 py-4 text-2xl">{{ $fasilitas->icon }}</td>
                    <td class="px-6 py-4 font-medium">{{ $fasilitas->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $fasilitas->deskripsi ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">{{ $fasilitas->urutan }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.fasilitas.toggle', $fasilitas->id) }}" class="px-3 py-1 rounded-full text-xs font-semibold {{ $fasilitas->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $fasilitas->is_active ? 'Aktif' : 'Nonaktif' }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm text-teal-600 font-semibold">{{ $fasilitas->galeriFotos->count() }} foto</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick='openEditModal(@json($fasilitas))' class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Edit</button>
                            <a href="{{ route('admin.galeri-fasilitas.index', ['fasilitas_id' => $fasilitas->id]) }}" class="text-teal-600 hover:text-teal-800 text-sm font-semibold">Galeri</a>
                            <form method="POST" action="{{ route('admin.fasilitas.destroy', $fasilitas->id) }}" class="inline" onsubmit="return confirm('Hapus fasilitas ini? Semua foto terkait juga akan dihapus.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada data fasilitas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah --}}
<div id="addModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
        <h2 class="text-xl font-bold text-teal-800 mb-4">Tambah Fasilitas</h2>
        <form method="POST" action="{{ route('admin.fasilitas.store') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Fasilitas <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Icon (Emoji)</label>
                    <input type="text" name="icon" maxlength="10" value="🏢" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                    <p class="text-xs text-gray-500 mt-1">Contoh: 🅿️ 🚻 📸 🏊 🍽️ 🧗</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" name="deskripsi" maxlength="255" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Urutan</label>
                    <input type="number" name="urutan" value="0" min="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeAddModal()" class="flex-1 border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-2 rounded-lg font-semibold hover:from-teal-700 hover:to-cyan-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 p-6">
        <h2 class="text-xl font-bold text-teal-800 mb-4">Edit Fasilitas</h2>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Fasilitas <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="editNama" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Icon (Emoji)</label>
                    <input type="text" name="icon" id="editIcon" maxlength="10" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" name="deskripsi" id="editDeskripsi" maxlength="255" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Urutan</label>
                    <input type="number" name="urutan" id="editUrutan" min="0" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="closeEditModal()" class="flex-1 border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-2 rounded-lg font-semibold hover:from-teal-700 hover:to-cyan-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openAddModal() { document.getElementById('addModal').classList.remove('hidden'); }
function closeAddModal() { document.getElementById('addModal').classList.add('hidden'); }
function openEditModal(f) {
    document.getElementById('editForm').action = '/admin/fasilitas/' + f.id;
    document.getElementById('editNama').value = f.nama;
    document.getElementById('editIcon').value = f.icon;
    document.getElementById('editDeskripsi').value = f.deskripsi || '';
    document.getElementById('editUrutan').value = f.urutan;
    document.getElementById('editModal').classList.remove('hidden');
}
function closeEditModal() { document.getElementById('editModal').classList.add('hidden'); }
</script>
@endpush
@endsection
