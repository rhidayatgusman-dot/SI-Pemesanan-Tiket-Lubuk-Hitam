<?php

namespace App\Http\Controllers;

use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * AuthController - Menangani autentikasi user (login, register dengan OTP, logout)
 * 
 * Alur Registrasi (menggunakan OTP):
 * 1. User masukkan nama + nomor WhatsApp -> minta kode OTP
 * 2. Sistem generate OTP 6 digit (simulasi: ditampilkan di layar)
 * 3. User masukkan kode OTP -> verifikasi
 * 4. Jika OTP valid -> user buat password
 * 5. Akun dibuat, redirect ke login
 * 
 * Alur Login:
 * 1. User masukkan nomor WhatsApp + password
 * 2. Sistem verifikasi kredensial
 * 3. Redirect berdasarkan role (admin -> dashboard, user -> beranda)
 */
class AuthController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login user menggunakan nomor WhatsApp + password
     * 1. Validasi no_wa & password
     * 2. Attempt login
     * 3. Redirect berdasarkan role
     * 4. Jika gagal, tampilkan error
     */
    public function login(Request $request)
    {
        // Normalisasi nomor WhatsApp (hapus spasi, dash, ganti 08 -> 628)
        $noWa = $this->normalisasiNoWa($request->no_wa);

        // Validasi input
        $credentials = $request->validate([
            'no_wa' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Coba login dengan nomor WhatsApp
        $user = User::where('no_wa', $noWa)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Login berhasil
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();

            // Redirect admin ke dashboard, user biasa ke beranda
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard')->with('success', 'Selamat datang, ' . $user->name);
            }

            return redirect()->intended('/')->with('success', 'Login berhasil, selamat datang ' . $user->name);
        }

        // Login gagal
        return back()->withErrors([
            'no_wa' => 'Nomor WhatsApp atau password salah.',
        ])->onlyInput('no_wa');
    }

    /**
     * Tampilkan form registrasi (step 1: masukkan nama & no WA)
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Step 1: Kirim OTP ke nomor WhatsApp
     * 1. Validasi nama & no_wa
     * 2. Cek apakah no_wa sudah terdaftar
     * 3. Generate kode OTP 6 digit
     * 4. Simpan ke database (expired 5 menit)
     * 5. Tampilkan OTP di layar (simulasi WhatsApp)
     */
    public function kirimOtp(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string', 'regex:/^[0-9]{10,15}$/'],
        ], [
            'no_wa.regex' => 'Nomor WhatsApp harus 10-15 digit angka.',
        ]);

        // Normalisasi nomor
        $noWa = $this->normalisasiNoWa($request->no_wa);

        // Cek apakah sudah terdaftar
        if (User::where('no_wa', $noWa)->exists()) {
            return back()->withErrors(['no_wa' => 'Nomor WhatsApp sudah terdaftar. Silakan login.']);
        }

        // Hapus OTP lama yang belum dipakai (jika ada)
        OtpCode::where('no_wa', $noWa)->where('sudah_dipakai', false)->delete();

        // Generate kode OTP
        $kode = OtpCode::generateKode();

        // Simpan OTP ke database (berlaku 5 menit)
        OtpCode::create([
            'no_wa' => $noWa,
            'kode' => $kode,
            'expired_at' => now()->addMinutes(5),
        ]);

        // SIMULASI: Tampilkan OTP di session (seharusnya dikirim via WhatsApp API)
        // Pada produksi, integrasikan dengan Fonnte, Wablas, atau Twilio
        return redirect()->route('register.otp.verify', [
            'name' => $request->name,
            'no_wa' => $request->no_wa,
        ])->with('success', "Kode OTP telah dikirim ke WhatsApp {$request->no_wa}. (SIMULASI: Kode OTP Anda adalah: {$kode})");
    }

    /**
     * Tampilkan form verifikasi OTP (step 2)
     */
    public function showVerifyOtp(Request $request)
    {
        if (!$request->session()->has('success')) {
            return redirect()->route('register');
        }

        return view('auth.verify-otp', [
            'name' => $request->query('name', old('name')),
            'no_wa' => $request->query('no_wa', old('no_wa')),
        ]);
    }

    /**
     * Step 2: Verifikasi OTP dan tampilkan form buat password
     * 1. Cek kode OTP valid & belum expired
     * 2. Jika valid -> tampilkan form password
     */
    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => ['required', 'string', 'size:6'],
            'name' => ['required', 'string', 'max:255'],
            'no_wa' => ['required', 'string'],
        ]);

        $noWa = $this->normalisasiNoWa($request->no_wa);

        // Cari OTP yang cocok
        $otpRecord = OtpCode::where('no_wa', $noWa)
            ->where('kode', $request->otp)
            ->where('sudah_dipakai', false)
            ->latest()
            ->first();

        // Cek OTP valid
        if (!$otpRecord || !$otpRecord->masihBerlaku()) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.'])->withInput();
        }

        // OTP valid -> simpan data di session dan tampilkan form password
        $request->session()->put('otp_verified', true);
        $request->session()->put('otp_id', $otpRecord->id);
        $request->session()->put('register_name', $request->name);
        $request->session()->put('register_no_wa', $noWa);

        return redirect()->route('register.password');
    }

    /**
     * Tampilkan form buat password (step 3)
     */
    public function showCreatePassword(Request $request)
    {
        if (!$request->session()->get('otp_verified')) {
            return redirect()->route('register');
        }

        return view('auth.create-password', [
            'name' => $request->session()->get('register_name'),
            'no_wa' => $request->session()->get('register_no_wa'),
        ]);
    }

    /**
     * Step 3: Buat password dan selesaikan registrasi
     * 1. Validasi password & konfirmasi
     * 2. Buat user baru
     * 3. Tandai OTP sudah dipakai
     * 4. Redirect ke login
     */
    public function createPassword(Request $request)
    {
        if (!$request->session()->get('otp_verified')) {
            return redirect()->route('register');
        }

        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->session()->get('register_name'),
            'no_wa' => $request->session()->get('register_no_wa'),
            'password' => $validated['password'], // Model otomatis hash via 'hashed' cast
            'role' => 'pengunjung',
        ]);

        // Tandai OTP sudah dipakai
        $otpId = $request->session()->get('otp_id');
        OtpCode::where('id', $otpId)->update(['sudah_dipakai' => true]);

        // Bersihkan session
        $request->session()->forget(['otp_verified', 'otp_id', 'register_name', 'register_no_wa']);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan nomor WhatsApp dan password Anda.');
    }

    /**
     * Proses logout
     * 1. Logout dari session
     * 2. Invalidate session
     * 3. Regenerate CSRF token
     * 4. Redirect ke login
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    /**
     * Normalisasi nomor WhatsApp ke format internasional (62xxx)
     * - Hapus spasi, dash, tanda +
     * - Ganti 08xxx -> 628xxx
     * - Ganti 8xxx (tanpa 0) -> 628xxx
     */
    private function normalisasiNoWa($noWa)
    {
        // Hapus semua karakter non-digit
        $noWa = preg_replace('/[^0-9]/', '', $noWa);

        // Ganti 08xxx -> 628xxx
        if (str_starts_with($noWa, '08')) {
            $noWa = '62' . substr($noWa, 1);
        }

        // Ganti 8xxx (tanpa 0) -> 628xxx
        if (str_starts_with($noWa, '8') && strlen($noWa) >= 10) {
            $noWa = '62' . $noWa;
        }

        return $noWa;
    }
}
