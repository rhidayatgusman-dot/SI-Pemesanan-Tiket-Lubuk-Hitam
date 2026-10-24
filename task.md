# Task Pengembangan - Sistem Pemesanan Tiket Air Terjun Lubuk Hitam

## Status: ✅ SELESAI (Semua task telah diimplementasikan)

Project ini adalah sistem pemesanan tiket untuk wisata Air Terjun Lubuk Hitam di Kota Padang. 
Dibangun menggunakan Laravel + Tailwind CSS + Chart.js.

---

## Fitur yang Sudah Diimplementasikan

### 1. ✅ Landing Page & Autentikasi
- **File**: `resources/views/layouts/app.blade.php`, `resources/views/beranda.blade.php`
- Navbar: Guest hanya melihat logo (tanpa tombol Daftar/Login di atas). Tombol Daftar & Login ada di hero section.
- Navbar: User yang sudah login melihat menu Beranda, Tiket Air Terjun, Pesanan Saya, dan dropdown profil.
- Landing page menggunakan foto air terjun lokal sebagai background (`public/images/bg-landing.jpg`).
- Form login & register menggunakan background foto air terjun lokal (`public/images/bg-landing.jpg`).
- Background halaman user (setelah login) menggunakan foto lokal (`public/images/bg-dashboard.jpg`).

### 2. ✅ Jadwal Operasional
- **Migration**: `database/migrations/2026_06_29_170000_create_jadwal_operasional_table.php`
- **Model**: `app/Models/JadwalOperasional.php`
- **Admin Controller**: `app/Http/Controllers/Admin/JadwalController.php`
- **Admin Views**: `resources/views/admin/jadwal/index.blade.php`, `resources/views/admin/jadwal/edit.blade.php`
- **Seeder**: `database/seeders/JadwalOperasionalSeeder.php`
- Admin bisa mengatur jam buka/tutup per hari, menandai hari libur, dan menambah keterangan.
- Pengunjung bisa melihat status buka/tutup real-time di halaman beranda (card hijau = buka, card merah = tutup).
- Tabel jadwal mingguan ditampilkan dengan highlight hari ini.
- Menu "Jadwal Operasional" tersedia di sidebar admin.

### 3. ✅ Pemesanan Tiket
- **Controller**: `app/Http/Controllers/PesananController.php`
- **Views**: `resources/views/pesanan/create.blade.php`, `pesanan/index.blade.php`, `pesanan/show.blade.php`
- User bisa memilih tiket, tanggal kunjungan, dan jumlah tiket.
- Validasi stok tiket tersedia.
- Upload bukti pembayaran (jpg/png/pdf, max 2MB).
- **Info Rekening**: Halaman upload bukti pembayaran menampilkan info rekening bank (BRI & Mandiri) atas nama "Objek Wisata Air Terjun Lubuk Hitam" agar user tahu kemana harus transfer.
- Status pesanan: pending → diterima/ditolak oleh admin.
- **FIXED**: Duplikat konten pada `pesanan/create.blade.php` telah dihapus.
- **FIXED**: Error `Call to undefined method PesananController::middleware()` telah diperbaiki (middleware dipindahkan ke route).
- **FIXED**: Validasi `exists:tikets,id` diubah menjadi `exists:tiket,id` (sesuai rename tabel).

### 3b. ✅ Cetak Tiket (Setelah Diterima)
- **View**: `resources/views/pesanan/cetak.blade.php`
- **Route**: `GET /pesanan/{id}/cetak` (hanya bisa diakses user yang login & status pesanan = diterima)
- Tiket cetak desain menarik dengan tema air terjun (waterfall-themed).
- Fitur: kode booking (LH-00001), QR code pattern, info pengunjung, tanggal kunjungan, jumlah, total.
- Print-friendly (A4), tombol cetak di halaman detail pesanan & daftar pesanan.
- Background foto air terjun di header tiket, notch design seperti tiket fisik.
- **Warna tiket cetak berdasarkan kategori**:
  - **Reguler**: Hijau (green gradient) - header & badge kategori
  - **Weekend**: Biru (blue gradient) - header & badge kategori
  - **Grup**: Teal/cyan (default) - header & badge kategori

