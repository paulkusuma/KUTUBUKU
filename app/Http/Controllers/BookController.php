<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    //
    // Menampilkan daftar buku
    public function index(Request $request)
    {
        // !!! VULNERABILITY: SQL INJECTION !!!
        // Kode ini RENTAN karena menggabungkan input user langsung ke query.
        $search = $request->input('search');

        // Mulai dengan koleksi kosong
        $books = collect();

        // Hanya jalankan query jika ada input pencarian
        // if ($search) {
        //     // SANGAT BERBAHAYA! JANGAN LAKUKAN INI DI PRODUKSI!
        //     $query = "SELECT * FROM books WHERE title LIKE '%" . $search . "%' OR author LIKE '%" . $search . "%'";
        //     $books = DB::select($query);
        // }


        if ($search) {
            $books = DB::select("SELECT * FROM books WHERE title LIKE '%$search%'");
        } else {
            $books = DB::select("SELECT * FROM books");
        }
        // Jika tidak ada $search, $books akan tetap kosong.
        // Template Blade akan menangani pesan "Belum ada buku tersedia".

        return view('books.index', compact('books'));
        // !!! VULNERABILITY: SQL INJECTION !!!
        // // Kode ini RENTAN karena menggabungkan input user langsung ke query.
        // $search = $request->input('search');

        // if ($search) {
        //     // SANGAT BERBAHAYA! JANGAN LAKUKAN INI DI PRODUKSI!
        //     $query = "SELECT * FROM books WHERE title LIKE '%" . $search . "%' OR author LIKE '%" . $search . "%'";
        //     $books = DB::select($query);
        // } else {
        //     $books = Book::orderBy('title')->get();
        // }

        // return view('books.index', compact('books'));
    }

    // Menampilkan detail satu buku
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function requestForm()
    {
        return view('books.request');
    }

    public function requestStore(Request $request)
    {
        $title = $request->title;
        $author = $request->author;
        $url = $request->cover_url;

        // validasi minimal (biar terlihat "aman")
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return back()->with('error', 'URL tidak valid');
        }

        // 💣 SSRF INTI
        $image = file_get_contents($url);

        // simpan sementara (optional)
        $path = storage_path('app/public/preview.jpg');
        file_put_contents($path, $image);

        return back()->with('success', 'Cover berhasil diambil dari URL');
    }
}
