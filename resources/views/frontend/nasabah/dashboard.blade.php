@extends('frontend.layout-guest')

@section('content')
@php
    $user = auth('nasabah')->user();
    $displayName = trim(($user->firstname ?? '') . ' ' . ($user->lastname ?? '')) ?: 'Nasabah';
@endphp

<style>
    .nasabah-hero {
        background: radial-gradient(1200px circle at 10% 10%, rgba(250, 204, 21, 0.25), transparent 40%),
            radial-gradient(900px circle at 90% 20%, rgba(59, 130, 246, 0.25), transparent 45%),
            linear-gradient(140deg, #f9fafb 0%, #eef2ff 40%, #fef9c3 100%);
    }

    .nasabah-card {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.78);
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
    }

    .nasabah-sheen {
        background: linear-gradient(120deg, rgba(255, 255, 255, 0.0), rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.0));
        animation: sheen 6s linear infinite;
    }

    .nasabah-float {
        animation: float 8s ease-in-out infinite;
    }

    .nasabah-reveal {
        animation: reveal 0.9s ease-out both;
    }

    .nasabah-reveal.delay-1 { animation-delay: 0.15s; }
    .nasabah-reveal.delay-2 { animation-delay: 0.3s; }
    .nasabah-reveal.delay-3 { animation-delay: 0.45s; }

    @keyframes sheen {
        0% { transform: translateX(-120%); }
        100% { transform: translateX(120%); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    @keyframes reveal {
        from { opacity: 0; transform: translateY(18px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .nasabah-font {
        font-family: "Space Grotesk", "Helvetica Neue", Helvetica, sans-serif;
    }
</style>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700&display=swap" rel="stylesheet" />

<div class="nasabah-hero nasabah-font min-h-screen text-slate-900">
    <div class="relative overflow-hidden">
        <div class="absolute -top-20 -right-10 h-64 w-64 rounded-full bg-amber-300/30 blur-3xl nasabah-float"></div>
        <div class="absolute top-24 -left-16 h-72 w-72 rounded-full bg-blue-400/20 blur-3xl nasabah-float" style="animation-delay: 2s;"></div>

        <div class="container mx-auto px-6 py-12 lg:py-16">
            <div class="flex items-center justify-between">
                <div class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Area Nasabah</div>
                <form method="POST" action="{{ route('nasabah.logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full border border-slate-200 bg-white/80 px-4 py-2 text-xs font-semibold text-slate-700">
                        Logout
                    </button>
                </form>
            </div>
            <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="nasabah-reveal">
                    <div class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-200">
                        Portal Nasabah
                    </div>
                    <h1 class="mt-6 text-4xl font-semibold leading-tight text-slate-900 sm:text-5xl">
                        Halo, {{ $displayName }}.
                        <span class="block text-slate-600">Pantau polis dan klaim dengan mudah.</span>
                    </h1>
                    <p class="mt-5 max-w-xl text-lg text-slate-600">
                        Semua kebutuhan perlindungan Anda terkonsolidasi dalam satu halaman. Cek status klaim, unduh dokumen, dan akses layanan prioritas kapan pun Anda perlu.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="#" class="rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20">Ajukan Klaim</a>
                        <a href="#" class="rounded-full border border-slate-900/10 bg-white px-6 py-3 text-sm font-semibold text-slate-900">Unduh Kartu Polis</a>
                    </div>

                    <div class="mt-10 grid gap-4 sm:grid-cols-2">
                        <div class="nasabah-card relative overflow-hidden rounded-2xl p-5">
                            <div class="absolute inset-0 nasabah-sheen opacity-60"></div>
                            <p class="text-sm font-semibold uppercase text-slate-500">Polis Aktif</p>
                            <p class="mt-3 text-3xl font-semibold">3</p>
                            <p class="mt-2 text-sm text-slate-500">Perpanjangan berikutnya: 12 Mar 2026</p>
                        </div>
                        <div class="nasabah-card relative overflow-hidden rounded-2xl p-5">
                            <div class="absolute inset-0 nasabah-sheen opacity-60"></div>
                            <p class="text-sm font-semibold uppercase text-slate-500">Klaim Berjalan</p>
                            <p class="mt-3 text-3xl font-semibold">1</p>
                            <p class="mt-2 text-sm text-slate-500">Rata-rata SLA: 3 hari kerja</p>
                        </div>
                    </div>
                </div>

                <div class="nasabah-reveal delay-2">
                    <div class="nasabah-card rounded-3xl p-6 sm:p-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold uppercase text-slate-500">Status Klaim</p>
                                <h2 class="mt-2 text-2xl font-semibold">Klaim Perjalanan</h2>
                            </div>
                            <span class="rounded-full bg-amber-100 px-4 py-2 text-xs font-semibold text-amber-700">Dalam Review</span>
                        </div>
                        <div class="mt-6">
                            <div class="h-2 w-full rounded-full bg-slate-200">
                                <div class="h-2 rounded-full bg-amber-400" style="width: 68%;"></div>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-xs text-slate-500">
                                <span>Diajukan</span>
                                <span>Verifikasi</span>
                                <span>Pembayaran</span>
                            </div>
                        </div>
                        <div class="mt-6 grid gap-3">
                            <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Dokumen Lengkap</p>
                                    <p class="text-xs text-slate-500">Diterima 05 Feb 2026</p>
                                </div>
                                <span class="text-xs font-semibold text-emerald-600">OK</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Verifikasi Klaim</p>
                                    <p class="text-xs text-slate-500">Estimasi selesai 2 hari</p>
                                </div>
                                <span class="text-xs font-semibold text-amber-600">Proses</span>
                            </div>
                        </div>
                        <button class="mt-6 w-full rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Lacak Klaim</button>
                    </div>
                </div>
            </div>

            <div class="mt-12">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Produk Tersedia</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-900">Pilih perlindungan sesuai kebutuhan</h2>
                    </div>
                    <span class="hidden rounded-full bg-white/80 px-4 py-2 text-xs font-semibold text-slate-700 sm:inline-flex">
                        {{ $products->count() }} Produk Aktif
                    </span>
                </div>

                <div class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @forelse($products as $product)
                        <div class="nasabah-card rounded-3xl p-6">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">{{ $product->name }}</h3>
                                    <p class="mt-2 text-sm text-slate-500 line-clamp-3">
                                        {{ $product->description ?? 'Produk ini memberikan perlindungan menyeluruh untuk kebutuhan Anda.' }}
                                    </p>
                                </div>
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Aktif</span>
                            </div>
                            <div class="mt-6 grid gap-3">
                                <div class="flex items-center justify-between text-sm text-slate-600">
                                    <span>Premi Dasar</span>
                                    <span class="font-semibold text-slate-900">Rp{{ number_format((float) $product->base_premium, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm text-slate-600">
                                    <span>Coverage</span>
                                    <span class="font-semibold text-slate-900">Rp{{ number_format((float) $product->coverage_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-between">
                                <a href="#" class="rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-700">Lihat Detail</a>
                                <button class="rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold text-white">Ajukan</button>
                            </div>
                        </div>
                    @empty
                        <div class="nasabah-card rounded-3xl p-6 md:col-span-2 xl:col-span-3">
                            <p class="text-sm text-slate-600">Belum ada produk aktif yang bisa ditampilkan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                <div class="nasabah-card nasabah-reveal delay-1 rounded-3xl p-6">
                    <p class="text-sm font-semibold uppercase text-slate-500">Perlindungan Anda</p>
                    <h3 class="mt-3 text-xl font-semibold">Asuransi Kesehatan Premium</h3>
                    <p class="mt-2 text-sm text-slate-500">Limit tahunan hingga Rp150.000.000</p>
                    <div class="mt-6 flex items-center justify-between">
                        <span class="text-sm font-semibold text-emerald-600">Aktif</span>
                        <button class="rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-700">Detail</button>
                    </div>
                </div>
                <div class="nasabah-card nasabah-reveal delay-2 rounded-3xl p-6">
                    <p class="text-sm font-semibold uppercase text-slate-500">Pembayaran</p>
                    <h3 class="mt-3 text-xl font-semibold">Tagihan Berikutnya</h3>
                    <p class="mt-2 text-sm text-slate-500">Rp450.000 pada 12 Mar 2026</p>
                    <div class="mt-6 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">Autodebit aktif</span>
                        <button class="rounded-full bg-amber-100 px-4 py-2 text-xs font-semibold text-amber-700">Ubah</button>
                    </div>
                </div>
                <div class="nasabah-card nasabah-reveal delay-3 rounded-3xl p-6">
                    <p class="text-sm font-semibold uppercase text-slate-500">Layanan Prioritas</p>
                    <h3 class="mt-3 text-xl font-semibold">Butuh bantuan cepat?</h3>
                    <p class="mt-2 text-sm text-slate-500">Tim kami siap membantu 24/7 untuk klaim darurat.</p>
                    <div class="mt-6 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">+62 21 555 0123</span>
                        <button class="rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold text-white">Hubungi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
