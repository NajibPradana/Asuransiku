@extends('frontend.layout-nasabah')

@section('nasabah-content')
@php
    $user = auth('nasabah')->user();
    $categories = [];
    foreach($products ?? [] as $product) {
        if (!in_array($product->category, $categories)) {
            $categories[] = $product->category;
        }
    }
@endphp

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mx-auto px-6 py-12">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl p-6 shadow">
        <h1 class="text-2xl font-semibold mb-4">Ajukan Polis Baru</h1>

        <form method="POST" action="{{ route('nasabah.policies.store') }}" id="policyForm">
            @csrf

            <input type="hidden" name="user_id" value="{{ $user?->id }}">

            <div class="grid gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Kategori Produk <span class="text-red-500">*</span></label>
                    <select name="category" id="category" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                    @error('category')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Produk <span class="text-red-500">*</span></label>
                    <select name="product_id" id="product_id" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm">
                        <option value="">-- Pilih Kategori terlebih dahulu --</option>
                    </select>
                    @error('product_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" required class="mt-1 block w-full rounded-md border-gray-200" value="{{ old('start_date') }}">
                        @error('start_date')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tanggal Berakhir <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" required class="mt-1 block w-full rounded-md border-gray-200" value="{{ old('end_date') }}">
                        @error('end_date')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Premi Dibayar (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="premium_paid" step="0.01" min="0" required class="mt-1 block w-full rounded-md border-gray-200" value="{{ old('premium_paid') }}">
                    @error('premium_paid')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Nomor Polis (otomatis)</label>
                    <input type="text" disabled class="mt-1 block w-full rounded-md border-gray-200 bg-slate-50 text-slate-500" value="Nomor akan digenerate setelah pengajuan">
                </div>

                <div>
                    <p class="text-sm text-slate-600">Status akan diset menjadi <strong>pending</strong> menunggu approval dari manager.</p>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full rounded-full bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Ajukan Polis</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const productsData = @json($products ?? []);
    const categorySelect = document.getElementById('category');
    const productSelect = document.getElementById('product_id');

    categorySelect.addEventListener('change', function() {
        const selectedCategory = this.value;
        productSelect.innerHTML = '<option value="">-- Pilih Produk --</option>';

        if (selectedCategory) {
            const filteredProducts = productsData.filter(product => product.category === selectedCategory && product.is_active);
            filteredProducts.forEach(product => {
                const option = document.createElement('option');
                option.value = product.id;
                option.textContent = `${product.name} — Rp${new Intl.NumberFormat('id-ID').format(product.base_premium)}`;
                productSelect.appendChild(option);
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        @if (session('show_sweet_alert') && session('success'))
            Swal.fire({
                title: 'Pengajuan Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'Kembali ke Dashboard',
                confirmButtonColor: '#0f172a',
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('nasabah.dashboard') }}';
                }
            });
        @endif
    });
</script>

@endsection
