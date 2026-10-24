<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\GaleriFasilitasController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PesananController as AdminPesananController;
use App\Http\Controllers\Admin\TiketController as AdminTiketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TestimoniController as AdminTestimoniController;
use App\Http\Controllers\Admin\TingkatController as AdminTingkatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\TiketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ROUTE APLIKASI SISTEM PEMESANAN TIKET
|--------------------------------------------------------------------------
| 
| Struktur route dibagi menjadi 3 bagian:
| 1. Public routes  - Bisa diakses tanpa login (beranda, tiket, login, register)
| 2. User routes    - Harus login (pesanan, bayar, cetak tiket)
| 3. Admin routes   - Harus login sebagai admin (dashboard, CRUD, laporan)
|
| Middleware:
| - 'guest'        : Hanya untuk yang belum login
| - 'auth'         : Harus login
| - 'role:admin'   : Harus admin (dicek di AppServiceProvider)
|
*/

// ============================================================
// 1. PUBLIC ROUTES - Bisa diakses tanpa login
// ============================================================
Route::get('/', [HomeController::class, 'index'])->name('beranda');           // Landing page
Route::get('/tiket', [TiketController::class, 'index'])->name('tiket.index'); // Daftar tiket
Route::get('/tiket/{id}', [TiketController::class, 'show'])->name('tiket.show'); // Detail tiket
Route::post('/testimoni', [TestimoniController::class, 'store'])->name('testimoni.store'); // Kirim testimoni

// ============================================================
// 2. AUTH ROUTES - Login & Register dengan OTP (hanya untuk guest)
// ============================================================
Route::middleware('guest')->group(function () {
    // Login dengan nomor WhatsApp + password
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Register dengan OTP (3 langkah):
    // Step 1: Form daftar -> masukkan nama & no WA
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register/otp', [AuthController::class, 'kirimOtp'])->name('register.otp.send');
    
    // Step 2: Verifikasi OTP
    Route::get('/register/verifikasi', [AuthController::class, 'showVerifyOtp'])->name('register.otp.verify');
    Route::post('/register/verifikasi', [AuthController::class, 'verifyOtp'])->name('register.otp.verify.post');
    
    // Step 3: Buat password setelah OTP terverifikasi
    Route::get('/register/password', [AuthController::class, 'showCreatePassword'])->name('register.password');
    Route::post('/register/password', [AuthController::class, 'createPassword'])->name('register.password.store');
});

// Logout (harus login dulu)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ============================================================
// 3. USER ROUTES - Harus login (pengunjung/admin)
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');       // Daftar pesanan saya
    Route::get('/pesanan/buat', [PesananController::class, 'create'])->name('pesanan.create'); // Form pemesanan
    Route::post('/pesanan/buat', [PesananController::class, 'store'])->name('pesanan.store');  // Simpan pesanan
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');     // Detail pesanan
    Route::post('/pesanan/{id}/bayar', [PesananController::class, 'bayar'])->name('pesanan.bayar'); // Upload bukti bayar
    Route::get('/pesanan/{id}/cetak', [PesananController::class, 'cetak'])->name('pesanan.cetak');  // Cetak e-ticket

    // Galeri Pengunjung (upload foto)
    Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');           // Daftar galeri
    Route::get('/galeri/foto-saya', [GaleriController::class, 'saya'])->name('galeri.saya');  // Foto saya
    Route::get('/galeri/upload', [GaleriController::class, 'create'])->name('galeri.create');  // Form upload
    Route::post('/galeri/upload', [GaleriController::class, 'store'])->name('galeri.store');   // Simpan foto
    Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy'); // Hapus foto
});

