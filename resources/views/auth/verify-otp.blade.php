@extends('layouts.app')

@section('title', 'Verifikasi OTP')

@push('styles')
<style>
    .otp-bg {
        background: linear-gradient(135deg, rgba(15,118,110,0.80), rgba(2,132,199,0.70), rgba(13,148,136,0.75)),
            url('{{ asset('images/bg-landing.jpg') }}');
        background-size: cover;
        background-position: center;
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .input-glow:focus {
        box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.25);
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slideUp { animation: slideUp 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
</style>
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center otp-bg py-12 px-4">
    <div class="max-w-md w-full animate-slideUp relative z-10">
        <div class="glass-card rounded-3xl shadow-2xl p-8 md:p-10">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Verifikasi OTP</h2>
                <p class="text-gray-500 mt-2">Masukkan kode 6 digit yang dikirim ke WhatsApp</p>
                <p class="text-teal-700 font-semibold mt-1">{{ $no_wa ?? old('no_wa') }}</p>
            </div>

            @if(session('success'))
                <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl mb-6">
                    <p class="font-semibold text-sm mb-1">📱 Simulasi OTP (tidak dikirim via WhatsApp):</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('register.otp.verify.post') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="name" value="{{ $name ?? old('name') }}">
                <input type="hidden" name="no_wa" value="{{ $no_wa ?? old('no_wa') }}">

                <div>
                    <label for="otp" class="block text-sm font-semibold text-gray-700 mb-2 text-center">Kode OTP</label>
                    <input id="otp" type="text" name="otp" maxlength="6" pattern="[0-9]{6}" required autofocus
                        class="block w-full text-center text-3xl tracking-widest py-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all font-mono @error('otp') border-red-400 @enderror"
                        placeholder="000000">
                    @error('otp')
                        <p class="mt-2 text-sm text-red-500 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="text-xs text-gray-500 text-center mt-2">Kode berlaku selama 5 menit</p>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-3.5 rounded-xl hover:from-teal-700 hover:to-cyan-700 transition-all transform hover:scale-[1.02] shadow-lg hover:shadow-xl font-semibold text-lg">
                    Verifikasi
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('register') }}" class="text-gray-500 hover:text-teal-600 text-sm transition-colors">
                    ← Kembali ke form pendaftaran
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
