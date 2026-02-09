@extends('frontend.layout-nasabah')

@section('nasabah-content')
@php
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

        <div class="mb-6 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4">
            <p class="text-sm font-semibold text-slate-900">Ringkasan Profil Nasabah</p>
            <div class="mt-3 grid gap-3 md:grid-cols-2 text-sm text-slate-600">
                <div>
                    <p class="text-xs font-semibold uppercase text-slate-500">Nama</p>
                    <p class="text-slate-900">{{ trim(($user->firstname ?? '') . ' ' . ($user->lastname ?? '')) }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase text-slate-500">NIK</p>
                    <p class="text-slate-900">{{ $profile?->nik }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase text-slate-500">Pekerjaan</p>
                    <p class="text-slate-900">{{ $profile?->occupation }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase text-slate-500">Alamat</p>
                    <p class="text-slate-900">{{ $profile?->address }}</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('nasabah.policies.store') }}" id="policyForm">
            @csrf

            <input type="hidden" name="user_id" value="{{ $user?->id }}">

            <div class="grid gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Kategori Produk <span class="text-red-500">*</span></label>
                    <select name="category" id="category" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm" placeholder="Pilih kategori produk">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                    @error('category')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Produk <span class="text-red-500">*</span></label>
                    <select name="product_id" id="product_id" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm" placeholder="Pilih produk">
                        <option value="">-- Pilih Kategori terlebih dahulu --</option>
                    </select>
                    @error('product_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" id="start_date" required class="mt-1 block w-full rounded-md border-gray-200" value="{{ old('start_date') }}" placeholder="Pilih tanggal mulai">
                        @error('start_date')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tanggal Berakhir <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" id="end_date" required class="mt-1 block w-full rounded-md border-gray-200 bg-slate-50 text-slate-500" value="{{ old('end_date') }}" placeholder="Otomatis 1 tahun" readonly>
                        @error('end_date')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <input type="hidden" name="premium_paid" id="premium_paid" value="{{ old('premium_paid') }}">

                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                    Premi akan otomatis mengikuti standar produk terpilih. Status akan diset menjadi <strong>pending</strong> menunggu approval dari manager.
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
                option.dataset.basePremium = product.base_premium;
                productSelect.appendChild(option);
            });
        }
    });

    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const premiumInput = document.getElementById('premium_paid');

        if (selectedOption && selectedOption.dataset.basePremium) {
            premiumInput.value = selectedOption.dataset.basePremium;
        } else {
            premiumInput.value = '';
        }
    });

    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    function setEndDateFromStart() {
        if (!startDateInput.value) {
            endDateInput.value = '';
            return;
        }

        const start = new Date(startDateInput.value);
        const end = new Date(start);
        end.setFullYear(end.getFullYear() + 1);

        const iso = end.toISOString().split('T')[0];
        endDateInput.value = iso;
    }

    startDateInput.addEventListener('change', setEndDateFromStart);
    document.addEventListener('DOMContentLoaded', setEndDateFromStart);

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
