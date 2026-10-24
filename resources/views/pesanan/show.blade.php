@extends('layouts.app')
@section('title', 'Detail Pesanan')
@section('content')
<div class="container mx-auto px-4 py-12 max-w-3xl">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold">Detail Pesanan</h1>
        @if($pesanan->status == 'diterima')
        <a href="{{ route('pesanan.cetak', $pesanan->id) }}" target="_blank" class="bg-gradient-to-r from-emerald-600 to-cyan-600 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
            🖨️ Cetak Tiket
        </a>
        @endif
    </div>
    <div class="bg-white rounded-xl shadow-lg p-8">
        <!-- Status -->
        <div class="mb-6">
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($pesanan->status == 'pending') bg-yellow-100 text-yellow-700
                @elseif($pesanan->status == 'diterima') bg-green-100 text-green-700
                @else bg-red-100 text-red-700 @endif">
                Status: {{ ucfirst($pesanan->status) }}
            </span>
        </div>
        <!-- Timeline -->
        <div class="mb-8">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-8 h-8 rounded-full @if(in_array($pesanan->status, ['pending','diterima'])) bg-yellow-500 @else bg-gray-300 @endif text-white text-sm font-bold">1</div>
                <div class="flex-1 h-1 @if($pesanan->status == 'pending') bg-yellow-500 @else bg-gray-300 @endif ml-2"></div>
                <div class="flex items-center justify-center w-8 h-8 rounded-full @if($pesanan->status == 'diterima') bg-green-500 @elseif($pesanan->status == 'ditolak') bg-red-500 @else bg-gray-300 @endif text-white text-sm font-bold">2</div>
            </div>
            <div class="flex justify-between mt-2 text-xs text-gray-500">
                <span>Menunggu Pembayaran</span>
                <span>{{ $pesanan->status == 'diterima' ? 'Diterima' : ($pesanan->status == 'ditolak' ? 'Ditolak' : 'Verifikasi') }}</span>
            </div>
        </div>
        <!-- Detail -->
        <div class="space-y-4 mb-8">
            <div class="flex justify-between py-2 border-b"><span class="text-gray-700">Tiket</span><span class="font-medium text-gray-800">{{ $pesanan->tiket->nama_tiket }}</span></div>
            <div class="flex justify-between py-2 border-b"><span class="text-gray-700">Tanggal Kunjungan</span><span class="font-medium text-gray-800">{{ $pesanan->tanggal_kunjungan->format('d M Y') }}</span></div>
            <div class="flex justify-between py-2 border-b"><span class="text-gray-700">Jumlah</span><span class="font-medium text-gray-800">{{ $pesanan->jumlah }} tiket</span></div>
            <div class="flex justify-between py-2 border-b"><span class="text-gray-700">Harga Satuan</span><span class="font-medium text-gray-800">Rp {{ number_format($pesanan->tiket->harga, 0, ',', '.') }}</span></div>
            <div class="flex justify-between py-2"><span class="text-gray-700 font-semibold">Total</span><span class="text-xl font-bold text-teal-700">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</span></div>
        </div>
        @if($pesanan->catatan)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-blue-800 mb-1">Catatan Admin:</h3>
            <p class="text-blue-700">{{ $pesanan->catatan }}</p>
        </div>
        @endif
        <!-- Upload Bukti Pembayaran -->
        @if($pesanan->status == 'pending')
        <div class="border-t pt-6">
            <h3 class="font-semibold mb-4">Upload Bukti Pembayaran</h3>
            
            <!-- Info Rekening -->
            <div class="bg-gradient-to-r from-teal-50 to-cyan-50 border border-teal-200 rounded-lg p-5 mb-5">
                <h4 class="font-bold text-teal-800 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Transfer Pembayaran
                </h4>
                <p class="text-sm text-teal-700 mb-3">Silakan transfer ke rekening berikut atas nama <strong>Objek Wisata Air Terjun Lubuk Hitam</strong>:</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="bg-white rounded-lg p-3 border border-teal-100">
                        <p class="text-xs text-gray-500 mb-1">Bank BRI</p>
                        <p class="font-bold text-lg text-teal-800 tracking-wider">1234-5678-9012</p>
                        <p class="text-sm text-gray-600 mt-1">a.n. <strong>Objek Wisata Air Terjun Lubuk Hitam</strong></p>
                    </div>
                    <div class="bg-white rounded-lg p-3 border border-teal-100">
                        <p class="text-xs text-gray-500 mb-1">Bank Mandiri</p>
                        <p class="font-bold text-lg text-teal-800 tracking-wider">0987-6543-2100</p>
                        <p class="text-sm text-gray-600 mt-1">a.n. <strong>Objek Wisata Air Terjun Lubuk Hitam</strong></p>
                    </div>
                </div>
                <p class="text-xs text-teal-600 mt-3">* Pastikan nominal transfer sesuai dengan total pembayaran: <strong>Rp {{ number_format($pesanan->total, 0, ',', '.') }}</strong></p>
            </div>

            <form method="POST" action="{{ route('pesanan.bayar', $pesanan->id) }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="bukti_pembayaran" accept="image/*,application/pdf" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG, PDF. Maksimal 2MB.</p>
                @error('bukti_pembayaran')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                <button type="submit" class="mt-4 bg-gradient-to-r from-teal-600 to-cyan-600 text-white px-6 py-2 rounded-lg hover:from-teal-700 hover:to-cyan-700 transition-all font-semibold shadow-md">Upload Bukti</button>
            </form>
        </div>
        @endif
        @if($pesanan->bukti_pembayaran)
        <div class="mt-6 border-t pt-6">
            <h3 class="font-semibold mb-4">Bukti Pembayaran</h3>
            @if(str_ends_with($pesanan->bukti_pembayaran, '.pdf'))
                <a href="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" target="_blank" class="text-emerald-600 hover:underline">Lihat PDF</a>
            @else
                <img src="{{ asset('storage/' . $pesanan->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="max-w-md rounded-lg shadow">
            @endif
        </div>
        @endif

        {{-- Upload Foto Kunjungan --}}
        @if($pesanan->status == 'diterima' && $pesanan->tanggal_kunjungan->isPast())
        <div class="mt-6 border-t pt-6">
            <h3 class="font-semibold mb-4 flex items-center gap-2">
                📷 Upload Foto Kunjungan
            </h3>
            <p class="text-sm text-gray-600 mb-4">Bagikan momen kunjungan Anda di Air Terjun Lubuk Hitam. Foto akan ditampilkan di galeri setelah disetujui admin.</p>

            <form method="POST" action="{{ route('galeri.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tanggal_kunjungan" value="{{ $pesanan->tanggal_kunjungan->format('Y-m-d') }}">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Foto <span class="text-red-500">*</span></label>
                        <input type="file" name="foto" accept="image/*" required id="fotoInput"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('foto') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.</p>
                        @error('foto')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror

                        <div id="preview" class="mt-3 hidden">
                            <img id="previewImg" src="" alt="Preview" class="max-h-48 rounded-lg border">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Caption / Keterangan</label>
                        <input type="text" name="caption" maxlength="255" value="{{ old('caption') }}"
                            placeholder="Ceritakan momen Anda..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('caption') border-red-500 @enderror">
                        <p class="text-xs text-gray-500 mt-1">Opsional, maksimal 255 karakter.</p>
                        @error('caption')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="bg-gradient-to-r from-amber-500 to-orange-500 text-white px-8 py-3 rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all font-semibold shadow-lg">
                        📷 Upload Foto Kunjungan
                    </button>
                </div>
            </form>
        </div>
        @endif
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
