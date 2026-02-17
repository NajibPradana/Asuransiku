@extends('frontend.layout-nasabah')

@section('nasabah-content')
<div class="container mx-auto px-6 py-12">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('nasabah.policies') }}" class="mb-4 inline-flex items-center text-sm font-medium text-slate-600 hover:text-slate-900">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Polis Saya
            </a>
            <h1 class="text-3xl font-semibold text-slate-900">{{ $policy->product->name }}</h1>
            <p class="mt-2 text-slate-600">Detail Polis Lengkap</p>
        </div>
        <span class="rounded-full px-4 py-2 text-sm font-semibold
            @if($policy->status === 'active') bg-emerald-100 text-emerald-700
            @elseif($policy->status === 'pending') bg-amber-100 text-amber-700
            @elseif($policy->status === 'expired') bg-gray-100 text-gray-700
            @elseif($policy->status === 'cancelled') bg-red-100 text-red-700
            @endif">
            {{ match($policy->status) {
                'active' => 'Aktif',
                'pending' => 'Menunggu Persetujuan',
                'expired' => 'Expired',
                'cancelled' => 'Ditolak',
                default => ucfirst($policy->status)
            } }}
        </span>
    </div>

    <!-- Main Content Grid -->
    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Detail Section -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Polis -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Informasi Polis</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Nomor Polis</p>
                        <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->policy_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Status</p>
                        <p class="mt-1 text-sm font-medium text-slate-900">
                            {{ match($policy->status) {
                                'active' => 'Aktif',
                                'pending' => 'Menunggu Persetujuan',
                                'expired' => 'Expired',
                                'cancelled' => 'Ditolak',
                                default => ucfirst($policy->status)
                            } }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Tanggal Dimulai</p>
                        <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->start_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Tanggal Berakhir</p>
                        <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->end_date->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Premi Dibayar</p>
                        <p class="mt-1 text-sm font-medium text-slate-900">Rp{{ number_format((float) $policy->premium_paid, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Durasi Polis</p>
                        <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->start_date->diffInMonths($policy->end_date) }} Bulan</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Produk -->
            <div class="rounded-2xl border border-slate-200 bg-white p-6">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Informasi Produk</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Nama Produk</p>
                        <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->product->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Kategori</p>
                        <span class="mt-1 inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                            {{ ucfirst($policy->product->category) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Jangkauan Pertanggungan</p>
                        <p class="mt-1 text-sm font-medium text-slate-900">Rp{{ number_format((float) $policy->product->coverage_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Deskripsi</p>
                        <p class="mt-1 text-sm text-slate-700">{{ $policy->product->description ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Approval Information -->
            @if($policy->status !== 'pending')
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Informasi Persetujuan</h2>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Disetujui Oleh</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->approvedBy?->fullname ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Tanggal Persetujuan</p>
                            <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->approved_at?->format('d M Y H:i') ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($policy->status === 'cancelled' && $policy->rejection_note)
                <div class="rounded-2xl border border-red-200 bg-red-50 p-6">
                    <h2 class="text-lg font-semibold text-red-900 mb-4">Alasan Penolakan</h2>
                    <p class="text-sm text-red-800">{{ $policy->rejection_note }}</p>
                </div>
            @endif

            <!-- Claims Section -->
            @if($policy->claims && $policy->claims->count() > 0)
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Klaim Terkait</h2>
                    <div class="space-y-3">
                        @foreach($policy->claims as $claim)
                            <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">{{ $claim->claim_number }}</p>
                                        <p class="text-xs text-slate-500">{{ $claim->incident_date->format('d M Y') }}</p>
                                    </div>
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                        @if($claim->status === 'approved') bg-emerald-100 text-emerald-700
                                        @elseif($claim->status === 'paid') bg-blue-100 text-blue-700
                                        @elseif($claim->status === 'rejected') bg-red-100 text-red-700
                                        @elseif($claim->status === 'review') bg-yellow-100 text-yellow-700
                                        @else bg-amber-100 text-amber-700 @endif">
                                        {{ match($claim->status) {
                                            'pending' => 'Menunggu',
                                            'review' => 'Review',
                                            'approved' => 'Disetujui',
                                            'rejected' => 'Ditolak',
                                            'paid' => 'Dibayar',
                                            default => ucfirst($claim->status)
                                        } }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-600">{{ Str::limit($claim->description, 100, '...') }}</p>
                                <div class="mt-3 grid grid-cols-2 gap-2 text-xs">
                                    <div>
                                        <p class="text-slate-500">Nominal Klaim</p>
                                        <p class="font-medium text-slate-900">Rp{{ number_format((float) $claim->amount_claimed, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-500">Disetujui</p>
                                        <p class="font-medium text-slate-900">{{ $claim->amount_approved ? 'Rp' . number_format((float) $claim->amount_approved, 0, ',', '.') : '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-4">
                <!-- Action Buttons -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <h3 class="text-sm font-semibold text-slate-900 mb-4">Aksi</h3>
                    <div class="space-y-3">
                        @if($policy->status === 'active')
                            <a href="{{ route('nasabah.claims.create', ['policy_id' => $policy->id]) }}" class="block w-full rounded-full bg-slate-900 px-4 py-2 text-center text-sm font-semibold text-white hover:bg-slate-800 transition">
                                Ajukan Klaim
                            </a>
                        @elseif($policy->status === 'expired')
                            <form action="{{ route('nasabah.policies.renew', $policy) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 transition">
                                    Perpanjang Polis
                                </button>
                            </form>
                        @elseif($policy->status === 'pending')
                            <form action="{{ route('nasabah.policies.cancel', $policy) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full rounded-full border border-red-200 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50 transition" onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan polis ini?')">
                                    Batalkan Pengajuan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Summary Card -->
                <div class="rounded-2xl border-2 border-slate-900 bg-white p-6">
                    <h3 class="text-base font-bold text-slate-900 mb-5">Ringkasan Polis</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between rounded-lg bg-blue-50 px-4 py-3 border border-blue-200">
                            <div>
                                <p class="text-xs font-semibold uppercase text-blue-600">Durasi</p>
                                <p class="mt-1 text-lg font-bold text-blue-900">{{ $policy->start_date->diffInMonths($policy->end_date) }} Bulan</p>
                            </div>
                            <svg class="h-8 w-8 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5H4v8a2 2 0 002 2h12a2 2 0 002-2V7h-2v1a1 1 0 11-2 0V7H9v1a1 1 0 11-2 0V7H6v1a1 1 0 11-2 0V7z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-emerald-50 px-4 py-3 border border-emerald-200">
                            <div>
                                <p class="text-xs font-semibold uppercase text-emerald-600">Premi</p>
                                <p class="mt-1 text-lg font-bold text-emerald-900">Rp{{ number_format((float) $policy->premium_paid, 0, ',', '.') }}</p>
                            </div>
                            <svg class="h-8 w-8 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.16 2.75a.75.75 0 00-1.08 0l-5.5 5.5a.75.75 0 101.06 1.06L7 5.06v12.19a.75.75 0 001.5 0V5.06l4.32 4.32a.75.75 0 101.06-1.06l-5.5-5.5z"></path>
                                <path d="M12.5 15a.75.75 0 00-.75.75v1.5a.75.75 0 001.5 0v-1.5a.75.75 0 00-.75-.75z"></path>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between rounded-lg bg-purple-50 px-4 py-3 border border-purple-200">
                            <div>
                                <p class="text-xs font-semibold uppercase text-purple-600">Coverage</p>
                                <p class="mt-1 text-lg font-bold text-purple-900">Rp{{ number_format((float) $policy->product->coverage_amount, 0, ',', '.') }}</p>
                            </div>
                            <svg class="h-8 w-8 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 2a1 1 0 011-1h8a1 1 0 011 1v1h2a2 2 0 012 2v2h1a1 1 0 110 2h-1v6h1a1 1 0 110 2h-1v2a2 2 0 01-2 2h-2v1a1 1 0 11-2 0v-1H8v1a1 1 0 11-2 0v-1H4a2 2 0 01-2-2v-2H1a1 1 0 110-2h1V9H1a1 1 0 010-2h1V5a2 2 0 012-2h2V2zM4 5h12v10H4V5z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between rounded-lg 
                            @if($policy->status === 'active') bg-emerald-50 border border-emerald-300
                            @elseif($policy->status === 'pending') bg-amber-50 border border-amber-300
                            @elseif($policy->status === 'expired') bg-slate-100 border border-slate-300
                            @elseif($policy->status === 'cancelled') bg-red-50 border border-red-300
                            @endif px-4 py-3">
                            <div>
                                <p class="text-xs font-semibold uppercase 
                                    @if($policy->status === 'active') text-emerald-600
                                    @elseif($policy->status === 'pending') text-amber-600
                                    @elseif($policy->status === 'expired') text-slate-600
                                    @elseif($policy->status === 'cancelled') text-red-600
                                    @endif">Status</p>
                                <p class="mt-1 text-lg font-bold 
                                    @if($policy->status === 'active') text-emerald-900
                                    @elseif($policy->status === 'pending') text-amber-900
                                    @elseif($policy->status === 'expired') text-slate-900
                                    @elseif($policy->status === 'cancelled') text-red-900
                                    @endif">
                                    {{ match($policy->status) {
                                        'active' => 'Aktif',
                                        'pending' => 'Menunggu',
                                        'expired' => 'Expired',
                                        'cancelled' => 'Ditolak',
                                        default => ucfirst($policy->status)
                                    } }}
                                </p>
                            </div>
                            <svg class="h-8 w-8 
                                @if($policy->status === 'active') text-emerald-400
                                @elseif($policy->status === 'pending') text-amber-400
                                @elseif($policy->status === 'expired') text-slate-400
                                @elseif($policy->status === 'cancelled') text-red-400
                                @endif" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 5a1 1 0 00-1.65-.757L11 8.819l-2.35-2.35a1 1 0 10-1.414 1.414l3.364 3.364a1 1 0 001.414 0l7.071-7.071A1 1 0 0018 5z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
