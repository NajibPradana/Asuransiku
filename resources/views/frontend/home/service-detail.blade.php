@extends('frontend.layout')

@section('title', $serviceInfo['title'] ?? 'Layanan - Portal Asuransi')

@section('content')

<style>
    .nims-landing {
        background: radial-gradient(1100px circle at 12% 15%, rgba(59, 130, 246, 0.2), transparent 50%),
            radial-gradient(900px circle at 88% 10%, rgba(250, 204, 21, 0.22), transparent 45%),
            linear-gradient(145deg, #f8fafc 0%, #eef2ff 45%, #fff7ed 100%);
        font-family: "Space Grotesk", "Helvetica Neue", Helvetica, sans-serif;
    }

    .nims-card {
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(15, 23, 42, 0.08);
        box-shadow: 0 25px 50px rgba(15, 23, 42, 0.1);
        transition: all 0.3s ease;
    }

    .nims-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 60px rgba(15, 23, 42, 0.15);
    }

    .nims-float {
        animation: float 8s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
    }
</style>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700&display=swap" rel="stylesheet" />

<!-- Hero Section -->
<section class="nims-landing relative py-20 overflow-hidden">
    <div class="absolute -top-20 -right-10 h-80 w-80 rounded-full bg-amber-300/30 blur-3xl nims-float"></div>
    <div class="absolute top-1/3 -left-16 h-96 w-96 rounded-full bg-blue-400/20 blur-3xl nims-float" style="animation-delay: 2s;"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm text-slate-600 hover:text-slate-900 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Beranda
            </a>
            <span class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-200 mb-4">
                Layanan Kami
            </span>
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">
                {{ $serviceInfo['title'] ?? 'Layanan' }}
            </h1>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                {{ $serviceInfo['description'] ?? '' }}
            </p>
        </div>
    </div>
</section>

<!-- Benefits Section -->
<section class="nims-landing py-16">
    <div class="container mx-auto px-6">
        <div class="nims-card rounded-3xl p-8 md:p-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-8 text-center">Keunggulan Layanan</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if(isset($serviceInfo['benefits']))
                    @foreach($serviceInfo['benefits'] as $benefit)
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-emerald-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                        <p class="text-slate-700 font-medium">{{ $benefit }}</p>
                    </div>
                    @endforeach
                @endif
            </div>
            
            <!-- Coverage & Premium Info -->
            <div class="grid md:grid-cols-2 gap-6 mt-10 pt-10 border-t border-slate-200">
                <div class="text-center p-6 bg-blue-50 rounded-2xl">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Batas Pertanggungan</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ $serviceInfo['coverage'] ?? '-' }}</p>
                </div>
                <div class="text-center p-6 bg-amber-50 rounded-2xl">
                    <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-amber-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900 mb-2">Premi Mulai Dari</h3>
                    <p class="text-2xl font-bold text-amber-600">{{ $serviceInfo['premium'] ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="nims-landing py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Paket Asuransi Tersedia</h2>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Pilih paket yang sesuai dengan kebutuhan Anda
            </p>
        </div>
        
        @if($products->isNotEmpty())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products as $product)
            <div class="nims-card rounded-3xl p-8">
                <div class="flex items-center justify-between mb-4">
                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                        {{ ucfirst($product->category) }}
                    </span>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-3">{{ $product->name }}</h3>
                <p class="text-slate-600 text-sm mb-6 leading-relaxed">
                    {{ $product->description }}
                </p>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <span class="text-sm text-slate-600">Batas Pertanggungan</span>
                        <span class="text-sm font-semibold text-slate-900">Rp {{ \App\Support\NumberFormatter::formatNumber($product->coverage_amount, 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-slate-100">
                        <span class="text-sm text-slate-600">Premi per Tahun</span>
                        <span class="text-sm font-semibold text-emerald-600">Rp {{ \App\Support\NumberFormatter::formatNumber($product->base_premium, 0) }}</span>
                    </div>
                </div>
                
                <a href="{{ route('nasabah.login') }}" 
                   class="inline-flex items-center justify-center w-full px-6 py-3 rounded-xl bg-slate-900 text-white font-semibold hover:bg-slate-800 transition">
                    Daftar Sekarang
                </a>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-slate-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Paket Sedang Dalam Pengembangan</h3>
            <p class="text-slate-600">Saat ini belum ada paket asuransi untuk kategori ini. Silakan hubungi kami untuk informasi lebih lanjut.</p>
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="nims-landing relative py-20 overflow-hidden">
    <div class="absolute top-0 right-0 h-64 w-64 rounded-full bg-blue-400/20 blur-3xl nims-float"></div>
    <div class="absolute bottom-0 left-0 h-64 w-64 rounded-full bg-amber-300/30 blur-3xl nims-float" style="animation-delay: 2s;"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="nims-card rounded-3xl p-12 md:p-16 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">
                Tertarik dengan Layanan Ini?
            </h2>
            <p class="text-xl text-slate-600 mb-10 max-w-2xl mx-auto">
                Daftar sekarang untuk mendapatkan perlindungan terbaik untuk Anda dan keluarga.
            </p>
            <a href="{{ route('nasabah.login') }}" 
               class="inline-flex items-center px-10 py-5 rounded-2xl bg-slate-900 text-white font-semibold shadow-lg shadow-slate-900/20 hover:bg-slate-800 transition text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                Login Portal Nasabah
            </a>
            <p class="text-sm text-slate-500 mt-4">Belum punya akun? <a href="{{ route('nasabah.register') }}" class="text-blue-600 hover:underline">Daftar di sini</a></p>
        </div>
    </div>
</section>

@endsection

