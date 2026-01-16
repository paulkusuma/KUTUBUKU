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

A03:2025 - Software Supply Chain Failures

1. Use of Outdated Vulnerable Dependencies (Simulated SSRF)

    Lokasi: app/Services/VulnerableImageFetcher.php, app/Http/Controllers/CartController.php.
    Deskripsi: Aplikasi menggunakan library pihak ketiga (VulnerableImageFetcher) yang memiliki kerentanan Server-Side Request Forgery (SSRF). Kerentanan ini mensimulasikan penggunaan dependency yang usang dan tidak aman. Fitur "Cetak Invoice" memungkinkan user untuk memasukkan URL yang akan di-fetch oleh server. Kerentanan di library tersebut memungkinkan penyerang untuk memaksa server mengakses URL internal atau jaringan internal atas nama server tersebut.
    PoC / Eksploitasi:
    Hidupkan server "penyerang" di localhost:8001 yang berisi gambar evil-logo.png.
    Buka fitur "Cetak Invoice" dari halaman keranjang.
    Di form "URL Logo", masukkan URL dari server penyerang: http://localhost:8001/evil-logo.png.
    Server KUTUBUKU akan mengakses URL tersebut dan menampilkan gambar dari server penyerang di halaman preview invoice. Ini membuktikan bahwa server KUTUBUKU bisa dipaksa untuk mengakses layanan lain di jaringan.
    Remediasi: Lihat branch main. Selalu perbarui dependency ke versi terbaru yang aman. Gunakan alat seperti composer audit untuk mendeteksi dependency yang rentan. Selain itu, validasi dan whitelist URL yang boleh diakses oleh aplikasi, dan jangan pernah menggunakan fungsi seperti file_get_contents() untuk URL dari input user tanpa validasi ketat.

2. Penjelasan Hubungan dengan Dependency

Pertanyaan Anda sangat tepat. Hubungannya sangat langsung: Dependency-nya adalah sumber kerentanannya.

Mari kita gunakan analogi yang sederhana:

     A03 (Software Supply Chain Failure): Ini adalah penyakitnya. Aplikasi KUTUBUKU "sakit" karena menggunakan "obat" (dependency) yang salah.
     SSRF (Server-Side Request Forgery): Ini adalah gejalanya. Karena minum obat yang salah, aplikasi menjadi "linglung" dan melakukan hal-hal di luar kendali (mengunjungi URL sembarangan).

Dalam Kode KUTUBUKU:

    Dependency-nya adalah file app/Services/VulnerableImageFetcher.php.
         Kita berpura-pura ini adalah library yang kita unduh dari internet (misalnya composer require bad-guy/image-fetcher).
         Tugasnya sederhana: mengambil gambar dari URL.


    Sumber Racunnya ada di dalam dependency itu.
         Lihat lagi kodenya: return file_get_contents($url);
         Fungsi file_get_contents() ini sangat berbahaya jika URL-nya berasal dari user. Ini adalah "racun" di dalam "obat" tersebut.


    Aplikasi KUTUBUKU (CartController.php) adalah "korban".
         Controller ini tidak tahu bahwa library yang ia gunakan berbahaya.
         Ia mempercayai library tersebut dan memberinya input dari user ($imageUrl).
         Akibatnya, server KUTUBUKU menjadi korban serangan SSRF.

Kesimpulan: A03 adalah penyebab utamanya (menggunakan dependency yang cacat), dan SSRF adalah dampak atau serangan yang terjadi karena penyebab utama tersebut. Tanpa dependency yang rentan, serangan SSRF melalui fitur ini tidak akan mungkin terjadi. 3. Tujuan Dependency dalam Aplikasi

Pertanyaan "dependencynya untuk apa?" adalah kunci untuk memahami konteksnya.

Tujuannya adalah untuk memenuhi kebutuhan bisnis: Mencetak invoice yang terlihat profesional.

    Kebutuhan: Tim marketing ingin setiap invoice yang dikirim ke pelanggan mencantumkan logo perusahaan.
    Masalah Teknis: Logo tidak selalu disimpan di server yang sama dengan aplikasi. Bisa jadi:
         Disimpan di CDN (Content Delivery Network) agar cepat diakses dari seluruh dunia.
         Disimpan di server terpisah yang digunakan tim marketing untuk mengupload aset.
         URL-nya bisa berubah sewaktu-waktu (misalnya logo-2023.png, logo-2024.png).

    Solusi (Dependency): Karena butuh cara untuk mengambil gambar dari URL eksternal, developer memutuskan untuk menggunakan library/image fetcher.
         Tugas library ini: "Diberikan URL, tolong ambilkan filenya dan kembalikan isinya."
         Ini adalah tugas yang umum, jadi wajar developer menggunakan library yang sudah ada daripada membuat dari nol.

