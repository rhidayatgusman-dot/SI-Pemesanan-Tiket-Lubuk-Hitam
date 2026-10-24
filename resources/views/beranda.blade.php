@extends('layouts.app')

@section('title', 'Beranda - Air Terjun Lubuk Hitam')

@push('styles')
<style>
    .hero-bg {
        background: linear-gradient(135deg, rgba(13,148,136,0.55), rgba(2,132,199,0.50), rgba(15,118,110,0.45)),
            url('{{ asset('images/bg-landing.jpg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    .waterfall-card { transition: all 0.3s ease; }
    .waterfall-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.15); }
    .facility-icon { transition: all 0.3s ease; }
    .facility-icon:hover { transform: scale(1.1) rotate(5deg); }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    .animate-float { animation: float 3s ease-in-out infinite; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fadeInUp { animation: fadeInUp 0.8s ease-out; }
    .star-rating input { display: none; }
    .star-rating label { cursor: pointer; font-size: 2rem; color: #d1d5db; transition: color 0.2s; }
    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label { color: #f59e0b; }
    .star-rating { direction: rtl; display: inline-flex; }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden hero-bg">
    <div class="absolute inset-0 opacity-15">
        <div class="absolute top-20 left-10 w-72 h-72 bg-amber-200 rounded-full blur-3xl animate-float opacity-20"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-teal-300 rounded-full blur-3xl animate-float opacity-20" style="animation-delay: 1s;"></div>
    </div>
    
    <div class="relative z-10 text-center text-white px-4 animate-fadeInUp">
        <div class="mb-6 inline-block animate-float">
            <svg class="w-20 h-20 text-white opacity-90 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
            </svg>
        </div>
        
        <h1 class="text-5xl md:text-7xl font-bold mb-4 drop-shadow-lg">Air Terjun Lubuk Hitam</h1>
        <p class="text-lg md:text-xl mb-2 text-cyan-100 font-medium">Kota Padang, Sumatera Barat, Indonesia</p>
        <p class="text-base md:text-lg mb-10 max-w-2xl mx-auto text-cyan-50 leading-relaxed">
            Nikmati keindahan air terjun 3 tingkat yang menakjubkan dikelilingi hutan tropis yang asri. 
            Pesan tiket sekarang dan rasakan pengalaman wisata alam yang tak terlupakan!
        </p>
        
        @guest
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto bg-gradient-to-r from-amber-500 to-orange-500 text-white px-10 py-4 rounded-full font-bold text-lg hover:from-amber-600 hover:to-orange-600 transition-all transform hover:scale-105 shadow-2xl">
                    Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto border-2 border-white text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-teal-700 transition-all transform hover:scale-105">
                    Login
                </a>
            </div>
            <p class="mt-6 text-cyan-200 text-sm">Sudah punya akun? <a href="{{ route('login') }}" class="underline font-semibold text-white">Login di sini</a></p>
        @else
            <a href="{{ route('tiket.index') }}" class="inline-block bg-gradient-to-r from-amber-500 to-orange-500 text-white px-10 py-4 rounded-full font-bold text-lg hover:from-amber-600 hover:to-orange-600 transition-all transform hover:scale-105 shadow-2xl">
                Pesan Tiket Sekarang
            </a>
        @endguest
    </div>
    
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#f9fafb"/>
        </svg>
    </div>
</section>

<!-- Keindahan Air Terjun 3 Tingkat -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-14">
            <span class="text-teal-600 font-semibold text-sm uppercase tracking-wider">Keindahan Alam</span>
            <h2 class="text-4xl font-bold mt-2 mb-4 text-teal-800">Air Terjun 3 Tingkat</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Air Terjun Lubuk Hitam memiliki 3 tingkat dengan keindahan yang berbeda-beda. Klik card untuk melihat foto keindahan setiap tingkat.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($tingkats as $t)
            <!-- Tingkat {{ $t->tingkat }} -->
            <div class="waterfall-card bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 cursor-pointer" onclick="openFotoModal({{ $t->tingkat }}, '{{ $t->nama }}', '{{ $t->foto ? asset('storage/' . $t->foto) : '' }}', '{{ e($t->deskripsi) }}')">
                <div class="h-48 bg-gradient-to-br {{ $t->gradient }} flex items-center justify-center relative overflow-hidden">
                    @if($t->foto)
                        <img src="{{ asset('storage/' . $t->foto) }}" alt="{{ $t->nama }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-all flex items-center justify-center">
                            <span class="text-white opacity-0 hover:opacity-100 transition-all text-sm font-semibold bg-black bg-opacity-50 px-4 py-2 rounded-full">🔍 Lihat Foto</span>
                        </div>
                    @else
                        <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                        <div class="relative text-center text-white">
                            <div class="text-6xl mb-2">{{ $t->emoji }}</div>
                            <span class="bg-white bg-opacity-25 backdrop-blur-sm px-4 py-1 rounded-full text-sm font-semibold">Tingkat {{ $t->tingkat }}</span>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Tingkat {{ $t->tingkat }} - {{ $t->nama }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-3 line-clamp-3">{{ $t->deskripsi }}</p>
                    @if($t->tags)
                    <div class="flex flex-wrap gap-2">
                        @foreach($t->tags as $tag)
                            <span class="bg-teal-50 text-teal-700 text-xs px-3 py-1 rounded-full">{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">Data tingkat air terjun belum tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Modal Foto Tingkat -->
<div id="fotoModal" class="fixed inset-0 bg-black bg-opacity-80 z-50 hidden items-center justify-center p-4" onclick="closeFotoModal()">
    <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="relative">
            <button onclick="closeFotoModal()" class="absolute top-4 right-4 bg-white bg-opacity-90 hover:bg-opacity-100 w-10 h-10 rounded-full flex items-center justify-center text-gray-600 hover:text-gray-800 shadow-lg z-10 transition-all">
                ✕
            </button>
            <div id="modalFotoContainer" class="h-64 md:h-96 bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center">
                <img id="modalFoto" src="" alt="" class="w-full h-full object-cover hidden">
                <div id="modalEmoji" class="text-center text-white">
                    <div class="text-6xl mb-2" id="modalEmojiIcon"></div>
                </div>
            </div>
        </div>
        <div class="p-6">
            <h3 id="modalJudul" class="text-2xl font-bold text-gray-800 mb-3"></h3>
            <p id="modalDeskripsi" class="text-gray-600 leading-relaxed"></p>
        </div>
    </div>
</div>

<!-- Fasilitas Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-14">
            <span class="text-amber-600 font-semibold text-sm uppercase tracking-wider">Fasilitas Lengkap</span>
            <h2 class="text-4xl font-bold mt-2 mb-4 text-teal-800">Fasilitas di Air Terjun Lubuk Hitam</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Kami menyediakan berbagai fasilitas untuk kenyamanan kunjungan Anda</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($fasilitass as $fasilitas)
            <div onclick="openFasilitasModal({{ $fasilitas->id }})" class="facility-icon text-center p-4 bg-gray-50 rounded-2xl hover:bg-teal-50 transition-colors cursor-pointer group">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">{{ $fasilitas->icon }}</div>
                <h4 class="font-semibold text-gray-700 text-sm">{{ $fasilitas->nama }}</h4>
                <p class="text-xs text-gray-500 mt-1">{{ $fasilitas->deskripsi ?? 'Lihat Foto' }}</p>
                @if($fasilitas->galeriAktif->count() > 0)
                <p class="text-xs text-teal-600 mt-2 font-medium">📷 {{ $fasilitas->galeriAktif->count() }} foto</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Modal Fasilitas --}}
@foreach($fasilitass as $fasilitas)
<div id="fasilitasModal{{ $fasilitas->id }}" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4" onclick="if(event.target===this)closeFasilitasModal({{ $fasilitas->id }})">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        {{-- Header --}}
        <div class="sticky top-0 bg-white border-b px-6 py-4 flex items-center justify-between rounded-t-2xl">
            <div class="flex items-center gap-3">
                <span class="text-3xl">{{ $fasilitas->icon }}</span>
                <div>
                    <h3 class="text-xl font-bold text-teal-800">{{ $fasilitas->nama }}</h3>
                    @if($fasilitas->deskripsi)
                    <p class="text-sm text-gray-600">{{ $fasilitas->deskripsi }}</p>
                    @endif
                </div>
            </div>
            <button onclick="closeFasilitasModal({{ $fasilitas->id }})" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        {{-- Galeri Foto --}}
        <div class="p-6">
            @if($fasilitas->galeriAktif->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                @foreach($fasilitas->galeriAktif as $foto)
                <div class="relative group cursor-pointer" onclick="openLightbox({{ $fasilitas->id }}, {{ $loop->index }})">
                    <img src="{{ asset('storage/' . $foto->foto) }}" alt="{{ $foto->judul }}" class="w-full h-32 object-cover rounded-lg border border-gray-200 hover:border-teal-400 transition-colors">
                    @if($foto->judul)
                    <p class="text-xs text-gray-600 mt-1 truncate">{{ $foto->judul }}</p>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 text-gray-400">
                <p class="text-4xl mb-3">📷</p>
                <p>Belum ada foto untuk fasilitas ini.</p>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Lightbox per fasilitas --}}
@if($fasilitas->galeriAktif->count() > 0)
<div id="lightbox{{ $fasilitas->id }}" class="hidden fixed inset-0 bg-black/90 z-[60] flex items-center justify-center">
    <button onclick="closeLightbox({{ $fasilitas->id }})" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-10">&times;</button>
    <button onclick="prevFoto({{ $fasilitas->id }})" class="absolute left-4 text-white text-4xl hover:text-gray-300 z-10">&#8249;</button>
    <button onclick="nextFoto({{ $fasilitas->id }})" class="absolute right-4 text-white text-4xl hover:text-gray-300 z-10">&#8250;</button>
    <div class="text-center">
        <img id="lightboxImg{{ $fasilitas->id }}" src="" alt="" class="max-w-[90vw] max-h-[80vh] object-contain rounded-lg">
        <p id="lightboxCaption{{ $fasilitas->id }}" class="text-white mt-3 text-sm"></p>
        <p id="lightboxCounter{{ $fasilitas->id }}" class="text-gray-400 text-xs mt-1"></p>
    </div>
</div>
@endif
@endforeach

@push('scripts')
<script>
function openFasilitasModal(id) { document.getElementById('fasilitasModal' + id).classList.remove('hidden'); }
function closeFasilitasModal(id) { document.getElementById('fasilitasModal' + id).classList.add('hidden'); }

// Lightbox
const lightboxData = {};
@foreach($fasilitass as $fasilitas)
@if($fasilitas->galeriAktif->count() > 0)
lightboxData[{{ $fasilitas->id }}] = {
    fotos: [
        @foreach($fasilitas->galeriAktif as $foto)
        { src: '{{ asset("storage/" . $foto->foto) }}', judul: '{{ $foto->judul ?? "" }}' }@if(!$loop->last),@endif
        @endforeach
    ],
    current: 0
};
@endif
@endforeach

function openLightbox(fasilitasId, index) {
    const data = lightboxData[fasilitasId];
    if (!data) return;
    data.current = index;
    updateLightbox(fasilitasId);
    document.getElementById('lightbox' + fasilitasId).classList.remove('hidden');
}
function closeLightbox(fasilitasId) { document.getElementById('lightbox' + fasilitasId).classList.add('hidden'); }
function prevFoto(fasilitasId) {
    const data = lightboxData[fasilitasId];
    data.current = (data.current - 1 + data.fotos.length) % data.fotos.length;
    updateLightbox(fasilitasId);
}
function nextFoto(fasilitasId) {
    const data = lightboxData[fasilitasId];
    data.current = (data.current + 1) % data.fotos.length;
    updateLightbox(fasilitasId);
}
function updateLightbox(fasilitasId) {
    const data = lightboxData[fasilitasId];
    const foto = data.fotos[data.current];
    document.getElementById('lightboxImg' + fasilitasId).src = foto.src;
    document.getElementById('lightboxCaption' + fasilitasId).textContent = foto.judul;
    document.getElementById('lightboxCounter' + fasilitasId).textContent = (data.current + 1) + ' / ' + data.fotos.length;
}
</script>
@endpush

<!-- Jadwal Operasional Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-4 text-teal-800">Jadwal Operasional</h2>
        <p class="text-center text-gray-600 mb-8 max-w-xl mx-auto">Cek jadwal buka sebelum berkunjung</p>
        
        <!-- Status Hari Ini -->
        <div class="max-w-lg mx-auto mb-10">
            <div class="rounded-2xl p-6 text-center shadow-lg {{ $isOpen ? 'bg-gradient-to-r from-teal-500 to-cyan-500' : 'bg-gradient-to-r from-red-500 to-rose-500' }} text-white">
                <div class="text-5xl mb-3">{{ $isOpen ? '🟢' : '🔴' }}</div>
                <h3 class="text-2xl font-bold mb-1">{{ $isOpen ? 'SEDANG BUKA' : 'SEDANG TUTUP' }}</h3>
                @if($jadwalHariIni && !$jadwalHariIni->is_libur)
                    <p class="text-white opacity-90">Hari {{ $jadwalHariIni->hari }}: {{ $jadwalHariIni->jam_buka }} - {{ $jadwalHariIni->jam_tutup }}</p>
                @elseif($jadwalHariIni)
                    <p class="text-white opacity-90">Hari {{ $jadwalHariIni->hari }}: Libur{{ $jadwalHariIni->keterangan ? ' - ' . $jadwalHariIni->keterangan : '' }}</p>
                @else
                    <p class="text-white opacity-90">Jadwal belum diatur</p>
                @endif
            </div>
        </div>
        
        <!-- Tabel Jadwal Mingguan -->
        <div class="max-w-2xl mx-auto bg-white rounded-2xl p-6 shadow-md">
            <h4 class="font-semibold text-gray-700 mb-4 text-center">Jadwal Lengkap</h4>
            <div class="space-y-2">
                @foreach($allJadwal as $j)
                <div class="flex items-center justify-between py-2 px-4 rounded-lg {{ $jadwalHariIni && $j->hari == $jadwalHariIni->hari ? 'bg-teal-100 border border-teal-300' : 'bg-gray-50' }}">
                    <span class="font-medium text-gray-700 w-24">{{ $j->hari }}</span>
                    @if($j->is_libur)
                        <span class="text-red-500 font-semibold text-sm">Libur</span>
                    @else
                        <span class="text-gray-600 text-sm">{{ $j->jam_buka }} - {{ $j->jam_tutup }}</span>
                    @endif
                    @if($jadwalHariIni && $j->hari == $jadwalHariIni->hari)
                        <span class="text-xs bg-teal-600 text-white px-2 py-1 rounded-full">Hari Ini</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Tiket Section -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-4 text-teal-800">Tiket Air Terjun</h2>
        <p class="text-center text-gray-600 mb-12">Pilih paket tiket yang sesuai untuk kunjungan Anda</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($tikets as $tiket)
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 border border-gray-100">
                    <div class="h-48 water-gradient flex items-center justify-center relative overflow-hidden">
                        @if($tiket->gambar)
                            <img src="{{ asset('storage/' . $tiket->gambar) }}" alt="{{ $tiket->nama_tiket }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                        @endif
                        <div class="absolute top-3 right-3 bg-white bg-opacity-20 backdrop-blur-sm text-white text-xs px-3 py-1 rounded-full">
                            {{ $tiket->kategori }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-gray-800">{{ $tiket->nama_tiket }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $tiket->deskripsi }}</p>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-gray-500">Stok: <span class="font-semibold text-gray-700">{{ $tiket->stok }}</span></span>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t">
                            <span class="text-2xl font-bold text-teal-700">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</span>
                            <a href="{{ route('pesanan.create', ['tiket_id' => $tiket->id]) }}" class="bg-gradient-to-r from-amber-500 to-orange-500 text-white px-5 py-2 rounded-full hover:from-amber-600 hover:to-orange-600 transition-all text-sm font-semibold shadow-md">
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-500">Belum ada tiket tersedia</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('tiket.index') }}" class="inline-block bg-gradient-to-r from-teal-600 to-cyan-600 text-white px-8 py-3 rounded-full hover:from-teal-700 hover:to-cyan-700 transition-all font-semibold shadow-lg hover:shadow-xl">
                Lihat Semua Tiket
            </a>
        </div>
    </div>
</section>

<!-- Testimoni Section (Dinamis dari Database) -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="text-amber-600 font-semibold text-sm uppercase tracking-wider">Testimoni</span>
            <h2 class="text-4xl font-bold mt-2 mb-4 text-teal-800">Kata Pengunjung</h2>
            <p class="text-gray-600 max-w-xl mx-auto">Testimoni dari pengunjung yang telah datang ke Air Terjun Lubuk Hitam</p>
        </div>
        
        <!-- Tampilkan Testimoni dari Database -->
        @if($testimonis->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            @foreach($testimonis->take(3) as $t)
            <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">{{ $t->inisial }}</div>
                    <div>
                        <h4 class="font-semibold text-gray-800">{{ $t->nama }}</h4>
                        <div class="flex text-amber-400 text-sm">{{ $t->bintang }}</div>
                    </div>
                </div>
                <p class="text-gray-600 text-sm italic leading-relaxed">"{{ $t->komentar }}"</p>
                <p class="text-xs text-gray-400 mt-3">{{ $t->created_at->format('d F Y') }}</p>
            </div>
            @endforeach
        </div>
        
        @if($testimonis->count() > 3)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            @foreach($testimonis->slice(3) as $t)
            <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-xl transition-all">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">{{ $t->inisial }}</div>
                    <div>
                        <h4 class="font-semibold text-gray-800">{{ $t->nama }}</h4>
                        <div class="flex text-amber-400 text-sm">{{ $t->bintang }}</div>
                    </div>
                </div>
                <p class="text-gray-600 text-sm italic leading-relaxed">"{{ $t->komentar }}"</p>
                <p class="text-xs text-gray-400 mt-3">{{ $t->created_at->format('d F Y') }}</p>
            </div>
            @endforeach
        </div>
        @endif
        @else
        <div class="text-center py-8 mb-8">
            <p class="text-gray-500">Belum ada testimoni. Jadilah yang pertama!</p>
        </div>
        @endif
        
        <!-- Form Kirim Testimoni -->
        <div class="max-w-2xl mx-auto bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
            <h3 class="text-2xl font-bold text-center mb-2 text-teal-800">Bagikan Pengalaman Anda</h3>
            <p class="text-center text-gray-500 text-sm mb-6">Sudah datang ke Air Terjun Lubuk Hitam? Ceritakan pengalaman Anda!</p>
            
            <form method="POST" action="{{ route('testimoni.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', auth()->user()->name ?? '') }}" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors @error('nama') border-red-500 @enderror"
                        placeholder="Masukkan nama Anda">
                    @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                    <div class="star-rating flex justify-center">
                        <input type="radio" name="rating" value="5" id="star5" {{ old('rating') == 5 ? 'checked' : '' }}>
                        <label for="star5">★</label>
                        <input type="radio" name="rating" value="4" id="star4" {{ old('rating') == 4 ? 'checked' : '' }}>
                        <label for="star4">★</label>
                        <input type="radio" name="rating" value="3" id="star3" {{ old('rating') == 3 ? 'checked' : '' }}>
                        <label for="star3">★</label>
                        <input type="radio" name="rating" value="2" id="star2" {{ old('rating') == 2 ? 'checked' : '' }}>
                        <label for="star2">★</label>
                        <input type="radio" name="rating" value="1" id="star1" {{ old('rating') == 1 ? 'checked' : '' }}>
                        <label for="star1">★</label>
                    </div>
                    @error('rating')<p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>@enderror
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Komentar / Testimoni</label>
                    <textarea name="komentar" rows="4" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-colors @error('komentar') border-red-500 @enderror"
                        placeholder="Ceritakan pengalaman Anda berkunjung ke Air Terjun Lubuk Hitam...">{{ old('komentar') }}</textarea>
                    @error('komentar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-3 rounded-xl font-semibold hover:from-teal-700 hover:to-cyan-700 transition-all shadow-lg">
                    Kirim Testimoni
                </button>
                <p class="text-xs text-gray-400 text-center mt-3">Testimoni Anda akan ditampilkan setelah diverifikasi oleh admin.</p>
            </form>
        </div>
    </div>
</section>

<!-- Galeri Pengunjung Section -->
@if($galeris->count() > 0)
<section class="py-16 bg-gray-50" id="galeri">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center mb-4 text-teal-800">Galeri Pengunjung</h2>
        <p class="text-center text-gray-600 mb-10 max-w-xl mx-auto">Momen-momen berharga pengunjung di Air Terjun Lubuk Hitam</p>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($galeris as $g)
            <div class="group relative rounded-xl overflow-hidden shadow-lg aspect-square">
                <img src="{{ asset('storage/' . $g->foto) }}" alt="{{ $g->caption ?? 'Foto pengunjung' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-3">
                    <div class="text-white">
                        <p class="text-xs font-semibold">{{ $g->user->name }}</p>
                        <p class="text-xs opacity-80">{{ $g->tanggal_kunjungan->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($totalGaleri > 12)
        <div class="text-center mt-8">
            <a href="{{ route('galeri.index') }}" class="inline-block bg-gradient-to-r from-teal-500 to-cyan-500 text-white px-8 py-3 rounded-full font-bold hover:from-teal-600 hover:to-cyan-600 transition-all shadow-lg">
                Lihat Semua Foto ({{ $totalGaleri }})
            </a>
        </div>
        @endif
    </div>
</section>
@endif

<!-- CTA Section -->
@guest
<section class="py-20 water-gradient text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 right-20 w-40 h-40 bg-white rounded-full blur-2xl"></div>
        <div class="absolute bottom-10 left-20 w-60 h-60 bg-cyan-200 rounded-full blur-3xl"></div>
    </div>
    <div class="relative z-10 container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-4">Siap Menjelajah?</h2>
        <p class="text-xl mb-8 max-w-xl mx-auto text-teal-100">Daftar sekarang dan pesan tiket air terjun Lubuk Hitam dengan mudah</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="bg-gradient-to-r from-amber-500 to-orange-500 text-white px-10 py-4 rounded-full font-bold text-lg hover:from-amber-600 hover:to-orange-600 transition-all transform hover:scale-105 shadow-2xl">
                Daftar Sekarang
            </a>
            <a href="{{ route('login') }}" class="border-2 border-white text-white px-10 py-4 rounded-full font-bold text-lg hover:bg-white hover:text-teal-700 transition-all">
                Login
            </a>
        </div>
    </div>
</section>
@else
<section class="py-20 water-gradient text-white relative overflow-hidden">
    <div class="relative z-10 container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-4">Siap Menjelajah?</h2>
        <p class="text-xl mb-8 max-w-xl mx-auto text-teal-100">Pesan tiket air terjun Lubuk Hitam sekarang juga!</p>
        <a href="{{ route('tiket.index') }}" class="inline-block bg-gradient-to-r from-amber-500 to-orange-500 text-white px-10 py-4 rounded-full font-bold text-lg hover:from-amber-600 hover:to-orange-600 transition-all transform hover:scale-105 shadow-2xl">
            Pesan Tiket Sekarang
        </a>
    </div>
</section>
@endguest
@endsection

@push('scripts')
<script>
// Data tingkat untuk modal (dari database)
var tingkatData = {!! json_encode($tingkatJson) !!};

function openFotoModal(tingkat, nama, foto, deskripsi) {
    var modal = document.getElementById('fotoModal');
    var modalFoto = document.getElementById('modalFoto');
    var modalEmoji = document.getElementById('modalEmoji');
    var modalEmojiIcon = document.getElementById('modalEmojiIcon');
    var modalJudul = document.getElementById('modalJudul');
    var modalDeskripsi = document.getElementById('modalDeskripsi');
    
    // Cari data tingkat
    var data = tingkatData.find(function(t) { return t.tingkat == tingkat; });
    
    modalJudul.textContent = 'Tingkat ' + tingkat + ' - ' + nama;
    modalDeskripsi.textContent = deskripsi;
    
    if (foto) {
        modalFoto.src = foto;
        modalFoto.alt = nama;
        modalFoto.classList.remove('hidden');
        modalEmoji.classList.add('hidden');
    } else {
        modalFoto.classList.add('hidden');
        modalEmoji.classList.remove('hidden');
        modalEmojiIcon.textContent = data ? data.emoji : '💧';
    }
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeFotoModal() {
    var modal = document.getElementById('fotoModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

// Tutup modal dengan ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeFotoModal();
});
</script>
@endpush