### 4. ✅ Background Foto Air Terjun (User Login)
- **File**: `resources/views/layouts/app.blade.php`
- Semua halaman yang diakses user setelah login menggunakan background foto air terjun (dengan overlay transparan agar konten tetap terbaca).

### 4b. ✅ Desain Warna Menarik (Tema Wisata)
- **Palet warna baru**: Deep teal + turquoise (air) + amber/gold (sinar matahari) + sky blue (langit).
- **Primary**: Teal/cyan gradient (warna air air terjun).
- **Accent/CTA buttons**: Amber-to-orange gradient (menarik perhatian, hangat, mengundang).
- **Info cards**: Border-top berwarna berbeda (teal, amber, sky blue) untuk variasi visual.
- **Hero overlay**: Gradient teal-blue yang memberi nuansa tropis pada foto air terjun.
- **Footer**: Gradient dark dengan accent amber.
- **Files updated**: `layouts/app.blade.php`, `beranda.blade.php`, `auth/login.blade.php`, `auth/register.blade.php`

### 5. ✅ Manajemen Tiket (Admin)
- **Controller**: `app/Http/Controllers/Admin/TiketController.php`
- **Views**: `resources/views/admin/tiket/` (index, create, edit, show)
- CRUD tiket: nama, deskripsi, harga, kategori, stok, gambar.
- Kategori tiket: **Reguler, Weekend, Grup** (kategori lain telah dihapus).
- **Harga**: Reguler Rp12.000, Weekend Rp15.000, Grup Rp10.000.
- Tiket yang dihapus: Paket Keluarga, Paket Tracking Air Terjun, Tiket Mandi Air Terjun, Paket Fotografi, Tiket Camping Tepi Air Terjun, Paket Honeymoon, Tiket Anak-Anak.

### 6. ✅ Manajemen Pesanan (Admin)
- **Controller**: `app/Http/Controllers/Admin/PesananController.php`
- **Views**: `resources/views/admin/pesanan/` (index, show)
- Admin bisa menerima atau menolak pesanan.
- Admin bisa melihat bukti pembayaran yang diupload user.

### 7. ✅ Dashboard Admin & Laporan
- **Dashboard**: `app/Http/Controllers/Admin/DashboardController.php`
- **Laporan**: `app/Http/Controllers/Admin/LaporanController.php`
- Statistik: total pesanan, pendapatan, tiket terlaris.
- Grafik pendapatan dengan Chart.js.
- Filter laporan berdasarkan rentang tanggal.
- **Cetak PDF**: Laporan dapat dicetak sebagai PDF.
  - **Route**: `GET /admin/laporan/cetak-pdf` (dengan parameter start_date & end_date)
  - **View PDF**: `resources/views/admin/laporan-pdf.blade.php`
  - **Package**: `barryvdh/laravel-dompdf` (sudah terinstall)
  - Tombol "Cetak PDF" tersedia di halaman laporan (dibuka di tab baru).
  - PDF berisi: header, ringkasan pendapatan, tabel detail pesanan, pendapatan per hari, tanda tangan admin di sebelah kanan.

### 8. ✅ Kelola User (Admin)
- **Controller**: `app/Http/Controllers/Admin/UserController.php`
- **Views**: `resources/views/admin/user/` (index, create, edit)
- **Routes**: `Route::resource('user', UserController::class)` di dalam group admin
- CRUD user: nama, email, role (admin/pengunjung), password.
- Fitur pencarian berdasarkan nama atau email.
- Filter berdasarkan role (admin/pengunjung).
- Menampilkan jumlah pesanan per user.
- Avatar inisial huruf pertama dari nama user.
- **Proteksi**: Admin tidak bisa menghapus akun sendiri (muncul label "Anda").
- Password bersifat optional saat edit (kosongkan jika tidak ingin mengubah).
- Menu "Kelola User" tersedia di sidebar admin (antara Jadwal Operasional dan Laporan).

