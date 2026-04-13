<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\File;

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

    /**
     * Tampilkan form update software.
     */
    public function showUpdateForm()
    {
        return view('admin.update');
    }

    /**
     * Lakukan update software (KERENTANAN ADA DI SINI).
     */
    public function performUpdate(Request $request)
    {
        $request->validate([
            'update_url' => 'required|url'
        ]);

        $updateUrl = $request->input('update_url');
        $destinationPath = public_path('updates/latest_version.js');
        $directoryPath = public_path('updates');

        // !!! VULNERABILITY: A08 - SOFTWARE INTEGRITY FAILURE !!!
        // Aplikasi mengunduh file dari URL yang diberikan user tanpa verifikasi sama sekali.
        // Tidak ada pengecekan tanda tangan digital, tidak ada whitelist domain.
        // Penyerang bisa mengarahkan ini ke server berbahaya.
        $fileContents = file_get_contents($updateUrl);

        if ($fileContents !== false) {
            // --- PERBAIKAN: Buat folder jika belum ada ---
            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true);
            }
            // ------------------------------------------------

            // Simpan file yang diunduh ke direktori publik
            File::put($destinationPath, $fileContents);
            return back()->with('success', 'Update berhasil diunduh ke /updates/latest_version.js');
        }

        return back()->with('error', 'Gagal mengunduh update.');

    }
}