Di sinilah letak kesalahannya:

     Pilihan yang Salah: Developer memilih library VulnerableImageFetcher (yang kita pura-pura ada) tanpa mengecek reputasinya atau mengetahui bahwa ia memiliki celah SSRF.
     Pilihan yang Benar: Seharusnya developer menggunakan library yang aman, atau membuat fungsi sendiri dengan validasi yang ketat (misalnya, hanya boleh mengambil URL dari domain cdn.kutubuku.test).

Jadi, dependency-nya punya tujuan yang sah dan penting bagi bisnis, tetapi karena Software Supply Chain Failure (memilih dependency yang salah), tujuan tersebut disalahgunakan oleh penyerang.

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

A08:2025 - Software or Data Integrity Failures

1. Software Update Without Verification

    Lokasi: app/Http/Controllers/AdminController.php (metode performUpdate).
    Deskripsi: Fitur pembaruan perangkat lunak mengunduh file dari URL yang diberikan admin tanpa melakukan verifikasi integritas. Aplikasi tidak memeriksa tanda tangan digital atau memastikan sumber URL terpercaya. Ini memungkinkan penyerang untuk menyuntikkan kode berbahaya ke dalam server dengan membujuk admin untuk mengunduh update dari URL yang telah dikendalikan.
    PoC / Eksploitasi:
    Seorang penyerang meng-host file berbahaya (misalnya JavaScript) di servernya.
    Penyerang membujuk admin untuk mengakses halaman update dan memasukkan URL berbahaya tersebut.
    Aplikasi mengunduh file tersebut dan menyimpannya di public/updates/latest_version.js.
    Penyerang sekarang bisa mengakses file berbahaya tersebut langsung dari server KUTUBUKU, yang bisa digunakan untuk serangan lanjutan (misalnya Stored XSS).
    Remediasi: Lihat branch main. Jangan pernah mengunduh dan menjalankan file dari sumber yang tidak tepercaya. Gunakan mekanisme verifikasi yang kuat seperti tanda tangan digital (digital signature). Aplikasi hanya boleh mengunduh update dari URL tepercaya dan harus memverifikasi signature file tersebut menggunakan kunci publik sebelum menggunakannya.

2. Panduan Eksploitasi Langkah demi Langkah (untuk Localhost)

    Berikut adalah cara mendemonstrasikan kerentanan ini di lingkungan localhost Anda.
    Bagian 1: Menyiapkan Server Penyerang Palsu
    Kita akan membuat server palsu di komputer yang sama untuk menyimulasikan serangan.
    Buat Folder "Penyerang":
    Buka File Explorer.
    Navigasi ke C:\laragon\www.
    Buat folder baru bernama attacker-server.
    Buat File Berbahaya:
    Di dalam folder C:\laragon\www\attacker-server, buat file baru bernama malicious.js.
    Buka file tersebut dan isi dengan kode JavaScript berikut:
    javascript
    // Kode ini akan menampilkan pesan peringatan saat dijalankan
    alert('SERANGAN BERHASIL! Kode berbahaya telah dijalankan dari server KUTUBUKU.');
    Hidupkan Server Penyerang:
    Buka terminal baru yang terpisah.
    Jalankan perintah ini untuk masuk ke folder penyerang:
    bash
    cd C:\laragon\www\attacker-server
    Jalankan server PHP di port 8001:
    bash
    php -S localhost:8001
    Biarkan terminal ini terbuka. Server penyerang Anda sekarang aktif di http://localhost:8001.
    Bagian 2: Melakukan Serangan ke Aplikasi KUTUBUKU
    Sekarang kita akan menyerang aplikasi utama.
    Pastikan Aplikasi KUTUBUKU Berjalan:
    Di terminal lain, pastikan server KUTUBUKU aktif dengan php artisan serve.
    Login sebagai Admin:
    Buka browser dan login ke aplikasi KUTUBUKU sebagai admin.
    Buka Halaman Update:
    Akses URL: http://127.0.0.1:8000/admin/update.
    Masukkan URL Berbahaya:
    Di form "URL Update", masukkan URL dari server penyerang palsu yang baru Anda buat:
    http://localhost:8001/malicious.js
    Jalankan Update:
    Klik tombol "Unduh dan Terapkan Update".
    Anda akan melihat pesan sukses: Update berhasil diunduh ke /updates/latest_version.js.
    Bagian 3: Verifikasi Hasil Eksploitasi
    Ini adalah langkah pembuktian bahwa serangan berhasil.
    Akses File yang Telah Dicuri:
    Buka tab baru di browser.
    Kunjungi URL file yang baru saja diunduh, tetapi dari server KUTUBUKU, bukan dari server penyerang:
    http://127.0.0.1:8000/updates/latest_version.js
    Lihat Hasilnya:
    Di halaman tersebut, Anda akan melihat kode JavaScript berbahaya Anda yang sekarang tersimpan dan di-hosting oleh server KUTUBUKU.
    Ini membuktikan bahwa server KUTUBUKU telah berhasil dieksploitasi untuk menyimpan file berbahaya. Penyerang sekarang bisa menggunakan file ini untuk melancarkan serangan lebih lanjut.