### 9. ✅ Testimoni Pengunjung (Dinamis)
- **Migration**: `database/migrations/2026_06_29_210000_create_testimonis_table.php`
- **Model**: `app/Models/Testimoni.php`
- **Controller**: `app/Http/Controllers/TestimoniController.php` (pengunjung kirim testimoni)
- **Admin Controller**: `app/Http/Controllers/Admin/TestimoniController.php` (approve/hapus)
- **Admin View**: `resources/views/admin/testimoni/index.blade.php`
- Pengunjung (guest/user) bisa kirim testimoni via form di beranda (nama, rating bintang 1-5, komentar)
- Testimoni baru default `is_approved = false`, admin harus approve via menu "Testimoni" di sidebar
- Hanya testimoni yang approved yang tampil di beranda
- 5 testimoni awal sudah di-seed ke database
- Menu "Testimoni" tersedia di sidebar admin

### 10. ✅ Kelola Tingkat Air Terjun (Admin)
- **Migration**: `database/migrations/2026_06_29_220000_create_tingkat_air_terjun_table.php`
- **Model**: `app/Models/TingkatAirTerjun.php`
- **Admin Controller**: `app/Http/Controllers/Admin/TingkatController.php` (index, edit, update, hapusFoto)
- **Admin Views**: `resources/views/admin/tingkat/` (index, edit)
- Admin bisa mengelola data 3 tingkat air terjun: nama, deskripsi, foto, tag fitur, emoji, status aktif
- Upload foto keindahan air terjun per tingkat (max 5MB)
- Foto ditampilkan di modal saat card tingkat di-klik di beranda
- 3 data tingkat awal sudah di-seed (Kolam Penerimaan, Air Terjun Utama, Puncak Air Terjun)
- Menu "Tingkat Air Terjun" tersedia di sidebar admin

---

## Struktur Database

| Tabel | Kolom Utama |
|-------|-------------|
| `users` | id, name, email, no_wa, password, role (admin/pengunjung) |
| `tiket` | id, nama_tiket, deskripsi, harga, kategori, stok, gambar |
| `pesanans` | id, user_id, tiket_id, tanggal_kunjungan, jumlah, total, status, bukti_pembayaran, catatan |
| `jadwal_operasional` | id, hari, jam_buka, jam_tutup, is_libur, keterangan |
| `testimonis` | id, nama, email, rating, komentar, is_approved |
| `tingkat_air_terjun` | id, tingkat, nama, deskripsi, foto, tag1-3, gradient, emoji, is_active, urutan |
| `otp_codes` | id, no_wa, kode, expired_at, sudah_dipakai |

---

## Akun Default (Password: `password123`)

| Role | Nama | No. WhatsApp |
|------|------|-------------|
| Admin | Admin | 6281234567890 |

**Catatan**: Semua user pengunjung telah dihapus. Hanya akun admin yang tersedia. Pengunjung baru bisa mendaftar sendiri melalui halaman registrasi.

---

## Cara Menjalankan

```bash
cd c:\laragon\www\tiket_lubukhitam
php artisan serve
```

Akses di: http://127.0.0.1:8000

---

## Catatan untuk Junior Programmer

1. **Jangan gunakan Write tool untuk overwrite file Blade** - selalu hapus file dulu dengan `DeleteFile` lalu buat baru, karena Write tool akan append konten.
2. **Setiap membuat view baru**, pastikan tidak ada duplikat `@extends` atau `@section` dalam satu file.
3. **Untuk menambahkan kategori tiket baru**, update di 4 tempat:
   - Validasi controller: `app/Http/Controllers/Admin/TiketController.php` (in:Reguler,Weekend,Grup)
   - Dropdown view: `resources/views/admin/tiket/create.blade.php` dan `edit.blade.php`
   - Seeder: `database/seeders/TiketSeeder.php`
   - Kategori saat ini: Reguler (Rp12.000), Weekend (Rp15.000), Grup (Rp10.000)
