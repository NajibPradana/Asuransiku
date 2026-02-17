@extends('frontend.layout-nasabah')

@section('nasabah-content')
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
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
        transition: all 0.3s ease;
    }
    
    .nasabah-card:hover {
        box-shadow: 0 25px 50px rgba(15, 23, 42, 0.12);
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
            <!-- Header -->
            <div class="mb-8">
                <span class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-200">
                    🛡️ NIMS Portal Nasabah
                </span>
            </div>
            
            <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr]">
                <div class="nasabah-reveal">
                    <h1 class="text-4xl font-semibold leading-tight text-slate-900 sm:text-5xl">
                        Selamat Datang, {{ $displayName }}
                    </h1>
                    <p class="mt-4 text-lg text-slate-600 italic">
                        "Managing Protection with Precision"
                    </p>
                    <p class="mt-5 max-w-xl text-lg text-slate-600">
                        Kelola polis Anda, monitoring status klaim real-time, dan akses layanan prioritas NIMS dengan mudah dan aman.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('nasabah.claims.create') }}" class="inline-flex items-center rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 hover:bg-slate-800 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Ajukan Klaim Baru
                        </a>
                        <a href="{{ route('nasabah.policies') }}" class="inline-flex items-center rounded-full border-2 border-slate-900/20 bg-white px-6 py-3 text-sm font-semibold text-slate-900 hover:bg-slate-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            Lihat Semua Polis
                        </a>
                    </div>

                    <div class="mt-10 grid gap-4 sm:grid-cols-2">
                        <a href="{{ route('nasabah.policies') }}" class="nasabah-card relative overflow-hidden rounded-2xl p-5 transition hover:shadow-lg">
                            <div class="absolute inset-0 nasabah-sheen opacity-60"></div>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-emerald-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold uppercase text-slate-500">Polis Aktif</p>
                            </div>
                            <p class="text-3xl font-semibold">{{ $activePoliciesCount }}</p>
                            @if($nextRenewalDate)
                                <p class="mt-2 text-sm text-slate-500">Perpanjangan: {{ $nextRenewalDate->format('d M Y') }}</p>
                            @else
                                <p class="mt-2 text-sm text-slate-500">Belum ada polis aktif</p>
                            @endif
                        </a>
                        <a href="{{ route('nasabah.policies') }}" class="nasabah-card relative overflow-hidden rounded-2xl p-5 transition hover:shadow-lg">
                            <div class="absolute inset-0 nasabah-sheen opacity-60"></div>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-amber-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold uppercase text-slate-500">Menunggu Persetujuan</p>
                            </div>
                            <p class="text-3xl font-semibold">{{ $pendingPoliciesCount }}</p>
                            <p class="mt-2 text-sm text-slate-500">Sedang dalam review manager</p>
                        </a>
                    </div>
                </div>

                <div class="nasabah-reveal delay-2">
                    @if($latestClaim)
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-700',
                                'review' => 'bg-blue-100 text-blue-700',
                                'approved' => 'bg-emerald-100 text-emerald-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                'paid' => 'bg-emerald-100 text-emerald-700',
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'review' => 'Dalam Review',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                'paid' => 'Dibayar',
                            ];
                            $progressWidths = [
                                'pending' => '20%',
                                'review' => '50%',
                                'approved' => '80%',
                                'rejected' => '100%',
                                'paid' => '100%',
                            ];
                            $statusColor = $statusColors[$latestClaim->status] ?? 'bg-slate-100 text-slate-700';
                            $statusLabel = $statusLabels[$latestClaim->status] ?? ucfirst($latestClaim->status);
                            $progressWidth = $progressWidths[$latestClaim->status] ?? '10%';
                        @endphp
                        <div class="nasabah-card rounded-3xl p-6 sm:p-8">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold uppercase text-slate-500">Status Klaim</p>
                                    <h2 class="mt-2 text-2xl font-semibold">{{ $latestClaim->policy->product->name ?? 'Klaim Asuransi' }}</h2>
                                </div>
                                <span class="rounded-full px-4 py-2 text-xs font-semibold {{ $statusColor }}">{{ $statusLabel }}</span>
                            </div>
                            <div class="mt-4 text-sm text-slate-600">
                                <p><span class="font-medium">No. Klaim:</span> {{ $latestClaim->claim_number }}</p>
                            </div>
                            <div class="mt-6">
                                <div class="h-2 w-full rounded-full bg-slate-200">
                                    <div class="h-2 rounded-full bg-slate-900 transition-all duration-500" style="width: {{ $progressWidth }};"></div>
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
                                        <p class="text-sm font-semibold text-slate-800">Tanggal Kejadian</p>
                                        <p class="text-xs text-slate-500">{{ optional($latestClaim->incident_date)->format('d M Y') ?? '-' }}</p>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-600">{{ $latestClaim->incident_date ? \Carbon\Carbon::parse($latestClaim->incident_date)->diffForHumans() : '-' }}</span>
                                </div>
                                <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">Nominal Klaim</p>
                                        <p class="text-xs text-slate-500">Rp{{ number_format((float) $latestClaim->amount_claimed, 0, ',', '.') }}</p>
                                    </div>
                                    <span class="text-xs font-semibold text-slate-600">{{ $statusLabel }}</span>
                                </div>
                            </div>
                            <a href="{{ route('nasabah.claims') }}" class="mt-6 block w-full rounded-2xl bg-slate-900 px-4 py-3 text-center text-sm font-semibold text-white hover:bg-slate-800 transition">Lacak Klaim</a>
                        </div>
                    @else
                        <div class="nasabah-card rounded-3xl p-6 sm:p-8">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-semibold uppercase text-slate-500">Status Klaim</p>
                                    <h2 class="mt-2 text-2xl font-semibold">Belum Ada Klaim</h2>
                                </div>
                                <span class="rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-500">-</span>
                            </div>
                            <div class="mt-6 text-center text-slate-500">
                                <p class="text-sm">Anda belum mengajukan klaim apapun.</p>
                                <p class="text-xs mt-1">Ajukan klaim untuk polis yang aktif.</p>
                            </div>
                            <a href="{{ route('nasabah.claims.create') }}" class="mt-6 block w-full rounded-2xl bg-slate-900 px-4 py-3 text-center text-sm font-semibold text-white hover:bg-slate-800 transition">Ajukan Klaim</a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-12">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-slate-500">Polis Aktif Anda</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-900">Kelola perlindungan yang sedang berjalan</h2>
                    </div>
                    <span class="hidden rounded-full bg-white/80 px-4 py-2 text-xs font-semibold text-slate-700 sm:inline-flex">
                        {{ $activePoliciesCount }} Polis Aktif
                    </span>
                </div>

                <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($activePolicies as $policy)
                        <div class="nasabah-card rounded-3xl p-6 transition hover:shadow-md hover:-translate-y-1">
                            <div class="flex items-start justify-between mb-1">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="text-base font-semibold text-slate-900">{{ $policy->product->name }}</h3>
                                    </div>
                                    <div class="mt-2 flex items-center gap-2">
                                        <span class="inline-block rounded-full bg-blue-100/70 px-2.5 py-1 text-xs font-semibold text-blue-700 border border-blue-200">{{ ucfirst($policy->product->category) }}</span>
                                        <p class="text-xs font-medium text-slate-500">{{ $policy->policy_number }}</p>
                                    </div>
                                </div>
                                <span class="rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-semibold text-emerald-700 whitespace-nowrap ml-2">Aktif</span>
                            </div>
                            <hr class="my-4 border-slate-100" />
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Periode</span>
                                    <span class="text-sm font-semibold text-slate-900">{{ $policy->start_date->format('d M Y') }} - {{ $policy->end_date->format('d M Y') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Premi</span>
                                    <span class="text-sm font-semibold text-slate-900">Rp{{ number_format((float) $policy->premium_paid, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Coverage</span>
                                    <span class="text-sm font-semibold text-slate-900">Rp{{ number_format((float) ($policy->product->coverage_amount ?? 0), 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="mt-6 flex gap-2">
                                <a href="{{ route('nasabah.policies') }}" class="flex-1 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-700 text-center hover:bg-slate-50 transition">Detail</a>
                                <a href="{{ route('nasabah.claims.create', ['policy_id' => $policy->id]) }}" class="flex-1 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold text-white text-center hover:bg-slate-800 transition">Ajukan Klaim</a>
                            </div>
                        </div>
                    @empty
                        <div class="nasabah-card rounded-3xl p-8 md:col-span-2 lg:col-span-3 text-center">
                            <p class="text-sm text-slate-600">Belum ada polis aktif. <a href="{{ route('nasabah.policies.create') }}" class="font-semibold text-slate-900 hover:underline">Ajukan polis sekarang</a></p>
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
