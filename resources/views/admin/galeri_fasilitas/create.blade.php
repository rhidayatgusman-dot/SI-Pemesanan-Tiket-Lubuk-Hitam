@extends('layouts.admin')
@section('title', 'Tambah Foto Fasilitas')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold text-teal-800 mb-6">Tambah Foto Fasilitas</h1>

    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="POST" action="{{ route('admin.galeri-fasilitas.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Fasilitas <span class="text-red-500">*</span></label>
                    <select name="fasilitas_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('fasilitas_id') border-red-500 @enderror">
                        <option value="">-- Pilih Fasilitas --</option>
                        @foreach($fasilitass as $f)
                        <option value="{{ $f->id }}" {{ old('fasilitas_id') == $f->id ? 'selected' : '' }}>{{ $f->icon }} {{ $f->nama }}</option>
                        @endforeach
                    </select>
                    @error('fasilitas_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Foto</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" maxlength="255"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('judul') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Opsional, maksimal 255 karakter.</p>
                    @error('judul')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <input type="text" name="deskripsi" value="{{ old('deskripsi') }}" maxlength="255"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('deskripsi') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Opsional, maksimal 255 karakter.</p>
                    @error('deskripsi')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Foto <span class="text-red-500">*</span></label>
                    <input type="file" name="foto" accept="image/*" required id="fotoInput"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('foto') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.</p>
                    @error('foto')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror

                    <div id="preview" class="mt-3 hidden">
                        <img id="previewImg" src="" alt="Preview" class="max-h-48 rounded-lg border">
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="status" value="1" checked id="statusCheck" class="w-4 h-4 text-teal-600 rounded focus:ring-teal-500">
                    <label for="statusCheck" class="text-sm font-semibold text-gray-700">Aktif</label>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <a href="{{ route('admin.galeri-fasilitas.index') }}" class="flex-1 border border-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-50 text-center font-semibold">Batal</a>
                <button type="submit" class="flex-1 bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-2 rounded-lg font-semibold hover:from-teal-700 hover:to-cyan-700">Upload Foto</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('fotoInput');
    const preview = document.getElementById('preview');
    const previewImg = document.getElementById('previewImg');

    if (input && preview && previewImg) {
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});
</script>
@endpush
@endsection