4. **Background foto** sekarang menggunakan gambar lokal di `public/images/`:
   - Landing page, login, register: `bg-landing.jpg` (dari `maxresdefault.jpg`)
   - Dashboard user (setelah login): `bg-dashboard.jpg` (dari `IMG_20210327_075203-623x414.jpg`)
   - Untuk mengganti: replace file di `public/images/` atau update path di:
     - `resources/views/beranda.blade.php` (hero-bg class)
     - `resources/views/auth/login.blade.php` (login-bg class)
     - `resources/views/auth/register.blade.php` (register-bg class)
     - `resources/views/layouts/app.blade.php` (authenticated background)
5. **PDF Export** menggunakan package `barryvdh/laravel-dompdf`. Untuk mengubah tampilan PDF:
   - Edit file: `resources/views/admin/laporan-pdf.blade.php`
   - PDF menggunakan inline CSS (dompdf tidak support Tailwind/external CSS)
   - Untuk menambahkan halaman PDF baru, buat view terpisah dan load dengan `Pdf::loadView()`
6. **Palet warna tema wisata**: Primary = teal/cyan (air), Accent = amber/orange (CTA buttons), Info cards = teal/amber/sky border-top. Jika ingin mengubah, update class Tailwind di file terkait.
7. **Kelola User** (CRUD) tersedia di menu admin sidebar. Fitur: search, filter role, avatar inisial, proteksi hapus akun sendiri. Password optional saat edit.
8. **Nama tabel tiket** sudah diubah dari `tikets` menjadi `tiket` (singular/bahasa Indonesia). Model `Tiket` menggunakan `protected $table = 'tiket'`. Migration file juga sudah di-rename ke `create_tiket_table.php`. Foreign key di tabel `pesanans` mengacu ke tabel `tiket`.
9. **Nomor rekening** di halaman upload bukti pembayaran (`pesanan/show.blade.php`) masih contoh (BRI: 1234-5678-9012, Mandiri: 0987-6543-2100). **Ganti dengan nomor rekening asli** milik objek wisata.
10. **Warna tiket cetak** (`pesanan/cetak.blade.php`): Reguler = hijau, Weekend = biru, Grup = teal/cyan. Warna diterapkan via class CSS `color-reguler`, `color-weekend`, `color-grup` pada header dan badge kategori.
11. **Warna teks** sudah diperjelas agar lebih mudah dibaca:
    - Light background: minimal `text-gray-600` untuk deskripsi, `text-gray-700` untuk label, `text-gray-800` untuk nilai/judul
    - Dark background (footer): `text-gray-300` agar lebih terang di atas dark
    - Tabel pesanan: header `text-gray-600`, data `text-gray-700`/`text-gray-800`
    - Total harga: `text-teal-700` (bukan emerald) agar konsisten dengan tema
12. **Komentar kode** sudah ditambahkan di semua file Model dan Controller untuk membantu junior programmer memahami alur logika:
    - **Models** (`app/Models/*.php`): Class-level docblock menjelaskan tabel, kolom, relasi, dan fungsi model. Setiap method punya komentar penjelasan.
    - **Controllers** (`app/Http/Controllers/**/*.php`): Class-level docblock menjelaskan alur logika secara keseluruhan. Setiap method punya docblock + inline comments.
    - **Routes** (`routes/web.php`): Route dikelompokkan dengan separator (Public/Auth/User/Admin) dan setiap route punya komentar.
    - File yang sudah dikomentari:
      - `app/Models/User.php`, `Tiket.php`, `Pesanan.php`, `JadwalOperasional.php`
      - `app/Http/Controllers/AuthController.php`, `HomeController.php`, `PesananController.php`, `TiketController.php`
      - `app/Http/Controllers/Admin/DashboardController.php`, `TiketController.php`, `PesananController.php`, `LaporanController.php`, `UserController.php`, `JadwalController.php`, `TestimoniController.php`
      - `app/Models/Testimoni.php`, `OtpCode.php`
      - `app/Http/Controllers/TestimoniController.php`
      - `routes/web.php`
13. **Sistem Testimoni Dinamis** - pengunjung bisa mengirim testimoni melalui form di beranda:
    - **Migration**: `database/migrations/2026_06_29_210000_create_testimonis_table.php`
    - **Model**: `app/Models/Testimoni.php` (scope `approved()` untuk yang sudah di-approve)
    - **Controller**: `app/Http/Controllers/TestimoniController.php` (store untuk pengunjung kirim testimoni)
    - **Admin Controller**: `app/Http/Controllers/Admin/TestimoniController.php` (index, approve, destroy)
    - **Admin View**: `resources/views/admin/testimoni/index.blade.php` (kelola testimoni: approve/hapus)
    - **Route**: `POST /testimoni` (public), `admin/testimoni/*` (admin)
    - Testimoni baru default `is_approved = false`, admin harus approve agar tampil di beranda
    - 5 testimoni awal sudah di-seed ke database (is_approved = true)
    - Menu "Testimoni" tersedia di sidebar admin
14. **Autentikasi sekarang menggunakan nomor WhatsApp + OTP** (bukan email):
    - **Login**: nomor WhatsApp + password (form di `auth/login.blade.php`)
    - **Registrasi**: 3 langkah - (1) masukkan nama & no WA, (2) verifikasi OTP, (3) buat password
    - **OTP** disimpan di tabel `otp_codes` (expired 5 menit). Saat ini OTP ditampilkan di layar (simulasi). Untuk produksi, integrasikan dengan WhatsApp API (Fonnte, Wablas, Twilio).
    - **File baru**: `app/Models/OtpCode.php`, `resources/views/auth/verify-otp.blade.php`, `resources/views/auth/create-password.blade.php`
    - **Migration baru**: `2026_06_29_200000_add_no_wa_to_users_table.php`, `2026_06_29_200001_create_otp_codes_table.php`
    - **Akun default** (password: `password123`): Admin WA: 6281234567890, User1: 6281234567891, User2: 6281234567892, User3: 6281234567893
15. **Upload bukti pembayaran** dibatasi maksimal **2MB** dengan format JPG, JPEG, PNG, PDF. Validasi ada di `PesananController@bayar` (`max:2048`). Info format & ukuran ditampilkan di form upload (`pesanan/show.blade.php`).
16. **Narasi "Harap tiba 15 menit sebelum jam operasional"** sudah dihapus dari tiket cetak (`pesanan/cetak.blade.php`).
17. **Blokir pemesanan saat wisata tutup** - pengunjung tidak bisa memesan tiket di luar jam operasional:
    - `PesananController@store` mengecek `JadwalOperasional::isOpenNow()` sebelum memproses pesanan
    - `PesananController@create` mengirim variabel `$isOpen` ke view
    - View `pesanan/create.blade.php` menampilkan banner merah "Wisata Sedang Tutup" dan menonaktifkan tombol submit jika wisata tutup
18. **Air Terjun 3 Tingkat** ditampilkan di beranda (`beranda.blade.php`):
    - Tingkat 1: Kolam Penerimaan (10m, kolam alami hijau toska, cocok berenang)
    - Tingkat 2: Air Terjun Utama (20m, debit deras, tebing batu berlumut)
    - Tingkat 3: Puncak Air Terjun (30m+, sumber mata air, spot tracking)
    - Setiap tingkat punya card dengan deskripsi, tag fitur, dan gradient warna berbeda
19. **Fasilitas** ditampilkan di beranda (12 fasilitas): Parkir, Musholla, Toilet, Warung, Spot Foto, Camping, Jalur Trek, Souvenir, Area Keluarga, Kolam Renang, WiFi, P3K
20. **PDF Laporan** sekarang memiliki **halaman judul/cover** sebelum konten laporan:
    - Cover page berisi: logo, nama wisata, judul "LAPORAN PEMESANAN TIKET", periode laporan, tanggal cetak
    - Menggunakan `page-break-after: always` agar cover terpisah dari konten
    - Edit di: `resources/views/admin/laporan-pdf.blade.php`
