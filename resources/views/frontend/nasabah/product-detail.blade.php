@extends('frontend.layout-nasabah')

@section('nasabah-content')
<div class="container mx-auto px-6 py-12">

    <!-- Back Button -->
    <a href="{{ route('nasabah.products') }}" class="inline-flex items-center text-sm text-slate-600 hover:text-slate-900 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
        Kembali ke Produk
    </a>

    <!-- Product Header -->
    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm mb-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                    {{ ucfirst($product->category) }}
                </span>
                <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                    Aktif
                </span>
            </div>
        </div>
        
        <h1 class="text-3xl font-bold text-slate-900 mb-4">{{ $product->name }}</h1>
        <p class="text-lg text-slate-600 leading-relaxed mb-6">
            {{ $product->description }}
        </p>

        <div class="grid grid-cols-2 gap-4 p-6 bg-slate-50 rounded-2xl">
            <div class="text-center">
                <p class="text-sm text-slate-500 mb-1">Batas Pertanggungan</p>
                <p class="text-2xl font-bold text-slate-900">
                    Rp {{ \App\Support\NumberFormatter::formatNumber($product->coverage_amount, 0) }}
                </p>
            </div>
            <div class="text-center border-l border-slate-200">
                <p class="text-sm text-slate-500 mb-1">Premi per Tahun</p>
                <p class="text-2xl font-bold text-emerald-600">
                    Rp {{ \App\Support\NumberFormatter::formatNumber($product->base_premium, 0) }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <p class="text-slate-700 leading-relaxed">
                    {{ $product->description ?? 'Produk asuransi yang memberikan perlindungan menyeluruh.' }}
                </p>
            </div>
        </div>

        <div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Ajukan Polis</h2>
                <p class="mt-2 text-sm text-slate-600">
                    Mulai perlindungan dengan mengajukan polis sesuai kebutuhan Anda.
                </p>
                <a href="{{ route('nasabah.policies.create', ['product_id' => $product->id]) }}"
                   class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 transition">
                    Ajukan Polis
                </a>
            </div>
        </div>
    </div>
</div>
@endsection