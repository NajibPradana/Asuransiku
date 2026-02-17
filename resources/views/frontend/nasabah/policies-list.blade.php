@extends('frontend.layout-nasabah')

@section('nasabah-content')
@php
    $user = auth('nasabah')->user();
    $displayName = trim(($user->firstname ?? '') . ' ' . ($user->lastname ?? '')) ?: 'Nasabah';
@endphp

<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Polis Aktif</h1>
            <p class="mt-2 text-slate-600">Kelola dan lihat detail polis Anda</p>
        </div>
        <a href="{{ route('nasabah.dashboard') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Kembali ke Dashboard</a>
    </div>

    @if ($policies->count() > 0)
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($policies as $policy)
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Nomor Polis</p>
                            <h3 class="mt-1 text-lg font-semibold text-slate-900">{{ $policy->policy_number }}</h3>
                        </div>
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Aktif</span>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Produk</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->product->name ?? 'N/A' }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase text-slate-500">Mulai</p>
                                <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->start_date->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold uppercase text-slate-500">Berakhir</p>
                                <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->end_date->format('d M Y') }}</p>
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Premi Dibayar</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">Rp{{ number_format((float) $policy->premium_paid, 0, ',', '.') }}</p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Coverage</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">Rp{{ number_format((float) ($policy->product->coverage_amount ?? 0), 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button class="flex-1 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-700">Lihat Detail</button>
                        <a href="{{ route('nasabah.claims.create', ['policy_id' => $policy->id]) }}" class="flex-1 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold text-white text-center">Ajukan Klaim</a>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 lg:col-span-3">
                    <div class="rounded-3xl border border-slate-200 bg-white p-8 text-center">
                        <p class="text-slate-600">Belum ada polis aktif. <a href="{{ route('nasabah.policies.create') }}" class="font-semibold text-slate-900">Ajukan polis sekarang</a></p>
                    </div>
                </div>
            @endforelse
        </div>
    @else
        <div class="rounded-3xl border border-slate-200 bg-white p-8 text-center">
            <p class="text-slate-600">Belum ada polis aktif. <a href="{{ route('nasabah.policies.create') }}" class="font-semibold text-slate-900">Ajukan polis sekarang</a></p>
        </div>
    @endif
</div>

@endsection