21. **Fasilitas** di beranda telah diperbarui menjadi 6 fasilitas utama:
    - 🅿️ Area Parkir | 🚻 Toilet Umum | 📸 Spot Foto | 🏊 Renang | 🍽️ Warung | 🧗 Cliff Jumping
    - Edit di: `resources/views/beranda.blade.php` section "Fasilitas"
22. **Tingkat Air Terjun** sekarang bisa dikelola oleh admin:
    - **Migration**: `database/migrations/2026_06_29_220000_create_tingkat_air_terjun_table.php`
    - **Model**: `app/Models/TingkatAirTerjun.php`
    - **Admin Controller**: `app/Http/Controllers/Admin/TingkatController.php`
    - **Admin Views**: `resources/views/admin/tingkat/` (index, edit)
    - **Route**: `admin/tingkat/*` (admin)
    - Admin bisa edit: nama, deskripsi, foto (upload), tag fitur, emoji, status aktif
    - Foto yang diupload admin akan ditampilkan di **modal** saat card tingkat di-klik di beranda
    - 3 data tingkat awal sudah di-seed (Kolam Penerimaan, Air Terjun Utama, Puncak Air Terjun)
    - Menu "Tingkat Air Terjun" tersedia di sidebar admin
23. **Semua user pengunjung telah dihapus** - hanya akun admin yang tersisa. UserSeeder hanya membuat admin.
24. **Fix: Error @json() dengan closure multi-line** - Blade `@json()` tidak bisa parsing closure multi-line. Solusi: siapkan data JSON di controller (`$tingkatJson`) lalu gunakan `{!! json_encode($tingkatJson) !!}` di view.
25. **Fix: Duplicate content di `register.blade.php`** - File memiliki duplikasi konten (2x `@extends`). Duplikat dihapus, hanya form WhatsApp OTP yang benar yang dipertahankan.
26. **Fix: Duplicate content di `login.blade.php`** - File memiliki duplikasi konten (form email lama). Duplikat dihapus, hanya form WhatsApp login yang benar yang dipertahankan.
27. **Fix: Wrong route di `verify-otp.blade.php`** - Form action menggunakan `register.otp.verify` (GET) seharusnya `register.otp.verify.post` (POST).
28. **Fix: Double password hashing** - `AuthController::createPassword()` menggunakan `Hash::make()` + model User punya cast `'password' => 'hashed'`, menyebabkan password di-hash 2x (tidak bisa login). Solusi: hapus `Hash::make()`, biarkan model yang hash otomatis.
29. **Semua referensi email telah diubah ke nomor WhatsApp** - File yang diubah:
    - Views: `admin/user/index`, `create`, `edit` (kolom & form email → no_wa)
    - Views: `admin/pesanan/show` (Email → WhatsApp), `pesanan/cetak` (email → no_wa)
    - Views: `layouts/app.blade.php` (kontak email → WhatsApp)
    - Controller: `Admin/UserController.php` (search, validasi, store, update → no_wa)
    - Model: `Testimoni.php` (hapus email dari fillable), `User.php` (hapus email_verified_at cast)
    - Controller: `TestimoniController.php` (hapus referensi email)
    - Seeder: `UserSeeder.php` (hapus email admin)
30. **Jadwal Operasional sudah di-seed** - 7 hari (Senin-Minggu):
    - Senin-Jumat: 08:00 - 17:00 (hari biasa)
    - Sabtu-Minggu: 07:00 - 18:00 (weekend, jam lebih panjang)
    - Tidak ada hari libur
31. **Tiket Air Terjun sudah di-seed** - 7 jenis tiket:
    - Tiket Masuk Reguler: Rp 15.000 (Senin-Jumat)
    - Tiket Masuk Weekend: Rp 20.000 (Sabtu-Minggu)
    - Tiket Grup (Rombongan): Rp 12.000/orang (min 10 orang)
    - Tiket Anak-Anak: Rp 10.000 (usia 3-12 tahun)
    - Tiket Parkir Motor: Rp 5.000
    - Tiket Parkir Mobil: Rp 10.000
