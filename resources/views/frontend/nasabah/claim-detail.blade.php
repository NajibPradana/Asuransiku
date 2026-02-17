@extends('frontend.layout-nasabah')

@section('nasabah-content')
<div class="bg-white">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('nasabah.claims') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 inline-flex items-center">
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
                        <h1 class="text-3xl font-bold text-gray-900">{{ $claim->claim_number }}</h1>
                        <p class="text-gray-600 mt-2">Polis: {{ $claim->policy->policy_number }}</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 rounded-lg
                        @if($claim->status === 'approved' || $claim->status === 'paid') bg-green-100 text-green-800
                        @elseif($claim->status === 'rejected') bg-red-100 text-red-800
                        @elseif($claim->status === 'review') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800
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

                <!-- Details Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-600 mb-1">Tanggal Insiden</p>
                        <p class="text-lg font-bold text-gray-900">{{ $claim->incident_date->format('d M Y') }}</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-600 mb-1">Nomor Diajukan</p>
                        <p class="text-lg font-bold text-gray-900">{{ $claim->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-600 mb-1">Nominal Diajukan</p>
                        <p class="text-lg font-bold text-gray-900">Rp{{ number_format((float) $claim->amount_claimed, 0, ',', '.') }}</p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-xs font-medium text-gray-600 mb-1">Nominal Disetujui</p>
                        <p class="text-lg font-bold text-gray-900">
                            @if($claim->amount_approved)
                                Rp{{ number_format((float) $claim->amount_approved, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Description -->
                <div class="border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Deskripsi</h2>
                    <p class="text-gray-700">{{ $claim->description }}</p>
                </div>

                <!-- Policy Info -->
                <div class="border border-gray-200 rounded-lg p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Polis</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs font-medium text-gray-600 mb-1">Nomor Polis</p>
                            <a href="{{ route('nasabah.policies.show', $claim->policy) }}" class="text-gray-900 font-medium hover:text-gray-700">
                                {{ $claim->policy->policy_number }} →
                            </a>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-600 mb-1">Produk</p>
                            <p class="text-gray-900">{{ $claim->policy->product->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-600 mb-1">Coverage</p>
                            <p class="text-gray-900">Rp{{ number_format((float) $claim->policy->product->coverage_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Approval Info -->
                @if($claim->status !== 'pending')
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">
                            @if($claim->status === 'approved' || $claim->status === 'paid') Persetujuan
                            @elseif($claim->status === 'rejected') Penolakan
                            @else Informasi
                            @endif
                        </h2>

                        @if(($claim->status === 'approved' || $claim->status === 'paid') && $claim->approved_by)
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-600 mb-1">Disetujui Oleh</p>
                                    <p class="text-gray-900 font-medium">{{ $claim->approvedBy?->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600 mb-1">Tanggal</p>
                                    <p class="text-gray-900">{{ $claim->approved_at?->format('d M Y H:i') ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600 mb-1">Nominal Disetujui</p>
                                    <p class="text-lg font-bold text-green-700">Rp{{ number_format((float) $claim->amount_approved, 0, ',', '.') }}</p>
                                </div>
                                @if($claim->status === 'paid' && $claim->paid_at)
                                <div class="pt-3 border-t border-gray-200">
                                    <p class="text-xs font-medium text-gray-600 mb-1">Dibayar Pada</p>
                                    <p class="text-gray-900">{{ $claim->paid_at->format('d M Y H:i') }}</p>
                                </div>
                                @endif
                            </div>
                        @elseif($claim->status === 'rejected')
                            <div class="space-y-3">
                                @if($claim->rejection_reason)
                                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                    <p class="text-xs font-medium text-red-900 mb-1">Alasan Penolakan</p>
                                    <p class="text-red-800">{{ $claim->rejection_reason }}</p>
                                </div>
                                @endif
                                @if($claim->approved_by)
                                <div>
                                    <p class="text-xs font-medium text-gray-600 mb-1">Ditinjau Oleh</p>
                                    <p class="text-gray-900 font-medium">{{ $claim->approvedBy?->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600 mb-1">Tanggal</p>
                                    <p class="text-gray-900">{{ $claim->approved_at?->format('d M Y H:i') ?? '-' }}</p>
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <p class="text-sm text-blue-800">Klaim Anda sedang dalam proses review. Estimasi waktu: 5-7 hari kerja.</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <p class="text-sm text-gray-800">Klaim telah diajukan. Silakan tunggu proses review kami.</p>
                    </div>
                @endif

                <!-- Evidence Files -->
                @if($claim->evidence_files && count($claim->evidence_files) > 0)
                    <div class="border border-gray-200 rounded-lg p-6">
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Dokumen Pendukung</h2>
                        <div class="space-y-2">
                            @foreach($claim->evidence_files as $file)
                                <a href="{{ asset('storage/' . $file) }}" download class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <svg class="w-5 h-5 text-gray-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 16.5a1 1 0 01-1-1v-5h-.5a1 1 0 010-2h.5v-2h-.5a1 1 0 010-2h.5V6a1 1 0 011-1h1a1 1 0 011 1v2h.5a1 1 0 010 2h-.5v5h.5a1 1 0 010 2h-.5v1a1 1 0 01-1 1h-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700 flex-1">{{ basename($file) }}</span>
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
                        <h3 class="text-lg font-bold text-gray-900">Ringkasan</h3>
                        
                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-xs font-medium text-gray-600 mb-1">Diajukan</p>
                                <p class="text-lg font-bold text-gray-900">Rp{{ number_format((float) $claim->amount_claimed, 0, ',', '.') }}</p>
                            </div>
                            @if($claim->amount_approved)
                            <div>
                                <p class="text-xs font-medium text-gray-600 mb-1">Disetujui</p>
                                <p class="text-lg font-bold text-green-700">Rp{{ number_format((float) $claim->amount_approved, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-600 mt-1">Selisih: Rp{{ number_format((float) ($claim->amount_claimed - $claim->amount_approved), 0, ',', '.') }}</p>
                            </div>
                            @endif
                            <hr class="border-gray-200 -mx-6 px-6" />
                            <div>
                                <p class="text-xs font-medium text-gray-600 mb-1">Status</p>
                                <span class="text-xs font-bold px-2 py-1 rounded
                                    @if($claim->status === 'approved' || $claim->status === 'paid') bg-green-100 text-green-800
                                    @elseif($claim->status === 'rejected') bg-red-100 text-red-800
                                    @elseif($claim->status === 'review') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800
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
                        </div>

                        <hr class="border-gray-200" />

                        <a href="{{ route('nasabah.policies.show', $claim->policy) }}" class="block w-full bg-gray-100 text-gray-900 font-bold py-2 px-4 rounded-lg text-center hover:bg-gray-200 transition text-sm">
                            Lihat Polis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
