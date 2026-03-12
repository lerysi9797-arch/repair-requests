<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        if ($email && $password) {
            $credentials = ['email' => $email, 'password' => $password];

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                $user = Auth::user();
                if ($user->role === 'dispatcher') {
                    return redirect()->intended(route('dispatcher.dashboard'));
                }
                return redirect()->intended(route('master.dashboard'));
            }
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role === 'dispatcher') {
            return redirect()->intended(route('dispatcher.dashboard'));
        }

        return redirect()->intended(route('master.dashboard'));    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