32. **Tingkat Air Terjun sudah di-seed** - 3 tingkat:
    - Tingkat 1: Kolam Penerimaan 🏊 (renang, snorkeling, keluarga)
    - Tingkat 2: Air Terjun Utama 💧 (air terjun, spot foto, cliff jumping)
    - Tingkat 3: Puncak Air Terjun ⛰️ (hiking, panorama, adventure)
33. **Fix: Jadwal operasional beranda tidak sesuai admin** - `isOpenNow()` sebelumnya cek jam sekarang vs jam buka/tutup, menyebabkan status "TUTUP" muncul sebelum jam buka meski admin sudah atur jadwal. Solusi: ubah logika menjadi cek apakah hari ini ada jadwal dan bukan libur (tanpa cek jam), sehingga status di beranda selalu sesuai dengan jadwal yang dikelola admin.
34. **Fix: Alur login pemesanan tiket** - Tombol "Login untuk Memesan" di `tiket/show.blade.php` sebelumnya langsung ke `route('login')` tanpa menyimpan intended URL, sehingga setelah login user diarahkan ke beranda bukan ke halaman pemesanan. Solusi: ubah link menjadi `route('pesanan.create', ['tiket_id' => $tiket->id])` sehingga auth middleware menyimpan intended URL otomatis. Tombol "Pesan" di `beranda.blade.php` juga diubah dari `tiket.show` ke `pesanan.create` agar alur pemesanan lebih langsung.
35. **Kop laporan PDF ditambahkan** - Header gradient pada `admin/laporan-pdf.blade.php` diganti dengan kop laporan formal:
    - Nama objek wisata (bold, teal, uppercase): "Objek Wisata Air Terjun Lubuk Hitam"
    - Alamat: "Kelurahan Teluk Kabung Utara, Kecamatan Bungus Teluk Kabung"
    - Kota: "Kota Padang, Sumatera Barat"
    - Judul laporan: "LAPORAN PENJUALAN TIKET WISATA"
    - Garis pemisah double border teal di bawah kop
    - Periode laporan ditempatkan tepat di bawah kop
36. **Fitur Galeri Foto Pengunjung ditambahkan** - Pengunjung bisa upload foto kunjungan dari halaman Detail Pesanan, admin moderasi (approve/reject/hapus), foto disetujui tampil di beranda.
    - **Database**: Tabel `galeri` (id, user_id, foto, caption, tanggal_kunjungan, status, timestamps)
    - **Model**: `App\Models\Galeri` - scope `disetujui()`, `pending()`, relasi `user()`, method `hapusFoto()`
    - **Visitor Controller**: `GaleriController` - index, saya, create (redirect), store, destroy
    - **Admin Controller**: `Admin\GaleriController` - index (filter status + search), approve, reject, destroy
    - **Letak Upload**: Form upload foto terintegrasi di `pesanan/show.blade.php` (Detail Pesanan)
    - **Syarat tombol upload**: Hanya tampil jika status pesanan = 'diterima' DAN tanggal kunjungan sudah lewat
    - **Views visitor**: `galeri/index.blade.php` (grid galeri + tombol Foto Saya), `galeri/saya.blade.php` (status foto saya: pending/disetujui/ditolak)
    - **Views admin**: `admin/galeri/index.blade.php` (grid dengan badge status, filter, search, approve/reject/hapus)
    - **Beranda**: Section galeri pengunjung (max 12 foto, grid 2-4 kolom responsif, hover effect, tombol "Lihat Semua")
    - **Routes**: `/galeri` (index), `/galeri/foto-saya` (saya), POST `/galeri/upload` (store), DELETE `/galeri/{id}` (destroy)
    - **Admin routes**: `/admin/galeri` (index), POST approve/reject, DELETE destroy
    - **Sidebar admin**: Menu "Galeri Pengunjung" ditambahkan setelah Testimoni
    - **Validasi**: JPG/JPEG/PNG/WEBP, max 5MB, caption opsional max 255 char
    - **Storage**: `storage/app/public/gallery/` dengan nama file unik
    - **Alur**: Beranda → Login → Pesanan Saya → Detail Pesanan → Upload Foto Kunjungan
    - **Notifikasi sukses**: "Foto berhasil diunggah dan sedang menunggu persetujuan admin."
