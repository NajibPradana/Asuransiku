@extends('frontend.layout-nasabah')

@section('nasabah-content')

<div class="container mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-slate-900">Produk Asuransi Kami</h1>
        <p class="mt-2 text-slate-600">Jelajahi berbagai produk asuransi yang sesuai dengan kebutuhan Anda</p>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($products as $product)
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm hover:shadow-lg transition">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">{{ $product->name }}</h3>
                        <p class="mt-2 text-sm text-slate-500 line-clamp-3">
                            {{ $product->description ?? 'Produk asuransi yang memberikan perlindungan menyeluruh.' }}
                        </p>
                    </div>
                </div>

                <div class="mt-6 grid gap-3">
                    <div class="flex items-center justify-between text-sm text-slate-600">
                        <span>Premi Dasar</span>
                        <span class="font-semibold text-slate-900">Rp{{ number_format((float) $product->base_premium, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-slate-600">
                        <span>Coverage</span>
                        <span class="font-semibold text-slate-900">Rp{{ number_format((float) $product->coverage_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <a href="{{ route('nasabah.products.show', $product->slug) }}" class="flex-1 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition text-center">Lihat Detail</a>
                    <a href="{{ route('nasabah.policies.create') }}" class="flex-1 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-800 transition text-center">Ajukan</a>
                </div>
            </div>
        @empty
            <div class="md:col-span-2 lg:col-span-3">
                <div class="rounded-3xl border border-slate-200 bg-white p-8 text-center">
                    <p class="text-slate-600">Belum ada produk yang tersedia saat ini.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection
