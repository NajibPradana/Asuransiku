@extends('frontend.layout-nasabah')

@section('nasabah-content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-6 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('nasabah.products') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Produk
            </a>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Product Header -->
                <div class="bg-white rounded-lg border border-gray-200 p-8">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                            <span class="mt-4 inline-block px-4 py-2 bg-blue-100 text-blue-800 font-semibold text-sm rounded-lg">
                                {{ ucfirst($product->category) }}
                            </span>
                        </div>
                    </div>
                    <hr class="my-6" />
                    <p class="text-lg text-gray-700 leading-relaxed">{{ $product->description }}</p>
                </div>

                <!-- Key Benefits -->
                <div class="bg-white rounded-lg border border-gray-200 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Keunggulan Produk</h2>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-green-100">
                                    <svg class="h-6 w-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Perlindungan Komprehensif</h3>
                                <p class="mt-2 text-sm text-gray-600">Cakupan perlindungan yang luas dan mendalam untuk semua kebutuhan</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-blue-100">
                                    <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Proses Klaim Mudah</h3>
                                <p class="mt-2 text-sm text-gray-600">Pengajuan dan persetujuan klaim yang cepat tanpa ribet</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-purple-100">
                                    <svg class="h-6 w-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.28.609.456 1.3.456 2.032 0 .735-.177 1.432-.457 2.041l1.547.773a1 1 0 01.54 1.06l-.74 4.435a1 1 0 01-.986.836H3a1 1 0 01-1-1V3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Layanan 24/7</h3>
                                <p class="mt-2 text-sm text-gray-600">Tim support kami siap membantu kapan saja</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-orange-100">
                                    <svg class="h-6 w-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.5 9a3 3 0 100-6 3 3 0 000 6zM4.5 11a6 6 0 0110.33-3.36L18 17h-2v-2h-2v2h-4a1 1 0 01-1-1v-1a1 1 0 011-1H8.5a4.5 4.5 0 00-4-4.5zM11.5 8a2 2 0 100-4 2 2 0 000 4z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm">Fleksibel & Terjangkau</h3>
                                <p class="mt-2 text-sm text-gray-600">Berbagai paket dengan harga yang kompetitif</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coverage Details -->
                <div class="bg-white rounded-lg border border-gray-200 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Detail Pertanggungan</h2>
                    <div class="space-y-4">
                        <div class="rounded-lg bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-gray-900">Jangkauan Pertanggungan</p>
                                    <p class="text-sm text-gray-600 mt-1">Maksimal perlindungan yang diberikan</p>
                                </div>
                                <p class="text-2xl font-bold text-blue-700">Rp{{ number_format((float) $product->coverage_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="rounded-lg bg-gradient-to-r from-green-50 to-green-100 border border-green-200 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-gray-900">Premi Dasar (Tahun)</p>
                                    <p class="text-sm text-gray-600 mt-1">Estimasi biaya per tahun</p>
                                </div>
                                <p class="text-2xl font-bold text-green-700">Rp{{ number_format((float) $product->base_premium, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features List -->
                <div class="bg-white rounded-lg border border-gray-200 p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Fitur & Manfaat</h2>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Perlindungan menyeluruh untuk kebutuhan kesehatan sehari-hari</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Proses klaim online yang simple dan cepat</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Jaringan rumah sakit dan klinik yang luas</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Cashless di semua jaringan mitra kami</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-gray-700">Fleksibilitas perpanjangan kapan saja tanpa ribet</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-6 space-y-4">
                    <!-- CTA Card -->
                    <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg p-6 text-white shadow-lg">
                        <h3 class="text-lg font-bold mb-2">Tertarik?</h3>
                        <p class="text-sm text-blue-100 mb-6">Ajukan polis sekarang dan dapatkan perlindungan yang Anda butuhkan.</p>
                        <a href="{{ route('nasabah.policies.create') }}" class="block w-full rounded-lg bg-white text-blue-600 px-6 py-3 text-center font-bold hover:bg-gray-50 transition mb-3">
                            Ajukan Polis Sekarang
                        </a>
                        <p class="text-xs text-blue-100 text-center">Proses mudah dan cepat</p>
                    </div>

                    <!-- Summary Card -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-sm font-bold text-gray-900 mb-4">Ringkasan Produk</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Kategori</p>
                                <p class="font-bold text-gray-900">{{ ucfirst($product->category) }}</p>
                            </div>
                            <div class="border-t border-gray-200 pt-4">
                                <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Coverage Maksimal</p>
                                <p class="font-bold text-lg text-blue-600">Rp{{ number_format((float) $product->coverage_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="border-t border-gray-200 pt-4">
                                <p class="text-xs font-semibold uppercase text-gray-500 mb-1">Premi Tahunan</p>
                                <p class="font-bold text-lg text-green-600">Rp{{ number_format((float) $product->base_premium, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Card -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="font-bold text-gray-900 mb-2">Ada Pertanyaan?</h3>
                        <p class="text-sm text-gray-600 mb-4">Tim kami siap membantu Anda memahami produk ini lebih baik.</p>
                        <button onclick="alert('Hubungi customer service: 62-81-6231-3123')" class="w-full rounded-lg bg-gray-100 text-gray-900 px-4 py-2 font-semibold hover:bg-gray-200 transition text-sm">
                            Hubungi Kami
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

