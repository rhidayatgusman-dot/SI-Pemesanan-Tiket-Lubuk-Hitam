@extends('layouts.app')

@section('title', $tiket->nama_tiket)

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/2">
                <div class="h-96 bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center">
                    @if($tiket->foto)
                        <img src="{{ asset('storage/' . $tiket->foto) }}" alt="{{ $tiket->nama_tiket }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-32 h-32 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    @endif
                </div>
            </div>
            <div class="md:w-1/2 p-8">
                
                <h1 class="text-4xl font-bold mb-4">{{ $tiket->nama_tiket }}</h1>
                <div class="mb-6">
                    <span class="text-4xl font-bold text-emerald-600">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</span>
                    <span class="text-gray-500 ml-2">/ tiket</span>
                </div>
                <div class="mb-6">
                    <h3 class="font-semibold mb-2">Deskripsi:</h3>
                    <p class="text-gray-600">{{ $tiket->deskripsi }}</p>
                </div>
                <div class="mb-6">
                    <span class="text-lg font-semibold">Stok Tersedia: </span>
                    <span class="text-emerald-600 font-bold">{{ $tiket->stok }}</span>
                </div>

                @auth
                    <form action="{{ route('pesanan.create') }}" method="GET" class="space-y-4">
                        <input type="hidden" name="tiket_id" value="{{ $tiket->id }}">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kunjungan</label>
                            <input type="date" name="tanggal_kunjungan" required min="{{ date('Y-m-d') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Tiket</label>
                            <input type="number" name="jumlah" value="1" min="1" max="{{ $tiket->stok }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500">
                        </div>
                        <div id="totalDisplay" class="bg-gray-50 p-4 rounded-lg">
                            <span class="text-gray-600">Total: </span>
                            <span id="totalPrice" class="text-2xl font-bold text-emerald-600">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</span>
                        </div>
                        <button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-lg hover:bg-emerald-700 transition-colors font-semibold">
                            Pesan Sekarang
                        </button>
                    </form>
                @else
                    <a href="{{ route('pesanan.create', ['tiket_id' => $tiket->id]) }}" class="block w-full bg-emerald-600 text-white py-3 rounded-lg hover:bg-emerald-700 transition-colors text-center font-semibold">
                        Login untuk Memesan
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jumlahInput = document.querySelector('input[name="jumlah"]');
        const totalPrice = document.getElementById('totalPrice');
        const harga = {{ $tiket->harga }};

        if (jumlahInput && totalPrice) {
            jumlahInput.addEventListener('input', function() {
                const jumlah = parseInt(this.value) || 1;
                const total = harga * jumlah;
                totalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
            });
        }
    });
</script>
@endpush
@endsection
