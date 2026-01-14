<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //
    // Menampilkan daftar buku
    public function index()
    {
        // Fitur pencarian akan kita buat rentan nanti
        $books = Book::orderBy('title')->get();
        return view('books.index', compact('books'));
    }

    // Menampilkan detail satu buku
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }
}
