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

        <!-- Coverage & Premium -->
        <div class="grid grid-cols-2 gap-4 p-6 bg-slate-50 rounded-2xl">
            <div class="text-center">
                <p class="text-sm text-slate-500 mb-1">Batas Pertanggungan</p>
                <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($product->coverage_amount, 0, ',', '.') }}</p>
            </div>
            <div class="text-center border-l border-slate-200">
                <p class="text-sm text-slate-500 mb-1">Premi per Tahun</p>
                <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($product->base_premium, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm mb-6">
        <h2 class="text-xl font-bold text-slate-900 mb-6">Keunggulan Produk</h2>
        <div class="grid md:grid-cols-2 gap-4">
            @if(isset($serviceInfo['benefits']))
                @foreach($serviceInfo['benefits'] as $benefit)
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-emerald-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <p class="text-slate-700">{{ $benefit }}</p>
                </div>
                @endforeach
            @else
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-emerald-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <p class="text-slate-700">Perlindungan komprehensif sesuai kebutuhan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Terms & Conditions -->
    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm mb-6">
        <h2 class="text-xl font-bold text-slate-900 mb-4">Syarat & Ketentuan</h2>
        <div class="space-y-3 text-sm text-slate-600">
            <p>• Pemohon harus berusia minimal 18 tahun dan maksimal 65 tahun.</p>
            <p>• Pembayaran premi dapat dilakukan secara tahunan.</p>
            <p>• Klaim dapat diajukan melalui portal nasabah atau kantor cabang.</p>
            <p>• Masa tunggu berlaku untuk beberapa jenis klaim.</p>
            <p>• Untuk informasi lebih lengkap, silakan hubungi layanan pelanggan.</p>
        </div>
    </div>

    <!-- CTA Button -->
    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm text-center">
        <h3 class="text-lg font-semibold text-slate-900 mb-2">Tertarik dengan Produk Ini?</h3>
        <p class="text-sm text-slate-600 mb-6">
            Ajukan polis sekarang dan dapatkan perlindungan terbaik untuk Anda dan keluarga.
        </p>
        <a href="{{ route('nasabah.policies.create') }}" 
           class="inline-flex items-center px-8 py-3 rounded-xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Ajukan Polis Sekarang
        </a>
    </div>
</div>

@endsection

