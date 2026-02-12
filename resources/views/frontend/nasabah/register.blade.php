@extends('frontend.layout-guest')

@section('content')
@php
    $brandTitle = 'Nusantara Insurance Management System';
    $brandSubtitle = 'Managing Protection with Precision';
@endphp

<style>
    .nasabah-register {
        background: radial-gradient(900px circle at 15% 20%, rgba(59, 130, 246, 0.18), transparent 55%),
            radial-gradient(800px circle at 90% 10%, rgba(250, 204, 21, 0.2), transparent 45%),
            linear-gradient(145deg, #f8fafc 0%, #eef2ff 45%, #fff7ed 100%);
    }

    .nasabah-register-card {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 30px 60px rgba(15, 23, 42, 0.12);
    }

    .nasabah-register-font {
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

<div class="nasabah-register nasabah-register-font min-h-screen flex items-center justify-center px-6 py-16">
    <div class="w-full max-w-5xl grid gap-10 lg:grid-cols-[1.1fr_0.9fr] items-center">
        <div class="text-slate-900">
            <span class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-200">
                🛡️ NIMS Portal
            </span>
            <h1 class="mt-6 text-4xl font-semibold leading-tight sm:text-5xl">
                {{ $brandTitle }}
            </h1>
            <p class="mt-3 text-lg text-slate-600 font-medium">
                {{ $brandSubtitle }}
            </p>
            <p class="mt-5 text-lg text-slate-600">
                Daftar sekarang untuk mulai mengakses layanan asuransi terbaik. Kelola polis, ajukan klaim, dan nikmati perlindungan yang Anda butuhkan.
            </p>
            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-slate-200 bg-white/80 p-4">
                    <p class="text-sm font-semibold text-slate-700">✨ Pendaftaran Mudah</p>
                    <p class="mt-2 text-sm text-slate-500">Proses cepat hanya dalam beberapa langkah sederhana.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white/80 p-4">
                    <p class="text-sm font-semibold text-slate-700">🔒 Data Aman</p>
                    <p class="mt-2 text-sm text-slate-500">Informasi Anda dilindungi dengan enkripsi tingkat tinggi.</p>
                </div>
            </div>
        </div>

        <div class="nasabah-register-card rounded-3xl p-8 sm:p-10">
            <h2 class="text-2xl font-semibold text-slate-900">Daftar Nasabah Baru</h2>
            <p class="mt-2 text-sm text-slate-500">Buat akun untuk mulai menggunakan layanan kami.</p>

            <form class="mt-8 space-y-4" method="POST" action="{{ route('nasabah.register.submit') }}">
                @csrf

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-sm font-semibold text-slate-700" for="firstname">Nama Depan</label>
                        <input id="firstname" name="firstname" type="text" value="{{ old('firstname') }}" required
                            class="nasabah-input mt-1 w-full rounded-2xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none" />
                        @error('firstname')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-slate-700" for="lastname">Nama Belakang</label>
                        <input id="lastname" name="lastname" type="text" value="{{ old('lastname') }}" required
                            class="nasabah-input mt-1 w-full rounded-2xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none" />
                        @error('lastname')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700" for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="nasabah-input mt-1 w-full rounded-2xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none" 
                        placeholder="contoh@email.com" />
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700" for="telp">Nomor Telepon</label>
                    <input id="telp" name="telp" type="tel" value="{{ old('telp') }}" required
                        class="nasabah-input mt-1 w-full rounded-2xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none" 
                        placeholder="08xxxxxxxxxx" />
                    @error('telp')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700" for="password">Password</label>
                    <input id="password" name="password" type="password" required
                        class="nasabah-input mt-1 w-full rounded-2xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none" 
                        placeholder="Minimal 8 karakter" />
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-slate-700" for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="nasabah-input mt-1 w-full rounded-2xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none" 
                        placeholder="Ketik ulang password" />
                </div>

                <button type="submit" class="w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 hover:bg-slate-800 transition">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-6 rounded-2xl border border-blue-200 bg-blue-50 px-4 py-3 text-xs text-blue-800">
                <strong>Sudah punya akun?</strong> 
                <a href="{{ route('nasabah.login') }}" class="font-semibold underline hover:text-blue-600">Login disini</a>
            </div>
        </div>
    </div>
</div>
@endsection