37. **Fitur Galeri Foto Fasilitas ditambahkan** - Master data fasilitas + galeri foto per fasilitas, admin CRUD, pengunjung bisa lihat foto via modal popup di beranda.
    - **Database**: Tabel `fasilitas` (id, nama, icon, deskripsi, is_active, urutan, timestamps) + `galeri_fasilitas` (id, fasilitas_id, judul, deskripsi, foto, status, timestamps)
    - **Models**: `Fasilitas` (scope active, relasi galeriFotos/galeriAktif), `GaleriFasilitas` (relasi fasilitas, method hapusFoto)
    - **Admin Controller**: `Admin\FasilitasController` - CRUD + toggle aktif/nonaktif, `Admin\GaleriFasilitasController` - CRUD foto + toggle status
    - **Views admin**: `admin/fasilitas/index.blade.php` (table + modal tambah/edit), `admin/galeri_fasilitas/index.blade.php` (grid foto + filter), `create.blade.php`, `edit.blade.php`
    - **Beranda**: Section fasilitas dinamis dari database, ikon bisa diklik → modal popup menampilkan galeri foto + lightbox prev/next
    - **Lightbox**: Klik foto di modal → tampil ukuran besar, navigasi prev/next, counter foto
    - **Grid responsif**: Desktop 4 foto/baris, Tablet 3, Mobile 2
    - **Routes admin**: `/admin/fasilitas` (CRUD + toggle), `/admin/galeri-fasilitas` (CRUD + toggle status)
    - **Sidebar admin**: Menu "Fasilitas" dan "Galeri Fasilitas" ditambahkan
    - **Validasi**: JPG/JPEG/PNG/WEBP, max 5MB, judul/deskripsi opsional
    - **Storage**: `storage/app/public/fasilitas/` dengan nama file unik
    - **Data awal**: 6 fasilitas (Area Parkir, Toilet Umum, Spot Foto, Kolam Renang, Warung, Cliff Jumping)
38. **Fix error tiket/show.blade.php** - Syntax error `@else` tanpa `@if` pada bagian foto tiket.
    - **Penyebab**: Blok `@if($tiket->foto)` hilang, menyisakan `@else` dan `@endif` tanpa pasangan
    - **Fix**: Tambahkan kembali `@if($tiket->foto)` untuk menampilkan gambar tiket jika ada
    - **Verifikasi**: Semua halaman public (beranda, tiket, tiket/1, tiket/2, login, register, galeri) berjalan tanpa error 500
39. **Penambahan kolom pada tabel laporan** - Tabel laporan web dan PDF diperbarui dengan 10 kolom sesuai kebutuhan.
    - **Kolom baru**: No, Kode Booking (#00001), Nama Pengunjung, Nomor WhatsApp, Nama Tiket, Tanggal Kunjungan (dd-mm-yyyy), Jumlah Tiket, Total Pembayaran (Rp), Status Pesanan (badge warna), Tanggal Pemesanan (dd-mm-yyyy)
    - **Controller**: `LaporanController` - Query sekarang menampilkan semua status pesanan (tidak hanya diterima), total pendapatan hanya dihitung dari pesanan diterima, menggunakan eager loading `with(['user', 'tiket'])`
    - **View web** (`admin/laporan.blade.php`): Tabel responsif dengan `overflow-x-auto` dan `min-w-[900px]`, badge status berwarna (yellow=pending, green=diterima, red=ditolak)
    - **View PDF** (`admin/laporan-pdf.blade.php`): Paper A4 landscape, font size disesuaikan (9px body, 8px header), kolom total baris di bawah dengan label "TOTAL (Diterima)"
    - **Format tanggal**: `d-m-Y` untuk Tanggal Kunjungan dan Tanggal Pemesanan
    - **Format nominal**: `Rp X.XXX.XXX` (titik sebagai pemisah ribuan)
    - **PDF dan Web**: Data sama di kedua tampilan
