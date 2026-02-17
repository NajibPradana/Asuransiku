@extends('frontend.layout-nasabah')

@section('nasabah-content')
@php
    $categories = [];
    foreach($activePolicies as $policy) {
        if (!in_array($policy->product->category, $categories)) {
            $categories[] = $policy->product->category;
        }
    }
    foreach($pendingPolicies as $policy) {
        if (!in_array($policy->product->category, $categories)) {
            $categories[] = $policy->product->category;
        }
    }
@endphp

<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-slate-900">Polis Saya</h1>
        <p class="mt-2 text-slate-600">Kelola semua polis dan status pengajuan Anda</p>
    </div>

    <!-- Tabs & Filter -->
    <div class="mb-8 space-y-6">
        <div class="flex items-center justify-between border-b border-slate-200">
            <div class="flex">
                <a href="#active" class="px-4 py-3 font-semibold text-slate-900 border-b-2 border-slate-900 active-tab transition">
                    Polis Aktif ({{ $activePolicies->count() }})
                </a>
                <a href="#pending" class="px-4 py-3 font-medium text-slate-600 hover:text-slate-900 pending-tab transition">
                    Pengajuan Menunggu ({{ $pendingPolicies->count() }})
                </a>
            </div>
        </div>
        
        <!-- Category Filter Buttons -->
        <div>
            <p class="text-sm font-semibold text-slate-700 mb-3">Filter Kategori</p>
            <div class="flex flex-wrap gap-2">
                <button class="category-filter-btn rounded-full border-2 border-slate-900 bg-slate-900 px-5 py-2 text-sm font-semibold text-white transition" data-category="">
                    Semua Kategori
                </button>
                @foreach($categories as $cat)
                    <button class="category-filter-btn rounded-full border-2 border-slate-200 bg-white px-5 py-2 text-sm font-semibold text-slate-700 hover:border-slate-900 transition" data-category="{{ $cat }}">
                        {{ ucfirst($cat) }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Active Policies Tab -->
    <div id="active" class="active-content">
        @if ($activePolicies->count() > 0)
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3" id="activePoliciesGrid">
                @foreach($activePolicies as $policy)
                    <div class="policy-card rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition" data-category="{{ $policy->product->category }}">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-slate-900">{{ $policy->product->name }}</h3>
                                <div class="mt-2 flex items-center gap-3">
                                    <span class="inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 border border-blue-200">{{ ucfirst($policy->product->category) }}</span>
                                    <p class="text-xs font-medium text-slate-500">{{ $policy->policy_number }}</p>
                                </div>
                            </div>
                            <span class="rounded-full bg-emerald-100 px-4 py-1.5 text-xs font-semibold text-emerald-700 whitespace-nowrap">Aktif</span>
                        </div>
                        <hr class="my-4 border-slate-100" />
                        <div class="space-y-3">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Mulai</p>
                                    <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->start_date->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Berakhir</p>
                                    <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->end_date->format('d M Y') }}</p>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Premi Dibayar</p>
                                <p class="mt-1 text-sm font-medium text-slate-900">Rp{{ number_format((float) $policy->premium_paid, 0, ',', '.') }}</p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Coverage</p>
                                <p class="mt-1 text-sm font-medium text-slate-900">Rp{{ number_format((float) ($policy->product->coverage_amount ?? 0), 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button class="flex-1 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">Lihat Detail</button>
                            <button class="flex-1 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-800 transition">Perpanjang</button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-3xl border border-slate-200 bg-white p-8 text-center">
                <p class="text-slate-600">Belum ada polis aktif. <a href="{{ route('nasabah.policies.create') }}" class="font-semibold text-slate-900">Ajukan polis sekarang</a></p>
            </div>
        @endif
    </div>

    <!-- Pending Policies Tab -->
    <div id="pending" class="pending-content hidden">
        @if ($pendingPolicies->count() > 0)
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3" id="pendingPoliciesGrid">
                @foreach($pendingPolicies as $policy)
                    <div class="policy-card rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-md transition" data-category="{{ $policy->product->category }}">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-slate-900">{{ $policy->product->name }}</h3>
                                <div class="mt-2 flex items-center gap-3">
                                    <span class="inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 border border-blue-200">{{ ucfirst($policy->product->category) }}</span>
                                    <p class="text-xs font-medium text-slate-500">{{ $policy->policy_number }}</p>
                                </div>
                            </div>
                            <span class="rounded-full bg-amber-100 px-4 py-1.5 text-xs font-semibold text-amber-700 whitespace-nowrap">Menunggu</span>
                        </div>
                        <hr class="my-4 border-slate-100" />
                        <div class="space-y-3">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Mulai</p>
                                    <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->start_date->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Berakhir</p>
                                    <p class="mt-1 text-sm font-medium text-slate-900">{{ $policy->end_date->format('d M Y') }}</p>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Premi Dibayar</p>
                                <p class="mt-1 text-sm font-medium text-slate-900">Rp{{ number_format((float) $policy->premium_paid, 0, ',', '.') }}</p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Coverage</p>
                                <p class="mt-1 text-sm font-medium text-slate-900">Rp{{ number_format((float) ($policy->product->coverage_amount ?? 0), 0, ',', '.') }}</p>
                            </div>

                            <div class="rounded-full bg-amber-50 border border-amber-200 px-4 py-3">
                                <p class="text-xs text-amber-800">
                                    <span class="font-semibold">Status:</span> Sedang dalam review manager (± 3 hari kerja)
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button class="flex-1 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">Lihat Detail</button>
                            <button class="flex-1 rounded-full border border-red-200 px-4 py-2 text-xs font-semibold text-red-700 hover:bg-red-50 transition">Batalkan</button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-3xl border border-slate-200 bg-white p-8 text-center">
                <p class="text-slate-600">Tidak ada pengajuan yang sedang menunggu persetujuan.</p>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const activeTabs = document.querySelectorAll('.active-tab');
        const pendingTabs = document.querySelectorAll('.pending-tab');
        const activeContent = document.querySelector('.active-content');
        const pendingContent = document.querySelector('.pending-content');

        activeTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                activeContent.classList.remove('hidden');
                pendingContent.classList.add('hidden');
                activeTabs.forEach(t => t.classList.add('border-b-2', 'border-slate-900', 'font-semibold', 'text-slate-900'));
                activeTabs.forEach(t => t.classList.remove('font-medium', 'text-slate-600'));
                pendingTabs.forEach(t => t.classList.remove('border-b-2', 'border-slate-900', 'font-semibold', 'text-slate-900'));
                pendingTabs.forEach(t => t.classList.add('font-medium', 'text-slate-600'));
            });
        });

        pendingTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                pendingContent.classList.remove('hidden');
                activeContent.classList.add('hidden');
                pendingTabs.forEach(t => t.classList.add('border-b-2', 'border-slate-900', 'font-semibold', 'text-slate-900'));
                pendingTabs.forEach(t => t.classList.remove('font-medium', 'text-slate-600'));
                activeTabs.forEach(t => t.classList.remove('border-b-2', 'border-slate-900', 'font-semibold', 'text-slate-900'));
                activeTabs.forEach(t => t.classList.add('font-medium', 'text-slate-600'));
            });
        });

        // Category filter button functionality
        const categoryBtns = document.querySelectorAll('.category-filter-btn');
        const activePolicyCards = document.querySelectorAll('.active-content .policy-card');
        const pendingPolicyCards = document.querySelectorAll('.pending-content .policy-card');

        categoryBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const selectedCategory = this.dataset.category;
                
                // Update button states
                categoryBtns.forEach(b => {
                    b.classList.remove('border-slate-900', 'bg-slate-900', 'text-white');
                    b.classList.add('border-slate-200', 'bg-white', 'text-slate-700');
                });
                this.classList.add('border-slate-900', 'bg-slate-900', 'text-white');
                this.classList.remove('border-slate-200', 'bg-white', 'text-slate-700');
                
                // Filter policy cards
                activePolicyCards.forEach(card => {
                    if (!selectedCategory || card.dataset.category === selectedCategory) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                pendingPolicyCards.forEach(card => {
                    if (!selectedCategory || card.dataset.category === selectedCategory) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    });
</script>

@endsection
