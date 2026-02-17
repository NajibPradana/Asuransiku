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
                <div class="rounded-2xl bg-gradient-to-br from-slate-900 to-slate-800 p-6 text-white">
                    <h3 class="text-sm font-semibold opacity-90 mb-4">Ringkasan Polis</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-700 pb-3">
                            <span class="text-sm">Durasi</span>
                            <span class="font-semibold">{{ $policy->start_date->diffInMonths($policy->end_date) }} Bulan</span>
                        </div>
                        <div class="flex items-center justify-between border-b border-slate-700 pb-3">
                            <span class="text-sm">Premi</span>
                            <span class="font-semibold">Rp{{ number_format((float) $policy->premium_paid, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between border-b border-slate-700 pb-3">
                            <span class="text-sm">Coverage</span>
                            <span class="font-semibold">Rp{{ number_format((float) $policy->product->coverage_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-2">
                            <span class="text-sm">Status</span>
                            <span class="rounded-full px-2 py-1 text-xs font-semibold 
                                @if($policy->status === 'active') bg-emerald-500
                                @elseif($policy->status === 'pending') bg-amber-500
                                @elseif($policy->status === 'expired') bg-gray-500
                                @elseif($policy->status === 'cancelled') bg-red-500
                                @endif">
                                {{ match($policy->status) {
                                    'active' => 'Aktif',
                                    'pending' => 'Menunggu',
                                    'expired' => 'Expired',
                                    'cancelled' => 'Ditolak',
                                    default => ucfirst($policy->status)
                                } }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
