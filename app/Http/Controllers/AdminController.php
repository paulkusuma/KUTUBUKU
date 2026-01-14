<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;

class AdminController extends Controller
{
    //
    public function dashboard()
    {
        // !!! VULNERABILITY: VERTICAL PRIVILEGE ESCALATION !!!
        // Tidak ada pengecekan apakah user yang login adalah 'admin'.
        // Semua user yang sudah login bisa mengakses fungsi ini.
        $allUsers = User::all();
        $allBooks = Book::all();

        return view('admin.dashboard', compact('allUsers', 'allBooks'));
    }
}
