KUTUBUKU - Vulnerable Web Application

    PERINGATAN PENTING: Proyek ini adalah aplikasi web yang sengaja dibuat rentan untuk tujuan pendidikan dan pelatihan keamanan siber. JANGAN PERNAH menggunakan kode ini di lingkungan produksi atau aplikasi sungguhan.

KUTUBUKU adalah toko buku online sederhana yang dibangun dengan framework Laravel. Aplikasi ini mengandung beberapa kerentanan dari daftar OWASP Top 10 2021 yang dapat dieksploitasi untuk pembelajaran.
Setup

    Clone Repository

    git clone https://github.com/paulkusuma/KUTUBUKU.gitcd KUTUBUKU

    Install Dependencies

    composer installnpm installnpm run build

    Setup Environment

    cp .env.example .envphp artisan key:generate

    Sesuaikan konfigurasi database di file .env.

    Run Database Migrations and Seeders

    php artisan migratephp artisan db:seed

    Run Application

    php artisan serve

    Aplikasi akan tersedia di http://127.0.0.1:8000.

Dokumentasi Kerentanan

Berikut adalah daftar kerentanan yang ada di aplikasi ini.

A01:2021 - Broken Access Control

1. Insecure Direct Object Reference (IDOR)

    Lokasi: app/Http/Controllers/ProfileController.php:34
    Deskripsi: Aplikasi mempercayai parameter ID dari URL untuk mengambil data profil pengguna tanpa memvalidasi apakah pengguna yang sedang login memiliki otoritas untuk melihat data tersebut.
    PoC / Eksploitasi:
    Login sebagai User A.
    Akses profil User A di /profile/2.
    Ubah URL secara manual menjadi /profile/3 (profil User B).
    User A dapat melihat data profil User B.
    Remediasi: Lihat branch main. Gunakan data dari user yang sedang login ($request->user()) alih-alih mengambil data berdasarkan ID dari input pengguna.

2. Vertical Privilege Escalation

    Lokasi: app/Http/Controllers/AdminController.php:17 dan routes/web.php:XX
    Deskripsi: Endpoint /admin/dashboard tidak dilindungi oleh middleware yang memeriksa role pengguna. Semua pengguna yang sudah login dapat mengakses fungsi admin.
    PoC / Eksploitasi:
    Login sebagai user biasa.
    Akses langsung URL /admin/dashboard.
    User biasa dapat melihat dashboard admin yang berisi data sensitif.
    Remediasi: Lihat branch main. Tambahkan middleware khusus untuk memeriksa role, misalnya ->middleware('auth', 'role:admin').

A02:2025 - Security Misconfiguration

1. Debug Mode Enabled in Production

    Lokasi: File .env
    Deskripsi: Aplikasi dikonfigurasi dengan APP_DEBUG=true. Di lingkungan produksi, ini adalah kesalahan fatal. Ini menyebabkan aplikasi menampilkan pesan error detail, termasuk stack trace dan variabel lingkungan (seperti password database dan API key) kepada siapa saja yang memicu kesalahan, bahkan kesalahan sepele sekalipun.
    PoC / Eksploitasi:
    Akses URL yang sengaja dibuat untuk menyebabkan error, misalnya /debug-error. Route ini sengaja dibuat untuk memicu DivisionByZeroError.
    Halaman akan menampilkan halaman error detail dari Laravel/Ignition.
    Di bagian "Environment" atau "Context", penyerang dapat melihat semua kredensial sensitif yang disimpan dalam variabel lingkungan .env, seperti DB_PASSWORD, APP_KEY, dll.
    Remediasi: Lihat branch main. Pastikan APP_DEBUG diset ke false di lingkungan produksi. Selain itu, buat halaman error kustom (resources/views/errors/500.blade.php) yang ramah pengguna dan tidak membocorkan informasi apa pun.

A04:2021 - Cryptographic Failures

