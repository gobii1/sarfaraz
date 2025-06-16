<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Cart; // <-- TAMBAHKAN BARIS INI

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // TAMBAHKAN LOGIKA UNTUK MENGHITUNG CART
        $cartCount = 0;
        if (Auth::check()) {
            $cartCount = Cart::where('user_id', Auth::id())->count();
        }

        if ($user->role == 'admin') {
            return view('admin.profile.edit', [
                'user' => $user,
                // Anda mungkin tidak butuh cart count di admin, tapi jika iya, bisa ditambahkan
            ]);
        }
        
        return view('profile.edit', [
            'user' => $user,
            'cartCount' => $cartCount, // <-- KIRIM VARIABEL KE VIEW
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
