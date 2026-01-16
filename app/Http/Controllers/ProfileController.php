<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): View
    // {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }

    public function edit(Request $request, $id): View
    {
        // !!! VULNERABILITY: IDOR !!!
        // Kode ini RENTAN karena langsung mempercayai ID dari URL
        // tanpa memeriksa apakah user yang login boleh mengakses data ini.
        $user = User::findOrFail($id);

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Tambahkan baris ini untuk debugging
        // dd($request->all(), $request->method());
        $user = $request->user();

        // Validasi data umum (nama, email)
        $validated = $request->validated();
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit', $user->id)->with('status', 'profile-updated');
    }

    /**
     * Update the user's payment information.
     */
    public function updatePayment(Request $request): RedirectResponse
    {
        // Validasi khusus untuk data pembayaran
        $request->validate([
            'card_holder_name' => 'required|string|max:255',
            'card_number' => 'required|string|max:19',
            'card_expiry' => 'required|string|max:5',
            'card_cvv' => 'required|string|max:4',
        ]);

        $user = $request->user();

        // !!! VULNERABILITY: CRYPTOGRAPHIC FAILURE !!!
        // Menyimpan data kartu kredit dari input user tanpa enkripsi.
        $user->card_number = $request->input('card_number');
        $user->card_expiry = $request->input('card_expiry');
        $user->card_cvv = $request->input('card_cvv');
        $user->card_holder_name = $request->input('card_holder_name');

        $user->save();

        return Redirect::route('profile.edit', $user->id)->with('status', 'payment-updated');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