1. Penyimpanan Data Kartu Kredit dalam Plaintext

    Lokasi:
    database/migrations/YYYY_MM_DD_HHMMSS_add_card_fields_to_users_table.php
    app/Http/Controllers/ProfileController.php (metode updatePayment)
    resources/views/profile/edit.blade.php

    Deskripsi: Aplikasi menyimpan informasi kartu kredit (nomor kartu, CVV, masa berlaku, dan nama pemegang kartu) dalam database sebagai plaintext tanpa enkripsi atau hash. Ini adalah pelanggaran serius terhadap standar keamanan data kartu pembayaran (PCI DSS) dan sangat berbahaya jika database mengalami kebocoran data.
    PoC / Eksploitasi:
    Login sebagai user mana pun.
    Navigasi ke halaman profil (/profile/{id}).
    Isi formulir "Informasi Pembayaran" dengan data kartu kredit palsu (misalnya: 4111 1111 1111 1111).
    Klik tombol "Simpan Pembayaran".
    Akses database langsung (melalui php artisan tinker, phpMyAdmin, atau alat lainnya).
    Periksa tabel users pada baris user tersebut. Data kartu kredit akan terlihat jelas dalam format plaintext.
    Remediasi: Lihat branch main. Jangan pernah menyimpan data kartu kredit lengkap. Jika memang harus menyimpan referensi, simpan hanya informasi non-sensitif seperti 4 digit terakhir. Untuk data yang perlu dienkripsi, gunakan enkripsi yang kuat yang disediakan oleh Laravel seperti Crypt::encrypt().

A05:2021 - Injection

1. SQL Injection (SQLi)

    Lokasi: app/Http/Controllers/BookController.php pada metode index.
    Deskripsi: Aplikasi menggabungkan input pengguna secara langsung ke dalam query SQL mentah tanpa sanitasi atau penggunaan prepared statements. Ini memungkinkan penyerang untuk memanipulasi logika query untuk mengakses atau memodifikasi data yang seharusnya tidak dapat diakses.
    PoC / Eksploitasi:
    Login sebagai user mana pun.
    Navigasi ke halaman daftar buku (/books).
    Di kotak pencarian, masukkan payload SQL Injection: ' OR '1'='1
    Klik tombol "Cari".
    Hasil: Query SQL dieksekusi menjadi SELECT \* FROM books WHERE title LIKE '%' OR '1'='1' .... Karena kondisi '1'='1' selalu benar, query akan mengembalikan SEMUA BUKU dari database, mengabaikan logika pencarian.
    Remediasi: Lihat branch main. Gunakan Laravel Eloquent ORM atau Query Builder dengan metode where(), yang secara otomatis menggunakan parameter binding untuk mencegah SQL Injection. Contoh: Book::where('title', 'like', '%' . $search . '%')->get();.

A06:2021 - Insecure Design

    Lokasi: app/Http/Controllers/CartController.php pada metode checkout dan resources/views/cart/index.blade.php.
    Deskripsi: Logika bisnis cacat memungkinkan pengguna untuk memanipulasi data penting (seperti harga) saat proses checkout. Backend mempercayai data yang dikirim dari frontend tanpa melakukan validasi ulang terhadap sumber kebenaran (database atau session).
    PoC / Eksploitasi:
        Tambahkan item ke keranjang.
        Buka Developer Tools, tab Network.
        Klik "Checkout" dan intersepsi permintaan.
        Di tab "Payload", ubah nilai total_price menjadi lebih rendah.
        Kirim ulang request.
        Hasil: Pembayaran berhasil diproses dengan harga yang telah dimanipulasi.
    Remediasi: Lihat branch main. Backend harus selalu menghitung ulang total harga berdasarkan data di keranjang (session) dan mengabaikan nilai harga yang dikirim dari request.

A07:2021 - Authentication Failures

    Lokasi: app/Http/Controllers/RegisteredUserController.php pada metode store.
    Deskripsi: Aplikasi mengizinkan pengguna untuk membuat kata sandi yang sangat lemah (misalnya, satu karakter), membuat akun rentan terhadap serangan tebak kata sandi (password guessing) dan serangan kamus (dictionary attack).
    PoC / Eksploitasi:
        Buka halaman pendaftaran.
        Daftarkan akun baru dengan password "1" atau "123".
        Hasil: Sistem menerima kata sandi yang sangat lemah.
    Remediasi: Lihat branch main. Gunakan aturan password yang kuat, seperti yang disediakan oleh Rules\Password::defaults(), yang memerlukan panjang, kombinasi huruf besar/kecil, angka, dan simbol.

Cara Menggunakan Lab Ini

    Pastikan Anda berada di branch staging (git checkout staging).
    Ikuti langkah-langkah eksploitasi yang dijelaskan di dokumentasi setiap kerentanan.
    Untuk melihat versi kode yang aman, bandingkan dengan branch main (git diff main staging).
    Jangan lupa untuk kembali ke branch dev (git checkout dev) jika ingin menambah fitur atau kerentanan baru dengan aman.

Lisensi

Proyek ini hanya untuk tujuan pendidikan.
