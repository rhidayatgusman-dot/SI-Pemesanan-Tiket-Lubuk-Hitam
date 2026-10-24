@extends('layouts.app')

@section('title', 'Upload Foto')

@section('content')
<div class="container mx-auto px-4 py-12 pt-24 max-w-2xl relative z-10">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-teal-800 mb-3">Upload Foto Kunjungan</h1>
        <p class="text-gray-600">Bagikan momen berharga Anda di Air Terjun Lubuk Hitam</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <form method="POST" action="{{ route('galeri.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Upload Foto --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto <span class="text-red-500">*</span></label>
                <input type="file" name="foto" accept="image/*" required id="fotoInput"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('foto') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.</p>
                @error('foto')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror

                {{-- Preview --}}
                <div id="preview" class="mt-3 hidden">
                    <img id="previewImg" src="" alt="Preview" class="max-h-64 rounded-lg border">
                </div>
            </div>

            {{-- Caption --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Caption / Keterangan</label>
                <input type="text" name="caption" maxlength="255" value="{{ old('caption') }}"
                    placeholder="Ceritakan momen Anda..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('caption') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Opsional, maksimal 255 karakter.</p>
                @error('caption')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Tanggal Kunjungan --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" required max="{{ date('Y-m-d') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('tanggal_kunjungan') border-red-500 @enderror">
                @error('tanggal_kunjungan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Info --}}
            <div class="bg-teal-50 border border-teal-200 rounded-lg p-4 text-sm text-teal-700">
                <p class="font-semibold mb-1">ℹ️ Informasi</p>
                <p>Foto yang diunggah akan direview oleh admin terlebih dahulu sebelum ditampilkan di galeri.</p>
            </div>

            {{-- Tombol --}}
            <div class="flex gap-3">
                <a href="{{ route('galeri.index') }}" class="flex-1 text-center border border-gray-300 text-gray-700 py-3 rounded-lg hover:bg-gray-50 transition-colors font-semibold">
                    Batal
                </a>
                <button type="submit" class="flex-1 bg-gradient-to-r from-teal-500 to-cyan-500 text-white py-3 rounded-lg hover:from-teal-600 hover:to-cyan-600 transition-all font-semibold shadow-lg">
                    Upload Foto
                </button>
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
});
</script>
@endpush
@endsection
