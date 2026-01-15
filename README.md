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
