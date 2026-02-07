<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class NasabahAuthController extends Controller
{
    public function showLogin()
    {
        return view('frontend.nasabah.login', [
            'pageTitle' => 'Login Nasabah',
        ]);
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $throttleKey = strtolower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            throw ValidationException::withMessages([
                'email' => 'Terlalu banyak percobaan. Silakan coba lagi dalam beberapa menit.',
            ]);
        }

        if (! Auth::guard('nasabah')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey, 60);

            throw ValidationException::withMessages([
                'email' => 'Email atau password tidak valid.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        $request->session()->regenerate();

        $user = Auth::guard('nasabah')->user();
        if (! $user || ! $user->hasRole('nasabah')) {
            Auth::guard('nasabah')->logout();

            return back()->withErrors([
                'email' => 'Akun ini tidak memiliki akses nasabah.',
            ])->onlyInput('email');
        }

        return redirect()->intended(route('nasabah.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('nasabah')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('nasabah.login');
    }
}