// ============================================================
// 4. ADMIN ROUTES - Harus login sebagai admin
// ============================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Tiket (resource controller: index, create, store, edit, update, destroy, show)
    Route::resource('tiket', AdminTiketController::class);
    
    // Kelola Pesanan (verifikasi pembayaran)
    Route::get('pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index');       // Daftar pesanan
    Route::get('pesanan/{id}', [AdminPesananController::class, 'show'])->name('pesanan.show');     // Detail + bukti bayar
    Route::post('pesanan/{id}/terima', [AdminPesananController::class, 'terima'])->name('pesanan.terima'); // Terima pesanan
    Route::post('pesanan/{id}/tolak', [AdminPesananController::class, 'tolak'])->name('pesanan.tolak');   // Tolak pesanan
    
    // Laporan & PDF
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');           // Halaman laporan
    Route::get('/laporan/cetak-pdf', [LaporanController::class, 'cetakPdf'])->name('laporan.cetak-pdf'); // Download PDF
    
    // Jadwal Operasional
    Route::get('jadwal', [JadwalController::class, 'index'])->name('jadwal.index');               // Daftar jadwal
    Route::get('jadwal/{id}/edit', [JadwalController::class, 'edit'])->name('jadwal.edit');       // Edit jadwal
    Route::put('jadwal/{id}', [JadwalController::class, 'update'])->name('jadwal.update');        // Update jadwal

    // CRUD User (resource controller)
    Route::resource('user', UserController::class);

    // Kelola Testimoni (approve/reject komentar pengunjung)
    Route::get('testimoni', [AdminTestimoniController::class, 'index'])->name('testimoni.index');       // Daftar testimoni
    Route::post('testimoni/{id}/approve', [AdminTestimoniController::class, 'approve'])->name('testimoni.approve'); // Approve testimoni
    Route::delete('testimoni/{id}', [AdminTestimoniController::class, 'destroy'])->name('testimoni.destroy');       // Hapus testimoni

    // Kelola Tingkat Air Terjun (3 tingkat)
    Route::get('tingkat', [AdminTingkatController::class, 'index'])->name('tingkat.index');             // Daftar tingkat
    Route::get('tingkat/{id}/edit', [AdminTingkatController::class, 'edit'])->name('tingkat.edit');     // Edit tingkat
    Route::put('tingkat/{id}', [AdminTingkatController::class, 'update'])->name('tingkat.update');      // Update tingkat
    Route::delete('tingkat/{id}/foto', [AdminTingkatController::class, 'hapusFoto'])->name('tingkat.hapus-foto'); // Hapus foto

    // Kelola Galeri Pengunjung
    Route::get('galeri', [AdminGaleriController::class, 'index'])->name('galeri.index');               // Daftar galeri
    Route::post('galeri/{id}/approve', [AdminGaleriController::class, 'approve'])->name('galeri.approve'); // Setujui foto
    Route::post('galeri/{id}/reject', [AdminGaleriController::class, 'reject'])->name('galeri.reject');   // Tolak foto
    Route::delete('galeri/{id}', [AdminGaleriController::class, 'destroy'])->name('galeri.destroy');     // Hapus foto

    // Master Fasilitas
    Route::get('fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');
    Route::post('fasilitas', [FasilitasController::class, 'store'])->name('fasilitas.store');
    Route::put('fasilitas/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update');
    Route::get('fasilitas/{id}/toggle', [FasilitasController::class, 'toggleActive'])->name('fasilitas.toggle');
    Route::delete('fasilitas/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy');

    // Galeri Fasilitas
    Route::get('galeri-fasilitas', [GaleriFasilitasController::class, 'index'])->name('galeri-fasilitas.index');
    Route::get('galeri-fasilitas/create', [GaleriFasilitasController::class, 'create'])->name('galeri-fasilitas.create');
    Route::post('galeri-fasilitas', [GaleriFasilitasController::class, 'store'])->name('galeri-fasilitas.store');
    Route::get('galeri-fasilitas/{id}/edit', [GaleriFasilitasController::class, 'edit'])->name('galeri-fasilitas.edit');
    Route::put('galeri-fasilitas/{id}', [GaleriFasilitasController::class, 'update'])->name('galeri-fasilitas.update');
    Route::get('galeri-fasilitas/{id}/toggle', [GaleriFasilitasController::class, 'toggleStatus'])->name('galeri-fasilitas.toggle-status');
    Route::delete('galeri-fasilitas/{id}', [GaleriFasilitasController::class, 'destroy'])->name('galeri-fasilitas.destroy');
});
