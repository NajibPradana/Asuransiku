@extends('frontend.layout-nasabah')

@section('nasabah-content')

<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-slate-900">Profil Saya</h1>
        <p class="mt-2 text-slate-600">Kelola informasi akun Anda</p>
    </div>

    @php
        $user = auth('nasabah')->user();
    @endphp

    <div class="max-w-2xl mx-auto">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-900 mb-6">Informasi Pribadi</h2>

            <form method="POST" action="#" class="space-y-6">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Nama Depan</label>
                        <input type="text" value="{{ $user->firstname }}" disabled class="mt-1 block w-full px-4 py-2 rounded-lg border border-slate-200 bg-slate-50 text-slate-700">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Nama Belakang</label>
                        <input type="text" value="{{ $user->lastname }}" disabled class="mt-1 block w-full px-4 py-2 rounded-lg border border-slate-200 bg-slate-50 text-slate-700">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" value="{{ $user->email }}" disabled class="mt-1 block w-full px-4 py-2 rounded-lg border border-slate-200 bg-slate-50 text-slate-700">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Username</label>
                    <input type="text" value="{{ $user->username }}" disabled class="mt-1 block w-full px-4 py-2 rounded-lg border border-slate-200 bg-slate-50 text-slate-700">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Status Verifikasi Email</label>
                    <div class="mt-1 flex items-center gap-3">
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Terverifikasi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                Belum Terverifikasi
                            </span>
                        @endif
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-200">
                    <button type="button" disabled class="rounded-full bg-slate-300 px-6 py-3 text-sm font-semibold text-slate-500 cursor-not-allowed">Edit Profil (Fitur Segera Hadir)</button>
                </div>
            </form>
        </div>

        <div class="mt-8 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-900 mb-6">Keamanan</h2>

            <div class="space-y-4">
                <button class="w-full rounded-full border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition text-left">
                    🔐 Ubah Password
                </button>
                <button class="w-full rounded-full border border-slate-200 px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition text-left">
                    🧾 Lihat Riwayat Login
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
