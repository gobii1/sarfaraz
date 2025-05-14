<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
        // Authenticate the user
        $request->authenticate();

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        // Redirect based on the user's role
        return $this->redirectTo();
    }

    /**
     * Redirect users based on their role
     */
    protected function redirectTo(): RedirectResponse
    {
        // Check the role of the authenticated user
        if (auth()->user()->role == 'admin') {
            return redirect()->route('admin.dashboard');  // Redirect to admin dashboard
        }

        if (auth()->user()->role == 'operator') {
            return redirect()->route('operator.dashboard');  // Redirect to operator dashboard
        }

        if (auth()->user()->role == 'owner') {
            return redirect()->route('owner.dashboard');  // Redirect to owner dashboard
        }

        // Default redirection for clients
        return redirect()->route('client.dashboard');  // Redirect to client dashboard
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Logout the user
        Auth::guard('web')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to home page after logout
        return redirect('/');
    }
}
