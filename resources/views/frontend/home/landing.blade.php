@extends('frontend.layout')

@section('title', 'Beranda - Portal Asuransi')

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

    .nims-btn-primary {
        background: #0f172a;
        color: white;
        transition: all 0.3s ease;
    }

    .nims-btn-primary:hover {
        background: #1e293b;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.3);
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
<section class="nims-landing relative min-h-screen flex items-center overflow-hidden">
    <div class="absolute -top-20 -right-10 h-80 w-80 rounded-full bg-amber-300/30 blur-3xl nims-float"></div>
    <div class="absolute top-1/3 -left-16 h-96 w-96 rounded-full bg-blue-400/20 blur-3xl nims-float" style="animation-delay: 2s;"></div>
    
    <div class="container mx-auto px-6 py-20 relative z-10">
        <div class="grid gap-12 lg:grid-cols-2 items-center">
            <div>
                <span class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-200 mb-6">
                    <img src="{{ Storage::url($generalSettings->brand_logo_square) }}" alt="NIMS" class="h-4 w-4 object-contain">
                    Nusantara Insurance
                </span>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight text-slate-900 mb-6">
                    Managing Protection with Precision
                </h1>
                <p class="text-xl text-slate-600 mb-8 leading-relaxed max-w-xl">
                    <strong>NIMS</strong> (Nusantara Insurance Management System) - Sistem informasi berbasis web untuk mengelola proses administrasi asuransi secara terintegrasi dan digital.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/nasabah" 
                       class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-slate-900 text-white font-semibold shadow-lg shadow-slate-900/20 hover:bg-slate-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        Portal Nasabah
                    </a>
                    <a href="#layanan" 
                       class="inline-flex items-center justify-center px-8 py-4 rounded-2xl border-2 border-slate-900/20 bg-white/80 text-slate-900 font-semibold hover:bg-white transition">
                        Pelajari Selengkapnya
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
                
                <!-- Quick Stats -->
                <div class="mt-12 grid grid-cols-3 gap-6">
                    <div>
                        <p class="text-3xl font-bold text-slate-900">10+</p>
                        <p class="text-sm text-slate-600">Tahun Pengalaman</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-slate-900">5,000+</p>
                        <p class="text-sm text-slate-600">Nasabah Aktif</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-slate-900">98%</p>
                        <p class="text-sm text-slate-600">Kepuasan</p>
                    </div>
                </div>
            </div>
            
            <div class="hidden lg:flex items-center justify-center">
                <div class="relative">
                    <div class="nims-card rounded-3xl p-8 max-w-md">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-emerald-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900">Polis Disetujui</p>
                                    <p class="text-sm text-slate-600">Bergabung dengan kami sangat mudah</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900">Klaim Transparan</p>
                                    <p class="text-sm text-slate-600">Proses cepat & termonitor</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-amber-600">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900">Premi Terjangkau</p>
                                    <p class="text-sm text-slate-600">Berbagai pilihan paket</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="layanan" class="nims-landing py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-200 mb-4">
                Layanan Kami
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">Solusi Perlindungan Terpadu</h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                Kami menyediakan berbagai produk asuransi yang disesuaikan dengan kebutuhan perlindungan Anda
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Service Card 1: Asuransi Kendaraan -->
            <div class="nims-card rounded-3xl p-8">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-slate-900 mb-3">Asuransi Kendaraan</h3>
                <p class="text-slate-600 leading-relaxed mb-6">
                    Lindungi kendaraan Anda dari risiko kecelakaan, pencurian, dan kerusakan dengan premi kompetitif dan klaim cepat.
                </p>
                <a href="{{ route('home.service.detail', 'kendaraan') }}" class="inline-flex items-center text-sm font-semibold text-slate-900">
                    Pelajari Lebih Lanjut
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            <!-- Service Card 2: Asuransi Kesehatan -->
            <div class="nims-card rounded-3xl p-8">
                <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-emerald-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-slate-900 mb-3">Asuransi Kesehatan</h3>
                <p class="text-slate-600 leading-relaxed mb-6">
                    Dapatkan perlindungan kesehatan terbaik untuk Anda dan keluarga dengan cakupan rawat inap, rawat jalan, dan operasi.
                </p>
                <a href="{{ route('home.service.detail', 'kesehatan') }}" class="inline-flex items-center text-sm font-semibold text-slate-900">
                    Pelajari Lebih Lanjut
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            <!-- Service Card 3: Asuransi Perjalanan -->
            <div class="nims-card rounded-3xl p-8">
                <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-amber-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-slate-900 mb-3">Asuransi Perjalanan</h3>
                <p class="text-slate-600 leading-relaxed mb-6">
                    Perlindungan menyeluruh untuk perjalanan domestik maupun internasional, termasuk kecelakaan dan keterlambatan jadwal.
                </p>
                <a href="{{ route('home.service.detail', 'perjalanan') }}" class="inline-flex items-center text-sm font-semibold text-slate-900">
                    Pelajari Lebih Lanjut
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            <!-- Service Card 4: Asuransi Jiwa -->
            <div class="nims-card rounded-3xl p-8">
                <div class="w-16 h-16 bg-rose-100 rounded-2xl flex items-center justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-rose-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3 4-9 9-9 9 6.34 9 9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.53 21.5c1.56 1.56 4.48 1.56 6.04 0 1.56-1.56 4.48-1.56 6.04 0 1.56 1.56 4.48 1.56 6.04 0" />
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-slate-900 mb-3">Asuransi Jiwa</h3>
                <p class="text-slate-600 leading-relaxed mb-6">
                    Lindungi masa depan keluarga dengan asuransi jiwa berjangka yang terjangkau dan manfaat perlindungan tinggi.
                </p>
                <a href="{{ route('home.service.detail', 'jiwa') }}" class="inline-flex items-center text-sm font-semibold text-slate-900">
                    Pelajari Lebih Lanjut
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- About Section / Vision & Mission -->
<section id="tentang" class="nims-landing py-20">
    <div class="container mx-auto px-6">
        <div class="grid gap-12 lg:grid-cols-2 items-center">
            <div class="order-2 lg:order-1">
                <span class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-200 mb-6">
                    Tentang NIMS
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-6">
                    Visi & Misi Kami
                </h2>
                
                <!-- Vision -->
                <div class="nims-card rounded-3xl p-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-slate-900 mb-2">🎯 Visi</h4>
                            <p class="text-slate-600 leading-relaxed">
                                Menjadi sistem manajemen asuransi digital yang terpercaya, efisien, dan terintegrasi di Indonesia.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Mission -->
                <div class="nims-card rounded-3xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-emerald-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-slate-900 mb-3">🎯 Misi</h4>
                            <ul class="space-y-2 text-slate-600">
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-500 mt-1">✓</span>
                                    <span>Menyediakan sistem pengelolaan polis dan klaim yang terstruktur</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-500 mt-1">✓</span>
                                    <span>Meningkatkan transparansi dan akurasi data nasabah</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-500 mt-1">✓</span>
                                    <span>Mempermudah proses monitoring bagi admin dan manajer</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="text-amber-500 mt-1">✓</span>
                                    <span>Mengoptimalkan efisiensi proses klaim secara digital</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="order-1 lg:order-2">
                <div class="grid gap-6">
                    <div class="nims-card rounded-3xl p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-slate-900">Terpercaya</h4>
                                <p class="text-slate-600">Lebih dari 10 tahun pengalaman di industri asuransi Indonesia</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nims-card rounded-3xl p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-emerald-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-slate-900">Proses Cepat</h4>
                                <p class="text-slate-600">Klaim dan verifikasi diproses dengan cepat dan transparan</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nims-card rounded-3xl p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-amber-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-slate-900">Premi Terjangkau</h4>
                                <p class="text-slate-600">Berbagai pilihan paket dengan harga yang kompetitif</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="nims-card rounded-3xl p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-rose-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-rose-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-slate-900">Layanan 24/7</h4>
                                <p class="text-slate-600">Tim support siap membantu Anda kapan saja dibutuhkan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="nims-landing relative py-20 overflow-hidden">
    <div class="absolute top-0 right-0 h-64 w-64 rounded-full bg-blue-400/20 blur-3xl nims-float"></div>
    <div class="absolute bottom-0 left-0 h-64 w-64 rounded-full bg-amber-300/30 blur-3xl nims-float" style="animation-delay: 2s;"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="nims-card rounded-3xl p-12 md:p-16 text-center">
            <span class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-200 mb-6">
                Mulai Sekarang
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">
                Siap Melindungi Masa Depan Anda?
            </h2>
            <p class="text-xl text-slate-600 mb-10 max-w-2xl mx-auto">
                Akses portal nasabah kami untuk melihat produk asuransi, mengajukan polis, dan mengelola klaim dengan mudah dan aman.
            </p>
            <a href="/nasabah" 
               class="inline-flex items-center px-10 py-5 rounded-2xl bg-slate-900 text-white font-semibold shadow-lg shadow-slate-900/20 hover:bg-slate-800 transition text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                Login Portal Nasabah
            </a>
            
            <div class="mt-12 grid md:grid-cols-3 gap-8 text-left">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-emerald-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-900">Proses Mudah</h4>
                        <p class="text-sm text-slate-600">Pengajuan polis digital dalam hitungan menit</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-blue-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-900">Transparansi Penuh</h4>
                        <p class="text-sm text-slate-600">Monitor status klaim secara real-time</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-amber-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-slate-900">Dukungan Prioritas</h4>
                        <p class="text-sm text-slate-600">Tim support 24/7 siap membantu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="kontak" class="nims-landing py-20">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-200 mb-4">
                Hubungi Kami
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">Kami Siap Membantu Anda</h2>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">
                Hubungi tim kami untuk konsultasi dan informasi lebih lanjut tentang produk asuransi
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="nims-card rounded-3xl p-8 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-blue-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-slate-900 mb-2">Telepon</h4>
                <p class="text-slate-600">{{ $siteSettings->company_phone ?? '(021) 1234-5678' }}</p>
                <p class="text-sm text-slate-500 mt-2">Senin - Jumat, 08:00 - 17:00</p>
            </div>
            
            <div class="nims-card rounded-3xl p-8 text-center">
                <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-emerald-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-slate-900 mb-2">Email</h4>
                <p class="text-slate-600">{{ $siteSettings->company_email ?? 'info@nusantara-insurance.co.id' }}</p>
                <p class="text-sm text-slate-500 mt-2">Kami balas dalam 24 jam</p>
            </div>
            
            <div class="nims-card rounded-3xl p-8 text-center">
                <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-amber-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-slate-900 mb-2">Alamat</h4>
                <p class="text-slate-600">{{ $siteSettings->company_address ?? 'Jakarta Pusat, Indonesia' }}</p>
                <p class="text-sm text-slate-500 mt-2">Kantor Pusat</p>
            </div>
        </div>
    </div>
</section>
@endsection

