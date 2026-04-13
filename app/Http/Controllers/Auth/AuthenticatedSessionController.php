<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log; // <-- TAMBAHKAN INI
use Illuminate\Validation\ValidationException; // <-- TAMBAHKAN INI

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // $request->authenticate();

        // Gunakan try...catch untuk menangani login gagal
        try {
            $request->authenticate();
        } catch (ValidationException $e) {
            // !!! LOGGING UNTUK LOGIN GAGAL !!!
            Log::warning('Login Failed', [
                'email' => $request->email,
                'ip_address' => $request->ip(),
            ]);

            // Lempar kembali exception agar pesan error tetap muncul
            throw $e;
        }

        // Jika kode di bawah ini dijalankan, berarti login berhasil
        // !!! LOGGING UNTUK LOGIN BERHASIL !!!
        Log::info('User Logged In Successfully', [
            'user_id' => Auth::user()->id,
            'user_email' => Auth::user()->email,
            'ip_address' => $request->ip(),
        ]);

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // !!! LOGGING UNTUK LOGOUT (Opsional, tapi bagus untuk audit) !!!
        Log::info('User Logged Out', [
            'user_id' => Auth::user()->id,
            'user_email' => Auth::user()->email,
            'ip_address' => $request->ip(),
        ]);
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
