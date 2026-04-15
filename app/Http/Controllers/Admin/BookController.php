<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class BookController extends Controller
{
    public function index()
    {
        $books = DB::select("SELECT * FROM books");
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function update(Request $request)
    {
        // SQL Injection (sengaja)
        DB::update("
        UPDATE books 
        SET price = '$request->price', stock = '$request->stock'
        WHERE id = '$request->id'
    ");

        return back();
    }

    public function delete($id)
    {
        // IDOR
        DB::delete("DELETE FROM books WHERE id = $id");

        return back();
    }

    public function store(Request $request)
    {
        // SENGAJA RENTAN (SQL Injection)
        DB::insert("
    INSERT INTO books (title, author, description, price, stock)
    VALUES ('$request->title', '$request->author', '$request->description', '$request->price', '$request->stock')
");

        return redirect()->route('admin.books.index');
    }
}
