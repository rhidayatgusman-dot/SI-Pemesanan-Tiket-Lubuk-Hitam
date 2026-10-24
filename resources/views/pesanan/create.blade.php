@extends('layouts.app')

@section('title', 'Buat Pesanan')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-2xl relative z-10">
    <h1 class="text-3xl font-bold mb-8">Buat Pesanan</h1>
    <div class="bg-white rounded-xl shadow-lg p-8">
        @if(!$isOpen)
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <span class="text-2xl mr-3">🔴</span>
                <div>
                    <p class="font-semibold text-red-700">Wisata Sedang Tutup</p>
                    <p class="text-red-600 text-sm">Maaf, pemesanan tiket tidak dapat dilakukan saat wisata tutup. Silakan coba lagi pada jam operasional.</p>
                </div>
            </div>
        </div>
        @endif
        <div class="mb-6 pb-6 border-b">
            <h2 class="text-xl font-semibold mb-2">{{ $tiket->nama_tiket }}</h2>
            <p class="text-gray-600 text-sm">{{ $tiket->deskripsi }}</p>
            <p class="text-emerald-600 font-bold text-2xl mt-2">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</p>
        </div>
        <form method="POST" action="{{ route('pesanan.store') }}">
            @csrf
            <input type="hidden" name="tiket_id" value="{{ $tiket->id }}">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kunjungan</label>
                    <input type="date" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', request('tanggal_kunjungan')) }}" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('tanggal_kunjungan') border-red-500 @enderror">
                    @error('tanggal_kunjungan')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Tiket</label>
                    <input type="number" name="jumlah" id="jumlahInput" value="{{ old('jumlah', request('jumlah', 1)) }}" min="1" max="{{ $tiket->stok }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 @error('jumlah') border-red-500 @enderror">
                    @error('jumlah')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between"><span>Total Pembayaran</span><span id="totalDisplay" class="text-2xl font-bold text-emerald-600">Rp {{ number_format($tiket->harga * (int) old('jumlah', request('jumlah', 1)), 0, ',', '.') }}</span></div>
                </div>
                <button type="submit" {{ !$isOpen ? 'disabled' : '' }} class="w-full {{ $isOpen ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-gray-400 cursor-not-allowed' }} text-white py-3 rounded-lg transition-colors font-semibold">
                    {{ $isOpen ? 'Konfirmasi Pesanan' : 'Wisata Sedang Tutup' }}
                </button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jumlahInput = document.getElementById('jumlahInput');
    const totalDisplay = document.getElementById('totalDisplay');
    const harga = {{ $tiket->harga }};
    jumlahInput.addEventListener('input', function() {
        const total = harga * (parseInt(this.value) || 1);
        totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
    });
});
</script>
@endpush
@endsection
