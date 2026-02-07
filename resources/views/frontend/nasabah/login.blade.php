@extends('frontend.layout-guest')

@section('content')
@php
    $brandTitle = 'Portal Nasabah';
@endphp

<style>
    .nasabah-login {
        background: radial-gradient(900px circle at 15% 20%, rgba(59, 130, 246, 0.18), transparent 55%),
            radial-gradient(800px circle at 90% 10%, rgba(250, 204, 21, 0.2), transparent 45%),
            linear-gradient(145deg, #f8fafc 0%, #eef2ff 45%, #fff7ed 100%);
    }

    .nasabah-login-card {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 30px 60px rgba(15, 23, 42, 0.12);
    }

    .nasabah-login-font {
        font-family: "Space Grotesk", "Helvetica Neue", Helvetica, sans-serif;
    }

    .nasabah-input {
        border: 1px solid rgba(148, 163, 184, 0.5);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .nasabah-input:focus {
        border-color: #0f172a;
        box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.12);
    }
</style>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700&display=swap" rel="stylesheet" />

<div class="nasabah-login nasabah-login-font min-h-screen flex items-center justify-center px-6 py-16">
    <div class="w-full max-w-5xl grid gap-10 lg:grid-cols-[1.1fr_0.9fr] items-center">
        <div class="text-slate-900">
            <span class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-200">
                {{ $brandTitle }}
            </span>
            <h1 class="mt-6 text-4xl font-semibold leading-tight sm:text-5xl">
                Masuk untuk mengelola perlindungan Anda.
            </h1>
            <p class="mt-5 text-lg text-slate-600">
                Akses status polis, klaim, dan layanan prioritas dalam satu dashboard yang aman dan mudah digunakan.
            </p>
            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white/80 p-4">
                    <p class="text-sm font-semibold text-slate-700">Keamanan Terverifikasi</p>
                    <p class="mt-2 text-sm text-slate-500">Login hanya untuk nasabah terdaftar.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white/80 p-4">
                    <p class="text-sm font-semibold text-slate-700">Layanan 24/7</p>
                    <p class="mt-2 text-sm text-slate-500">Tim kami siap membantu kapan pun.</p>
                </div>
            </div>
        </div>

        <div class="nasabah-login-card rounded-3xl p-8 sm:p-10">
            <h2 class="text-2xl font-semibold text-slate-900">Login Nasabah</h2>
            <p class="mt-2 text-sm text-slate-500">Gunakan email terdaftar untuk melanjutkan.</p>

            <form class="mt-8 space-y-5" method="POST" action="{{ route('nasabah.login.submit') }}">
                @csrf

                <div>
                    <label class="text-sm font-semibold text-slate-700" for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="nasabah-input mt-2 w-full rounded-2xl px-4 py-3 text-sm text-slate-800 focus:outline-none" />
                    @error('email')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700" for="password">Password</label>
                    <input id="password" name="password" type="password" required
                        class="nasabah-input mt-2 w-full rounded-2xl px-4 py-3 text-sm text-slate-800 focus:outline-none" />
                    @error('password')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-xs text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-slate-900">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20">
                    Masuk
                </button>
            </form>

            <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-800">
                Belum punya akun? Hubungi admin untuk aktivasi akun nasabah.
            </div>
        </div>
    </div>
</div>
@endsection
