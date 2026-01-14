<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //
    // Menampilkan daftar buku
    public function index(Request $request)
    {

        // Ini adalah VERSI AMAN menggunakan Eloquent
        $search = $request->input('search');

        $books = Book::query();

        if ($search) {
            $books->where('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%');
        }

        $books = $books->orderBy('title')->get();

        return view('books.index', compact('books'));
    }

    // Menampilkan detail satu buku
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }
}
