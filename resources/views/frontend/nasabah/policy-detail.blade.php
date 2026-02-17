@extends('frontend.layout-nasabah')

@section('nasabah-content')
<div class="bg-white">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('nasabah.policies') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Header -->
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $policy->policy_number }}</h1>
                        <p class="text-gray-600 mt-2">{{ $policy->product->name }}</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 rounded-lg
                        @if($policy->status === 'active') bg-green-100 text-green-800
                        @elseif($policy->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($policy->status === 'expired') bg-gray-100 text-gray-800
                        @elseif($policy->status === 'cancelled') bg-red-100 text-red-800
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

                <!-- Details Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-600 mb-1">Mulai</p>
                        <p class="text-lg font-bold text-gray-900">{{ $policy->start_date->format('d M Y') }}</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-600 mb-1">Berakhir</p>
                        <p class="text-lg font-bold text-gray-900">{{ $policy->end_date->format('d M Y') }}</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-600 mb-1">Premi</p>
                        <p class="text-lg font-bold text-gray-900">Rp{{ number_format((float) $policy->premium_paid, 0, ',', '.') }}</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-600 mb-1">Coverage</p>
                        <p class="text-lg font-bold text-gray-900">Rp{{ number_format((float) $policy->product->coverage_amount, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Produk</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs font-medium text-gray-600 mb-1">Nama Produk</p>
                            <p class="text-gray-900">{{ $policy->product->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-600 mb-1">Kategori</p>
                            <span class="text-sm font-medium bg-gray-100 text-gray-800 px-3 py-1 rounded-lg inline-block">
                                {{ ucfirst($policy->product->category) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-600 mb-1">Deskripsi</p>
                            <p class="text-gray-700">{{ $policy->product->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Approval Info -->
                @if($policy->status !== 'pending')
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">
                            @if($policy->status === 'active') Persetujuan
                            @elseif($policy->status === 'cancelled') Penolakan
                            @else Informasi
                            @endif
                        </h2>
                        
                        @if($policy->status === 'active' && $policy->approved_by)
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-600 mb-1">Disetujui Oleh</p>
                                    <p class="text-gray-900 font-medium">{{ $policy->approvedBy?->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600 mb-1">Tanggal</p>
                                    <p class="text-gray-900">{{ $policy->approved_at?->format('d M Y H:i') ?? '-' }}</p>
                                </div>
                            </div>
                        @elseif($policy->status === 'cancelled')
                            <div class="space-y-3">
                                @if($policy->rejection_note)
                                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                    <p class="text-xs font-medium text-red-900 mb-1">Alasan</p>
                                    <p class="text-red-800">{{ $policy->rejection_note }}</p>
                                </div>
                                @endif
                                @if($policy->approved_by)
                                <div>
                                    <p class="text-xs font-medium text-gray-600 mb-1">Ditinjau Oleh</p>
                                    <p class="text-gray-900 font-medium">{{ $policy->approvedBy?->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600 mb-1">Tanggal</p>
                                    <p class="text-gray-900">{{ $policy->approved_at?->format('d M Y H:i') ?? '-' }}</p>
                                </div>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-600">Polis berlaku sesuai ketentuan asuransi.</p>
                        @endif
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-sm text-yellow-800">Polis sedang dalam proses review. Waktu tayang: ± 3 hari kerja.</p>
                    </div>
                @endif

                <!-- Related Claims -->
                @if($policy->claims->count() > 0)
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Klaim Terkait</h2>
                        <div class="space-y-3">
                            @foreach($policy->claims as $claim)
                                <a href="{{ route('nasabah.claims.show', $claim) }}" class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 group">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $claim->claim_number }}</p>
                                        <p class="text-xs text-gray-600">{{ $claim->incident_date->format('d M Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">Rp{{ number_format((float) $claim->amount_claimed, 0, ',', '.') }}</p>
                                        <span class="text-xs font-medium 
                                            @if($claim->status === 'approved' || $claim->status === 'paid') text-green-700
                                            @elseif($claim->status === 'rejected') text-red-700
                                            @elseif($claim->status === 'review') text-blue-700
                                            @else text-gray-700
                                            @endif">
                                            {{ match($claim->status) {
                                                'pending' => 'Menunggu',
                                                'review' => 'Review',
                                                'approved' => 'Disetujui',
                                                'paid' => 'Dibayar',
                                                'rejected' => 'Ditolak',
                                                default => ucfirst($claim->status)
                                            } }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-6">
                    <div class="bg-white border border-gray-200 rounded-lg p-6 space-y-4">
                        <h3 class="text-lg font-bold text-gray-900">Aksi</h3>
                        
                        @if($policy->status === 'active')
                            <a href="{{ route('nasabah.claims.create', ['policy_id' => $policy->id]) }}" class="block w-full bg-black text-white font-bold py-3 px-4 rounded-lg text-center hover:bg-gray-800 transition">
                                Ajukan Klaim
                            </a>
                        @elseif($policy->status === 'expired')
                            <form action="{{ route('nasabah.policies.renew', $policy) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full bg-black text-white font-bold py-3 px-4 rounded-lg hover:bg-gray-800 transition">
                                    Perpanjang
                                </button>
                            </form>
                        @elseif($policy->status === 'pending')
                            <form action="{{ route('nasabah.policies.cancel', $policy) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full border border-red-300 text-red-700 font-bold py-3 px-4 rounded-lg hover:bg-red-50 transition" onclick="return confirm('Batalkan polis ini?')">
                                    Batalkan
                                </button>
                            </form>
                        @endif

                        <hr class="border-gray-200" />

                        <div>
                            <h4 class="text-sm font-bold text-gray-900 mb-3">Ringkasan</h4>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Durasi</span>
                                    <span class="text-gray-900 font-medium">{{ $policy->start_date->diffInMonths($policy->end_date) }} bulan</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Premi</span>
                                    <span class="text-gray-900 font-medium">Rp{{ number_format((float) $policy->premium_paid, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Coverage</span>
                                    <span class="text-gray-900 font-medium">Rp{{ number_format((float) $policy->product->coverage_amount, 0, ',', '.') }}</span>
                                </div>
                                <hr class="border-gray-200 -mx-6 px-6" />
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status</span>
                                    <span class="text-xs font-bold px-2 py-1 rounded
                                        @if($policy->status === 'active') bg-green-100 text-green-800
                                        @elseif($policy->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($policy->status === 'expired') bg-gray-100 text-gray-800
                                        @elseif($policy->status === 'cancelled') bg-red-100 text-red-800
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
    </div>
</div>
@endsection
