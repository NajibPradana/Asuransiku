@extends('frontend.layout-nasabah')

@section('nasabah-content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('nasabah.claims') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Claim Header Card -->
                <div class="bg-white rounded-lg p-8 border border-gray-200">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-2">Nomor Klaim</p>
                            <h1 class="text-2xl font-semibold text-gray-900">{{ $claim->claim_number }}</h1>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            @if($claim->status === 'approved') bg-green-100 text-green-800
                            @elseif($claim->status === 'paid') bg-blue-100 text-blue-800
                            @elseif($claim->status === 'rejected') bg-red-100 text-red-800
                            @elseif($claim->status === 'review') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ match($claim->status) {
                                'pending' => 'Menunggu',
                                'review' => 'Dalam Review',
                                'approved' => 'Disetujui',
                                'paid' => 'Dibayar',
                                'rejected' => 'Ditolak',
                                default => ucfirst($claim->status)
                            } }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600">Polis: {{ $claim->policy->policy_number }}</p>
                </div>

                <!-- Claim Details Grid -->
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Tanggal Insiden</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $claim->incident_date->format('d M Y') }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Tanggal Pengajuan</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $claim->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Nominal Diajukan</p>
                        <p class="text-lg font-semibold text-gray-900">Rp{{ number_format((float) $claim->amount_claimed, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Nominal Disetujui</p>
                        <p class="text-lg font-semibold 
                            @if($claim->amount_approved) text-green-700
                            @else text-gray-600
                            @endif">
                            {{ $claim->amount_approved ? 'Rp' . number_format((float) $claim->amount_approved, 0, ',', '.') : 'Menunggu Keputusan' }}
                        </p>
                    </div>
                </div>

                <!-- Policy Information -->
                <div class="bg-white rounded-lg p-8 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Polis</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Nomor Polis</p>
                            <a href="{{ route('nasabah.policies.show', $claim->policy) }}" class="text-gray-900 font-medium hover:text-gray-700">
                                {{ $claim->policy->policy_number }}
                                <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Produk</p>
                            <p class="text-gray-900">{{ $claim->policy->product->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Jangkauan Coverage</p>
                            <p class="text-gray-900">Rp{{ number_format((float) $claim->policy->product->coverage_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Claim Description -->
                <div class="bg-white rounded-lg p-8 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Deskripsi Klaim</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $claim->description }}</p>
                </div>

                <!-- Approval/Rejection Information -->
                @if($claim->status !== 'pending')
                    <div class="bg-white rounded-lg p-8 border border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">
                            @if($claim->status === 'approved' || $claim->status === 'paid') Persetujuan Klaim
                            @elseif($claim->status === 'rejected') Penolakan Klaim
                            @else Informasi Proses
                            @endif
                        </h2>
                        
                        @if(($claim->status === 'approved' || $claim->status === 'paid') && $claim->approved_by)
                            <div class="space-y-4">
                                <div class="flex items-start gap-4 pb-4 border-b border-gray-200">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-600 mb-1">Disetujui Oleh</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $claim->approvedBy?->name ?? 'System Admin' }}</p>
                                    </div>
                                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Tanggal Persetujuan</p>
                                    <p class="text-gray-900">{{ $claim->approved_at?->format('d M Y H:i') ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Nominal Disetujui</p>
                                    <p class="text-lg font-semibold text-green-700">Rp{{ number_format((float) $claim->amount_approved, 0, ',', '.') }}</p>
                                </div>

                                @if($claim->status === 'paid' && $claim->paid_at)
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                                    <p class="text-sm font-medium text-blue-900 mb-1">Tanggal Pembayaran</p>
                                    <p class="text-blue-800">{{ $claim->paid_at->format('d M Y H:i') }}</p>
                                </div>
                                @endif
                            </div>
                        @elseif($claim->status === 'rejected')
                            <div class="space-y-4">
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                    <p class="text-sm font-medium text-red-900 mb-2">Alasan Penolakan</p>
                                    <p class="text-red-800">{{ $claim->rejection_reason ?? 'Tidak ada alasan yang diberikan' }}</p>
                                </div>
                                @if($claim->approved_by)
                                <div class="flex items-start gap-4 pb-4 border-b border-gray-200">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-600 mb-1">Ditinjau Oleh</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $claim->approvedBy?->name ?? 'System Admin' }}</p>
                                    </div>
                                    <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M13.707 10.293a1 1 0 010 1.414L10.414 15l3.293 3.293a1 1 0 01-1.414 1.414L9 16.414l-3.293 3.293a1 1 0 01-1.414-1.414L7.586 15 4.293 11.707a1 1 0 011.414-1.414L9 13.586l3.293-3.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Tanggal Keputusan</p>
                                    <p class="text-gray-900">{{ $claim->approved_at?->format('d M Y H:i') ?? '-' }}</p>
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="bg-yellow-50 rounded-lg p-6 border border-yellow-200">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-sm text-yellow-800">Klaim Anda sedang dalam proses review oleh tim kami. Kami akan memberikan keputusan dalam waktu 5-7 hari kerja.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 5a1 1 0 00-1.65-.757L11 8.819l-2.35-2.35a1 1 0 10-1.414 1.414l3.364 3.364a1 1 0 001.414 0l7.071-7.071A1 1 0 0018 5z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm text-gray-800">Klaim Anda telah berhasil diajukan. Silakan tunggu proses review dari tim kami.</p>
                        </div>
                    </div>
                @endif

                <!-- Evidence Files -->
                @if($claim->evidence_files && count($claim->evidence_files) > 0)
                    <div class="bg-white rounded-lg p-8 border border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Bukti Pendukung</h2>
                        <div class="space-y-2">
                            @foreach($claim->evidence_files as $file)
                                <a href="{{ asset('storage/' . $file) }}" download class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200">
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 16.5c0-1.1.9-2 2-2h4a2 2 0 012 2v.5a.5.5 0 00.5-.5V9a3 3 0 00-3-3H9a3 3 0 00-3 3v7a.5.5 0 00.5.5h.5v-.5zM7 9a4 4 0 014-4h4a4 4 0 014 4v8a2 2 0 01-2 2h-4a2 2 0 01-2-2V9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div className="flex-1">
                                        <p class="font-medium text-gray-900 text-sm">{{ basename($file) }}</p>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-6 space-y-4">
                    <!-- Summary Card -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4">Ringkasan Klaim</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Nominal Diajukan</p>
                                <p class="text-lg font-semibold text-gray-900">Rp{{ number_format((float) $claim->amount_claimed, 0, ',', '.') }}</p>
                            </div>
                            @if($claim->amount_approved)
                            <div>
                                <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Nominal Disetujui</p>
                                <p class="text-lg font-semibold text-green-700">Rp{{ number_format((float) $claim->amount_approved, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-600 mt-2">Selisih: Rp{{ number_format((float) ($claim->amount_claimed - $claim->amount_approved), 0, ',', '.') }}</p>
                            </div>
                            @endif
                            <hr class="my-2" />
                            <div>
                                <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Status</p>
                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                                    @if($claim->status === 'approved') bg-green-100 text-green-800
                                    @elseif($claim->status === 'paid') bg-blue-100 text-blue-800
                                    @elseif($claim->status === 'rejected') bg-red-100 text-red-800
                                    @elseif($claim->status === 'review') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ match($claim->status) {
                                        'pending' => 'Menunggu',
                                        'review' => 'Dalam Review',
                                        'approved' => 'Disetujui',
                                        'paid' => 'Dibayar',
                                        'rejected' => 'Ditolak',
                                        default => ucfirst($claim->status)
                                    } }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Link ke Polis -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-3">Informasi Terkait</h3>
                        <a href="{{ route('nasabah.policies.show', $claim->policy) }}" class="block w-full rounded-lg bg-gray-100 px-4 py-2 text-center text-sm font-semibold text-gray-900 hover:bg-gray-200 transition">
                            Lihat Polis
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
