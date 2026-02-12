<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
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

    public function showRegister()
    {
        return view('frontend.nasabah.register', [
            'pageTitle' => 'Daftar Nasabah Baru',
        ]);
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telp' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'firstname.required' => 'Nama depan wajib diisi.',
            'lastname.required' => 'Nama belakang wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'telp.required' => 'Nomor telepon wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // Generate username dari email
        $username = explode('@', $request->email)[0] . rand(100, 999);

        // Buat user baru
        $user = User::create([
            'username' => $username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'telp' => $request->telp,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Auto verify untuk nasabah
        ]);

        // Assign role nasabah
        $user->assignRole('nasabah');

        // Auto login setelah register
        Auth::guard('nasabah')->login($user);

        return redirect()->route('nasabah.dashboard')
            ->with('success', 'Selamat datang! Akun Anda berhasil dibuat. Silakan lengkapi profil Anda untuk dapat mengajukan polis.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('nasabah')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('nasabah.login');
    }
}
