<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

use Illuminate\Support\Facades\Session;

use App\Services\VulnerableImageFetcher;
class CartController extends Controller
{
    // Menambahkan buku ke keranjang
    public function addToCart($id)
    {
        $book = Book::findOrFail($id);
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "title" => $book->title,
                "price" => $book->price, // Harga diambil dari database
                "quantity" => 1
            ];
        }

        Session::put('cart', $cart);
        return redirect()->back()->with('success', 'Buku ditambahkan ke keranjang!');
    }

    // Menampilkan halaman keranjang
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Proses checkout (versi aman)
    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // !!! VULNERABILITY: INSECURE DESIGN !!!
        // Backend mempercayai total harga yang dikirim dari frontend tanpa validasi.
        $totalPrice = $request->input('total_price'); // Diambil dari request!

        // Di dunia nyata, di sini akan ada logika pembayaran ke gateway, dll.
        // Untuk lab, kita cukup kosongkan keranjang dan tampilkan pesan sukses.
        Session::forget('cart');

        return view('cart.success', ['totalPrice' => $totalPrice]);
        // // !!! LOGIKA AMAN: Hitung ulang total harga di backend !!!
        // $totalPrice = 0;
        // foreach ($cart as $item) {
        //     $totalPrice += $item['price'] * $item['quantity'];
        // }

        // // Di dunia nyata, di sini akan ada logika pembayaran ke gateway, dll.
        // // Untuk lab, kita cukup kosongkan keranjang dan tampilkan pesan sukses.
        // Session::forget('cart');

        // return view('cart.success', ['totalPrice' => $totalPrice]);
    }

    /**
     * Cetak invoice dengan gambar logo (KERENTANAN ADA DI SINI).
     */
    public function generateInvoice(Request $request)
    {
        // // !!! SIMULASI KEPERCAYAAN DEVELOPER !!!
        // // Developer mempercayai dependency dan konfigurasi yang telah dibuat.
        // $logoUrl = config('app.invoice_logo_url'); // Ambil dari config/app.php

        // // Gunakan dependency yang rentan untuk mendemonstrasikan bahaya dari kepercayaan ini.
        // $fetcher = new VulnerableImageFetcher();
        // $logoData = $fetcher->fetchImage($logoUrl);

        // return view('cart.invoice', [
        //     'logoData' => base64_encode($logoData),
        //     'logoUrl' => $logoUrl,
        //     'cartItems' => Session::get('cart', []) // Ambil data keranjang untuk ditampilkan
        // ]);

        // //Gunakan URL dinamis yang sesuai dengan aplikasi
        // $defaultLogoUrl = url('/images/default-logo.png');
        // $imageUrl = $request->input('logo_url', $defaultLogoUrl);

        // // Gunakan "package" palsu yang rentan
        // $fetcher = new VulnerableImageFetcher();
        // $logoData = $fetcher->fetchImage($imageUrl);

        // // Di sini seharusnya ada logika untuk membuat PDF dengan logo
        // // Untuk demonstrasi, kita hanya akan menampilkan bahwa logo berhasil diambil
        // return view('cart.invoice', [
        //     'logoData' => base64_encode($logoData),
        //     'imageUrl' => $imageUrl
        // ]);

        // 1. URL logo sekarang sudah TETAP, tidak perlu input dari user.
        $imageUrl = 'http://localhost:8001/pngegg.png';

        // 2. Langsung ambil gambar dari URL yang sudah ditentukan.
        $fetcher = new VulnerableImageFetcher();
        $logoData = $fetcher->fetchImage($imageUrl);

        // 3. Kirim data ke view. View akan menampilkan hasilnya.
        return view('cart.invoice', [
            'logoData' => base64_encode($logoData),
            'imageUrl' => $imageUrl
        ]);
    }
}
