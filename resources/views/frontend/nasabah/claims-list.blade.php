@extends('frontend.layout-nasabah')

@section('nasabah-content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Klaim Saya</h1>
            <p class="text-sm text-slate-600">Pantau status klaim yang sudah diajukan.</p>
        </div>
        <a href="{{ route('nasabah.claims.create') }}" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white">Ajukan Klaim</a>
    </div>

    <div class="grid gap-4">
        @forelse($claims as $claim)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">{{ $claim->claim_number }}</p>
                        <p class="text-xs text-slate-500">{{ $claim->policy?->policy_number }} · {{ $claim->policy?->product?->name }}</p>
                    </div>
                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                        @if($claim->status === 'approved') bg-emerald-100 text-emerald-700
                        @elseif($claim->status === 'paid') bg-blue-100 text-blue-700
                        @elseif($claim->status === 'rejected') bg-red-100 text-red-700
                        @elseif($claim->status === 'review') bg-yellow-100 text-yellow-700
                        @else bg-amber-100 text-amber-700 @endif">
                        {{ ucfirst($claim->status) }}
                    </span>
                </div>
                <div class="mt-4 grid gap-3 md:grid-cols-3 text-sm text-slate-600">
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Tanggal Kejadian</p>
                        <p class="text-slate-900">{{ optional($claim->incident_date)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Nominal Klaim</p>
                        <p class="text-slate-900">Rp{{ number_format((float) $claim->amount_claimed, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Nominal Disetujui</p>
                        <p class="text-slate-900">{{ $claim->amount_approved ? 'Rp' . number_format((float) $claim->amount_approved, 0, ',', '.') : '-' }}</p>
                    </div>
                </div>
                @if($claim->status === 'paid')
                    <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                        <p class="text-xs font-semibold uppercase text-emerald-700 mb-1">Tanggal Dibayar</p>
                        <p class="text-sm text-emerald-900">{{ optional($claim->paid_at)->format('d M Y H:i') ?? '-' }}</p>
                    </div>
                @endif
                @if($claim->status === 'rejected' && $claim->rejection_reason)
                    <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ $claim->rejection_reason }}
                    </div>
                @endif
            </div>
        @empty
            <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center text-sm text-slate-600">
                Belum ada klaim. Klik tombol "Ajukan Klaim" untuk membuat klaim baru.
            </div>
        @endforelse
    </div>
</div>
@endsection
