@extends('frontend.layout-nasabah')

@section('nasabah-content')

<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-slate-900">Profil Saya</h1>
        <p class="mt-2 text-slate-600">Kelola informasi akun Anda</p>
    </div>

    @php
        $profile = $profile ?? null;
    @endphp

    <div class="max-w-2xl mx-auto">
        @if(session('profile_incomplete'))
            <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                {{ session('profile_incomplete') }}
            </div>
        @endif
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-900 mb-6">Profil Nasabah</h2>

            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('nasabah.profile.update') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Nama Depan</label>
                        <input type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}" placeholder="Contoh: Budi" class="mt-1 block w-full rounded-lg border border-slate-200 px-4 py-2 text-slate-700" required>
                        @error('firstname')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Nama Belakang</label>
                        <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}" placeholder="Contoh: Santoso" class="mt-1 block w-full rounded-lg border border-slate-200 px-4 py-2 text-slate-700" required>
                        @error('lastname')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="nama@email.com" class="mt-1 block w-full rounded-lg border border-slate-200 px-4 py-2 text-slate-700" required>
                        @error('email')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" placeholder="contoh: nasabah01" class="mt-1 block w-full rounded-lg border border-slate-200 px-4 py-2 text-slate-700" required>
                        @error('username')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik', $profile?->nik) }}" placeholder="Contoh: 327xxxxxxxxxxxxx" class="mt-1 block w-full rounded-lg border border-slate-200 px-4 py-2 text-slate-700" required>
                    @error('nik')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tempat Lahir</label>
                        <input type="text" name="birth_place" value="{{ old('birth_place', $profile?->birth_place) }}" placeholder="Contoh: Bandung" class="mt-1 block w-full rounded-lg border border-slate-200 px-4 py-2 text-slate-700" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tanggal Lahir</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', optional($profile?->birth_date)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-lg border border-slate-200 px-4 py-2 text-slate-700" placeholder="Pilih tanggal" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Alamat</label>
                    <textarea name="address" rows="3" class="mt-1 block w-full rounded-lg border border-slate-200 px-4 py-2 text-slate-700" placeholder="Contoh: Jl. Sudirman No. 123, Jakarta" required>{{ old('address', $profile?->address) }}</textarea>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Pekerjaan</label>
                        <select name="occupation" class="mt-1 block w-full rounded-lg border border-slate-200 bg-white px-4 py-2 text-slate-700" required>
                            <option value="" disabled {{ old('occupation', $profile?->occupation) ? '' : 'selected' }}>Pilih pekerjaan</option>
                            @foreach(($occupationOptions ?? []) as $value => $label)
                                <option value="{{ $value }}" {{ old('occupation', $profile?->occupation) === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Gaji Per Bulan (Rp)</label>
                        <select name="monthly_income" class="mt-1 block w-full rounded-lg border border-slate-200 bg-white px-4 py-2 text-slate-700" required>
                            <option value="" disabled {{ old('monthly_income', $profile?->monthly_income) ? '' : 'selected' }}>Pilih range gaji</option>
                            @foreach(($incomeOptions ?? []) as $value => $label)
                                <option value="{{ $value }}" {{ old('monthly_income', $profile?->monthly_income) === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Aset (Rp)</label>
                    <select name="assets" class="mt-1 block w-full rounded-lg border border-slate-200 bg-white px-4 py-2 text-slate-700" required>
                        <option value="" disabled {{ old('assets', $profile?->assets) ? '' : 'selected' }}>Pilih range aset</option>
                        @foreach(($assetOptions ?? []) as $value => $label)
                            <option value="{{ $value }}" {{ old('assets', $profile?->assets) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Status Verifikasi Email</label>
                    <div class="mt-1 flex items-center gap-3">
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-2 text-sm font-semibold text-emerald-700">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Terverifikasi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                Belum Terverifikasi
                            </span>
                        @endif
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-200">
                    <button type="submit" class="rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white">Simpan Profil</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection
