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
        if ($search) {
            // SANGAT BERBAHAYA! JANGAN LAKUKAN INI DI PRODUKSI!
            $query = "SELECT * FROM books WHERE title LIKE '%" . $search . "%' OR author LIKE '%" . $search . "%'";
            $books = DB::select($query);
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
}
