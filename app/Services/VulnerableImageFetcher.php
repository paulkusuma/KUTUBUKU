<?php

namespace App\Services;

/**
 * Kita berpura-pura ini adalah library pihak ketiga yang rentan.
 * Library ini digunakan untuk mengambil gambar dari URL.
 */
class VulnerableImageFetcher
{
    /**
     * Mengambil gambar dari URL (KERENTANAN ADA DI SINI).
     *
     * @param string $url URL gambar yang akan diambil.
     * @return string|false Isi file gambar atau false jika gagal.
     */
    public function fetchImage(string $url)
    {
        // !!! VULNERABILITY: A03 - SOFTWARE SUPPLY CHAIN FAILURE !!!
        // Fungsi file_get_contents() rentan terhadap SSRF jika URL berasal dari user.
        // Library "palsu" ini secara langsung mengakses URL tanpa validasi apapun.
        // Ini mensimulasikan library lama yang tidak aman.
        return file_get_contents($url);
    }
}