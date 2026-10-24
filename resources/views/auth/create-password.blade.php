@extends('layouts.app')

@section('title', 'Buat Password')

@push('styles')
<style>
    .password-bg {
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
<div class="min-h-screen flex items-center justify-center password-bg py-12 px-4">
    <div class="max-w-md w-full animate-slideUp relative z-10">
        <div class="glass-card rounded-3xl shadow-2xl p-8 md:p-10">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">OTP Terverifikasi!</h2>
                <p class="text-gray-500 mt-2">Buat password untuk akun Anda</p>
                <p class="text-sm text-gray-400 mt-1">{{ $name }} - {{ $no_wa }}</p>
            </div>

            <form method="POST" action="{{ route('register.password.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required autofocus
                            class="block w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all input-glow bg-gray-50 focus:bg-white @error('password') border-red-400 @enderror"
                            placeholder="Minimal 8 karakter">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-500 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="block w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all input-glow bg-gray-50 focus:bg-white"
                            placeholder="Ulangi password">
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-3.5 rounded-xl hover:from-teal-700 hover:to-cyan-700 transition-all transform hover:scale-[1.02] shadow-lg hover:shadow-xl font-semibold text-lg">
                    Buat Akun
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
