@extends('frontend.layout-nasabah')

@section('nasabah-content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <div>
                <h1 class="text-3xl font-semibold text-slate-900">Klaim Saya</h1>
                <p class="mt-2 text-slate-600">Pantau status klaim yang sudah diajukan.</p>
            </div>
            <a href="{{ route('nasabah.claims.create') }}" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800 transition">Ajukan Klaim</a>
        </div>

        <!-- Tabs -->
        <div class="border-b border-slate-200">
            <div class="flex gap-1">
                <button class="tab-btn px-4 py-3 font-semibold text-slate-900 border-b-2 border-slate-900 active-tab whitespace-nowrap transition" data-tab="active">
                    Klaim Aktif ({{ $activeClaims->count() }})
                </button>
                <button class="tab-btn px-4 py-3 font-medium text-slate-600 hover:text-slate-900 whitespace-nowrap transition" data-tab="rejected">
                    Ditolak ({{ $rejectedClaims->count() }})
                </button>
            </div>
        </div>
    </div>

    <!-- Active Claims Tab -->
    <div id="active-tab" class="tab-content">
        <div class="grid gap-4">
            @forelse($activeClaims as $claim)
                <a href="{{ route('nasabah.claims.show', $claim) }}" class="block rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md transition hover:border-slate-300 group">
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
                            {{ match($claim->status) {
                                'pending' => 'Menunggu Review',
                                'review' => 'Sedang Direview',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                                'paid' => 'Dibayar',
                                default => ucfirst($claim->status)
                            } }}
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

                    @if($claim->description)
                    <div class="mt-4">
                        <p class="text-xs font-semibold uppercase text-slate-500 mb-1">Deskripsi</p>
                        <p class="text-sm text-slate-700 line-clamp-2">{{ $claim->description }}</p>
                    </div>
                    @endif

                    @if($claim->status === 'paid')
                        <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3">
                            <p class="text-xs font-semibold uppercase text-emerald-700 mb-1">Tanggal Dibayar</p>
                            <p class="text-sm text-emerald-900">{{ optional($claim->paid_at)->format('d M Y H:i') ?? '-' }}</p>
                        </div>
                    @endif
                </a>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center text-sm text-slate-600">
                    Belum ada klaim. Klik tombol "Ajukan Klaim" untuk membuat klaim baru.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Rejected Claims Tab -->
    <div id="rejected-tab" class="tab-content hidden">
        <div class="grid gap-4">
            @forelse($rejectedClaims as $claim)
                <a href="{{ route('nasabah.claims.show', $claim) }}" class="block rounded-2xl border border-red-200 bg-red-50 p-5 hover:shadow-md transition hover:border-red-300 group">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ $claim->claim_number }}</p>
                            <p class="text-xs text-slate-500">{{ $claim->policy?->policy_number }} · {{ $claim->policy?->product?->name }}</p>
                        </div>
                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                            Ditolak
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

                    @if($claim->description)
                    <div class="mt-4">
                        <p class="text-xs font-semibold uppercase text-slate-500 mb-1">Deskripsi</p>
                        <p class="text-sm text-slate-700 line-clamp-2">{{ $claim->description }}</p>
                    </div>
                    @endif

                    @if($claim->rejection_reason)
                        <div class="mt-4 rounded-xl border border-red-300 bg-white px-4 py-3">
                            <p class="text-xs font-semibold uppercase text-red-700 mb-2">Alasan Penolakan</p>
                            <p class="text-sm text-red-900">{{ $claim->rejection_reason }}</p>
                        </div>
                    @endif
                </a>
            @empty
                <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center text-sm text-slate-600">
                    Tidak ada klaim yang ditolak.
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const tabName = this.dataset.tab;
                
                // Hide all tabs
                tabContents.forEach(content => content.classList.add('hidden'));
                
                // Show selected tab
                document.getElementById(tabName + '-tab').classList.remove('hidden');
                
                // Update button states
                tabBtns.forEach(b => {
                    b.classList.remove('border-b-2', 'border-slate-900', 'font-semibold', 'text-slate-900');
                    b.classList.add('font-medium', 'text-slate-600');
                });
                this.classList.add('border-b-2', 'border-slate-900', 'font-semibold', 'text-slate-900');
                this.classList.remove('font-medium', 'text-slate-600');
            });
        });
    });
</script>

@endsection
