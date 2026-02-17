@extends('frontend.layout-nasabah')

@section('nasabah-content')
<div class="container mx-auto px-6 py-12">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('nasabah.products') }}" class="mb-4 inline-flex items-center text-sm font-medium text-slate-600 hover:text-slate-900">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Produk
        </a>
    </div>

    <!-- Product Detail -->
    <div class="grid gap-8 lg:grid-cols-3">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Product Header -->
            <div class="rounded-2xl border border-slate-200 bg-white p-8">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-3xl font-semibold text-slate-900">{{ $product->name }}</h1>
                        <span class="mt-3 inline-block rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700">
                            {{ ucfirst($product->category) }}
                        </span>
                    </div>
                </div>
                <hr class="my-6" />
                <p class="text-lg text-slate-700 leading-relaxed">{{ $product->description }}</p>
            </div>

            <!-- Key Benefits -->
            <div class="rounded-2xl border border-slate-200 bg-white p-8">
                <h2 class="text-xl font-semibold text-slate-900 mb-6">Keunggulan Produk</h2>
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900">Perlindungan Komprehensif</h3>
                            <p class="mt-1 text-sm text-slate-600">Cakupan perlindungan yang luas dan mendalam</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900">Proses Klaim Mudah</h3>
                            <p class="mt-1 text-sm text-slate-600">Pengajuan dan persetujuan klaim yang cepat</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900">Layanan Pelanggan 24/7</h3>
                            <p class="mt-1 text-sm text-slate-600">Tim support kami siap membantu kapanpun</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-slate-900">Fleksibel & Terjangkau</h3>
                            <p class="mt-1 text-sm text-slate-600">Berbagai paket dengan harga kompetitif</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coverage Details -->
            <div class="rounded-2xl border border-slate-200 bg-white p-8">
                <h2 class="text-xl font-semibold text-slate-900 mb-6">Detail Coverage</h2>
                <div class="space-y-4">
                    <div class="rounded-lg bg-slate-50 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-slate-900">Jangkauan Pertanggungan</p>
                                <p class="text-sm text-slate-600">Maksimal perlindungan yang diberikan</p>
                            </div>
                            <p class="text-2xl font-bold text-slate-900">Rp{{ number_format((float) $product->coverage_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-slate-900">Premi Dasar (Tahun)</p>
                                <p class="text-sm text-slate-600">Estimasi biaya per tahun</p>
                            </div>
                            <p class="text-2xl font-bold text-slate-900">Rp{{ number_format((float) $product->base_premium, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar - Action -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-4">
                <!-- Apply Button -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Tertarik dengan Produk Ini?</h3>
                    <p class="text-sm text-slate-600 mb-6">Ajukan polis sekarang dan dapatkan perlindungan yang Anda butuhkan.</p>
                    <a href="{{ route('nasabah.policies.create') }}" class="block w-full rounded-full bg-slate-900 px-6 py-3 text-center text-sm font-semibold text-white hover:bg-slate-800 transition">
                        Ajukan Polis Sekarang
                    </a>
                </div>

                <!-- Product Info Card -->
                <div class="rounded-2xl bg-gradient-to-br from-blue-900 to-blue-800 p-6 text-white">
                    <h3 class="text-sm font-semibold opacity-90 mb-4">Informasi Singkat</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs uppercase opacity-75">Kategori</p>
                            <p class="font-semibold text-lg">{{ ucfirst($product->category) }}</p>
                        </div>
                        <div class="border-t border-blue-700 pt-3">
                            <p class="text-xs uppercase opacity-75">Coverage</p>
                            <p class="font-semibold text-lg">Rp{{ number_format((float) $product->coverage_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="border-t border-blue-700 pt-3">
                            <p class="text-xs uppercase opacity-75">Premi Tahunan</p>
                            <p class="font-semibold text-lg">Rp{{ number_format((float) $product->base_premium, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Pertanyaan Umum?</h3>
                    <p class="text-sm text-slate-600 mb-4">Hubungi tim layanan pelanggan kami untuk informasi lebih lanjut tentang produk ini.</p>
                    <a href="javascript:void(0)" class="block text-sm font-semibold text-slate-900 hover:text-slate-700">
                        Hubungi Customer Service →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

