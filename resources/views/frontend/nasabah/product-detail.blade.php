@extends('frontend.layout-nasabah')

@section('nasabah-content')
<div class="container mx-auto px-6 py-12">
    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">{{ $product->name }}</h1>
            <p class="mt-2 text-slate-600">Detail produk asuransi dan manfaat perlindungan</p>
        </div>
        <a href="{{ route('nasabah.products') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Kembali ke Produk</a>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 border border-blue-200">{{ ucfirst($product->category) }}</span>
                </div>

                <p class="mt-6 text-slate-700 leading-relaxed">
                    {{ $product->description ?? 'Produk asuransi yang memberikan perlindungan menyeluruh.' }}
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 px-4 py-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Premi Dasar</p>
                        <p class="mt-2 text-lg font-semibold text-slate-900">Rp{{ number_format((float) $product->base_premium, 0, ',', '.') }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 px-4 py-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Coverage</p>
                        <p class="mt-2 text-lg font-semibold text-slate-900">Rp{{ number_format((float) $product->coverage_amount, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Ajukan Polis</h2>
                <p class="mt-2 text-sm text-slate-600">Mulai perlindungan dengan mengajukan polis sesuai kebutuhan Anda.</p>
                <a href="{{ route('nasabah.policies.create', ['product_id' => $product->id]) }}" class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 transition">Ajukan Polis</a>
                <div class="mt-4 rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3 text-xs text-slate-600">
                    Premi akan mengikuti standar produk terpilih saat pengajuan polis.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