A09:2025 - Security Logging and Alerting Failures

1. Tidak Adanya Log untuk Kejadian Keamanan
   Pencatatan Informasi Sensitif ke Log File (CWE-532)
   Lokasi: app/Http/Controllers/ProfileController.php (metode updatePayment).
   Deskripsi: Aplikasi tidak hanya gagal mencatat kejadian keamanan, tetapi juga melakukan kesalahan sebaliknya: mencatat informasi yang terlalu sensitif. Saat user memperbarui informasi pembayaran, aplikasi mencatat SEMUA data request, termasuk nomor kartu kredit dan CVV, ke dalam file log teks biasa.
   PoC / Eksploitasi:
   Login dan buka halaman profil.
   Isi form "Informasi Pembayaran" dengan data kartu kredit.
   Klik "Simpan Pembayaran".
   Buka file log di storage/logs/laravel.log.
   Hasil: Nomor kartu kredit, CVV, dan data sensitif lainnya akan terlihat jelas dalam format teks biasa di file log.
   Remediasi: Lihat branch main. Jangan pernah mencatat informasi sensitif seperti password, nomor kartu kredit, atau CVV ke dalam log. Jika perlu mencatat request untuk debugging, pastikan untuk menyaring (filter) atau menghapus data sensitif sebelum dicatat.

A10:2025 - Mishandling of Exceptional Conditions

1.  Path Disclosure through Improper Error Handling

        Lokasi: app/Http/Controllers/ProfileController.php (metode showAvatar).
        Deskripsi: Aplikasi tidak menangani kondisi error dengan baik. Saat mencoba mengakses file yang tidak ada (dalam hal ini, avatar pengguna), aplikasi menampilkan pesan error yang mencakup path lengkap dari sistem file di server. Ini membocorkan informasi internal yang penting kepada penyerang.
        PoC / Eksploitasi:
            Login sebagai user mana pun.
            Akses halaman profil dan klik link "Lihat Avatar Saya" yang mengarah ke /profile/{id}/avatar.
            Karena file avatar tidak ada, aplikasi akan menampilkan error ErrorException.
            Pesan error tersebut akan menampilkan path lengkap server, seperti C:\laragon\www\KUTUBUKU\public\avatars\2.png.
        Remediasi: Lihat branch main. Selalu gunakan blok try...catch untuk menangani operasi yang mungkin gagal (seperti akses file). Jangan pernah menampilkan detail error sistem ke pengguna. Alih-alih, tampilkan pesan error yang generik dan log error detailnya ke file log untuk dianalisis oleh developer.

    Cara Menggunakan Lab Ini

        Pastikan Anda berada di branch staging (git checkout staging).
        Ikuti langkah-langkah eksploitasi yang dijelaskan di dokumentasi setiap kerentanan.
        Untuk melihat versi kode yang aman, bandingkan dengan branch main (git diff main staging).
        Jangan lupa untuk kembali ke branch dev (git checkout dev) jika ingin menambah fitur atau kerentanan baru dengan aman.

Lisensi

Proyek ini hanya untuk tujuan pendidikan.
