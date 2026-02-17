@extends('frontend.layout-nasabah')

@section('nasabah-content')
<div class="bg-white">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('nasabah.products') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 inline-flex items-center">
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
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                    <p class="text-gray-600 mt-2">{{ $product->description }}</p>
                    <div class="mt-4">
                        <span class="text-sm font-medium bg-gray-100 text-gray-800 px-3 py-1 rounded-lg inline-block">
                            {{ ucfirst($product->category) }}
                        </span>
                    </div>
                </div>

                <!-- Coverage Details -->
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Pertanggungan</h2>
                    <div class="space-y-3">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Coverage Maksimal</p>
                                </div>
                                <p class="text-xl font-bold text-gray-900">Rp{{ number_format((float) $product->coverage_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Premi Tahunan</p>
                                </div>
                                <p class="text-xl font-bold text-gray-900">Rp{{ number_format((float) $product->base_premium, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Benefits -->
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Manfaat</h2>
                    <ul class="space-y-2">
                        <li class="flex items-start gap-3">
                            <span class="text-gray-400 text-lg leading-none">•</span>
                            <span class="text-gray-700">Perlindungan komprehensif untuk kebutuhan asuransi</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-gray-400 text-lg leading-none">•</span>
                            <span class="text-gray-700">Proses klaim yang cepat dan mudah</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-gray-400 text-lg leading-none">•</span>
                            <span class="text-gray-700">Layanan pelanggan tersedia 24/7</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-gray-400 text-lg leading-none">•</span>
                            <span class="text-gray-700">Berbagai pilihan paket yang fleksibel</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-6">
                    <div class="bg-white border border-gray-200 rounded-lg p-6 space-y-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Tertarik dengan produk ini?</h3>
                            <p class="text-sm text-gray-600 mb-4">Ajukan polis sekarang untuk mendapatkan perlindungan.</p>
                            <a href="{{ route('nasabah.policies.create', ['product_id' => $product->id]) }}" class="block w-full bg-black text-white font-bold py-3 px-4 rounded-lg text-center hover:bg-gray-800 transition">
                                Ajukan Polis
                            </a>
                        </div>

                        <hr class="border-gray-200" />

                        <div>
                            <h4 class="text-sm font-bold text-gray-900 mb-3">Ringkasan</h4>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kategori</span>
                                    <span class="text-gray-900 font-medium">{{ ucfirst($product->category) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Coverage</span>
                                    <span class="text-gray-900 font-medium">Rp{{ number_format((float) $product->coverage_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Premi/Tahun</span>
                                    <span class="text-gray-900 font-medium">Rp{{ number_format((float) $product->base_premium, 0, ',', '.') }}</span>
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

