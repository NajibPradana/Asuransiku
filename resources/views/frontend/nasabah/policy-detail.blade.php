@extends('frontend.layout-nasabah')

@section('nasabah-content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('nasabah.policies') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Policy Header Card -->
                <div class="bg-white rounded-lg p-8 border border-gray-200">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-2">Nomor Polis</p>
                            <h1 class="text-2xl font-semibold text-gray-900">{{ $policy->policy_number }}</h1>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            @if($policy->status === 'active') bg-green-100 text-green-800
                            @elseif($policy->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($policy->status === 'expired') bg-gray-100 text-gray-800
                            @elseif($policy->status === 'cancelled') bg-red-100 text-red-800
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
                    <p class="text-sm text-gray-600">{{ $policy->product->name }}</p>
                </div>

                <!-- Policy Details Grid -->
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Tanggal Mulai</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $policy->start_date->format('d M Y') }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Tanggal Berakhir</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $policy->end_date->format('d M Y') }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Premi Dibayar</p>
                        <p class="text-lg font-semibold text-gray-900">Rp{{ number_format((float) $policy->premium_paid, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Coverage</p>
                        <p class="text-lg font-semibold text-gray-900">Rp{{ number_format((float) $policy->product->coverage_amount, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="bg-white rounded-lg p-8 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Produk Asuransi</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Nama Produk</p>
                            <p class="text-gray-900">{{ $policy->product->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Kategori</p>
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                {{ ucfirst($policy->product->category) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Deskripsi</p>
                            <p class="text-gray-700">{{ $policy->product->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Approval Information -->
                @if($policy->status !== 'pending')
                    <div class="bg-white rounded-lg p-8 border border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">
                            @if($policy->status === 'active') Persetujuan
                            @elseif($policy->status === 'cancelled') Penolakan
                            @elseif($policy->status === 'expired') Informasi Polis
                            @endif
                        </h2>
                        
                        @if($policy->status === 'active' && $policy->approved_by)
                            <div class="space-y-4">
                                <div class="flex items-start gap-4 pb-4 border-b border-gray-200">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-600 mb-1">Disetujui Oleh</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $policy->approvedBy?->name ?? 'System Admin' }}</p>
                                    </div>
                                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Tanggal Persetujuan</p>
                                    <p class="text-gray-900">{{ $policy->approved_at?->format('d M Y H:i') ?? '-' }}</p>
                                </div>
                            </div>
                        @elseif($policy->status === 'cancelled')
                            <div class="space-y-4">
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                    <p class="text-sm font-medium text-red-900 mb-2">Alasan Penolakan</p>
                                    <p class="text-red-800">{{ $policy->rejection_note ?? 'Tidak ada alasan yang diberikan' }}</p>
                                </div>
                                @if($policy->approved_by)
                                <div class="flex items-start gap-4 pb-4 border-b border-gray-200">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-600 mb-1">Ditinjau Oleh</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $policy->approvedBy?->name ?? 'System Admin' }}</p>
                                    </div>
                                    <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M13.707 10.293a1 1 0 010 1.414L10.414 15l3.293 3.293a1 1 0 01-1.414 1.414L9 16.414l-3.293 3.293a1 1 0 01-1.414-1.414L7.586 15 4.293 11.707a1 1 0 011.414-1.414L9 13.586l3.293-3.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Tanggal Keputusan</p>
                                    <p class="text-gray-900">{{ $policy->approved_at?->format('d M Y H:i') ?? '-' }}</p>
                                </div>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-600">Polis berlaku sesuai ketentuan asuransi yang telah disepakati.</p>
                        @endif
                    </div>
                @else
                    <div class="bg-yellow-50 rounded-lg p-6 border border-yellow-200">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm text-yellow-800">Polis masih dalam proses peninjauan oleh tim manager. Perkiraan waktu proses: ± 3 hari kerja.</p>
                        </div>
                    </div>
                @endif

                <!-- Related Claims -->
                @if($policy->claims->count() > 0)
                    <div class="bg-white rounded-lg p-8 border border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Klaim Terkait</h2>
                        <div class="space-y-3">
                            @foreach($policy->claims as $claim)
                                <a href="{{ route('nasabah.claims.show', $claim) }}" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200 group">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900 group-hover:text-gray-700">{{ $claim->claim_number }}</p>
                                        <p class="text-sm text-gray-600">{{ $claim->incident_date->format('d M Y') }}</p>
                                    </div>
                                    <div class="text-right mr-4">
                                        <p class="font-medium text-gray-900">Rp{{ number_format((float) $claim->amount_claimed, 0, ',', '.') }}</p>
                                        <span class="text-xs font-semibold 
                                            @if($claim->status === 'approved') text-green-700
                                            @elseif($claim->status === 'paid') text-green-700
                                            @elseif($claim->status === 'rejected') text-red-700
                                            @elseif($claim->status === 'pending') text-yellow-700
                                            @elseif($claim->status === 'review') text-blue-700
                                            @else text-gray-700
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
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar Actions -->
            <div class="lg:col-span-1">
                <div class="sticky top-6 space-y-4">
                    <!-- Action Buttons -->
                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg p-6 text-white shadow-lg">
                        <h3 class="text-sm font-bold text-white mb-4">Aksi Cepat</h3>
                        <div class="space-y-3">
                            @if($policy->status === 'active')
                                <a href="{{ route('nasabah.claims.create', ['policy_id' => $policy->id]) }}" class="block w-full rounded-lg bg-white text-blue-600 px-4 py-3 text-center text-sm font-bold hover:bg-gray-100 transition shadow-md">
                                    Ajukan Klaim
                                </a>
                            @elseif($policy->status === 'expired')
                                <form action="{{ route('nasabah.policies.renew', $policy) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full rounded-lg bg-white text-blue-600 px-4 py-3 text-sm font-bold hover:bg-gray-100 transition shadow-md">
                                        Perpanjang Polis
                                    </button>
                                </form>
                            @elseif($policy->status === 'pending')
                                <form action="{{ route('nasabah.policies.cancel', $policy) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full rounded-lg bg-white text-red-600 px-4 py-3 text-sm font-bold hover:bg-gray-100 transition shadow-md" onclick="return confirm('Apakah Anda yakin ingin membatalkan polis ini?')">
                                        Batalkan Pengajuan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Summary Card -->
                    <div class="bg-white rounded-lg p-6 border border-gray-200">
                        <h3 class="text-sm font-bold text-gray-900 mb-4">Ringkasan Polis</h3>
                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-4">
                                <p class="text-xs font-bold uppercase text-blue-600 mb-1">Durasi</p>
                                <p class="text-2xl font-bold text-blue-900">{{ $policy->start_date->diffInMonths($policy->end_date) }} bulan</p>
                            </div>
                            <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-lg p-4">
                                <p class="text-xs font-bold uppercase text-green-600 mb-1">Premi</p>
                                <p class="text-2xl font-bold text-green-900">Rp{{ number_format((float) $policy->premium_paid, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-4">
                                <p class="text-xs font-bold uppercase text-purple-600 mb-1">Coverage</p>
                                <p class="text-2xl font-bold text-purple-900">Rp{{ number_format((float) $policy->product->coverage_amount, 0, ',', '.') }}</p>
                            </div>
                            <hr class="my-2" />
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 font-medium">Status</span>
                                <span class="px-3 py-1 rounded-lg text-xs font-bold
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
@endsection
