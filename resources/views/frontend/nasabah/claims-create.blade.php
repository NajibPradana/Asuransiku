@extends('frontend.layout-nasabah')

@section('nasabah-content')
@php
    $policies = $policies ?? collect();
    $selectedPolicy = $selectedPolicy ?? null;
    $hasPreselectedPolicy = $selectedPolicy !== null;
@endphp

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mx-auto px-6 py-12">
    <div class="max-w-3xl mx-auto bg-white rounded-2xl p-6 shadow">
        <h1 class="text-2xl font-semibold mb-2">Ajukan Klaim Asuransi</h1>
        <p class="text-sm text-slate-600 mb-6">
            @if($hasPreselectedPolicy)
                Isi detail klaim untuk polis yang sudah Anda pilih.
            @else
                Pilih polis aktif dan lengkapi detail klaim dengan dokumen pendukung.
            @endif
        </p>

        @if(!$hasPreselectedPolicy)
        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 mb-6">
            <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                <span id="wizardStepLabel1" class="text-slate-900">1. Pilih Polis</span>
                <span id="wizardStepLabel2">2. Detail & Dokumen</span>
            </div>
            <div class="mt-3 h-2 w-full rounded-full bg-white">
                <div id="wizardProgress" class="h-2 rounded-full bg-slate-900 transition-all" style="width: 50%;"></div>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('nasabah.claims.store') }}" enctype="multipart/form-data" id="claimForm" class="mt-6">
            @csrf

            @if(!$hasPreselectedPolicy)
            <div id="claimStep1" class="grid gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700">Polis Aktif <span class="text-red-500">*</span></label>
                    <select name="policy_id" id="policy_id" required class="mt-1 block w-full rounded-md border-gray-200 shadow-sm">
                        <option value="">-- Pilih Polis --</option>
                        @foreach($policies as $policy)
                            <option value="{{ $policy->id }}" data-product="{{ $policy->product?->name }}" data-category="{{ $policy->product?->category }}" data-coverage="{{ $policy->product?->coverage_amount }}" data-policy-number="{{ $policy->policy_number }}">
                                {{ $policy->policy_number }} — {{ $policy->product?->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('policy_id')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div id="policySummary" class="hidden rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600">
                    <div class="grid gap-3 md:grid-cols-3">
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Produk</p>
                            <p class="text-slate-900" id="summaryProduct">-</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Kategori</p>
                            <p class="text-slate-900" id="summaryCategory">-</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Coverage</p>
                            <p class="text-slate-900" id="summaryCoverage">-</p>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="button" id="nextStepBtn" class="w-full rounded-full bg-slate-900 px-4 py-3 text-sm font-semibold text-white disabled:cursor-not-allowed disabled:opacity-60" disabled>Lanjutkan</button>
                </div>
            </div>

            <div id="claimStep2" class="hidden grid gap-4">
                <div id="policyPreview" class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-700">
                    <p class="text-xs font-semibold uppercase text-slate-500">Preview Polis Terpilih</p>
                    <div class="mt-3 grid gap-3 md:grid-cols-4">
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Nomor Polis</p>
                            <p class="text-slate-900" id="previewPolicyNumber">-</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Produk</p>
                            <p class="text-slate-900" id="previewProduct">-</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Kategori</p>
                            <p class="text-slate-900" id="previewCategory">-</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase text-slate-500">Coverage</p>
                            <p class="text-slate-900" id="previewCoverage">-</p>
                        </div>
                    </div>
                </div>
            @else
            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-sm text-slate-700 mb-6">
                <p class="text-xs font-semibold uppercase text-slate-500 mb-3">Polis Terpilih</p>
                <div class="grid gap-3 md:grid-cols-4">
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Nomor Polis</p>
                        <p class="text-slate-900 font-medium">{{ $selectedPolicy->policy_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Produk</p>
                        <p class="text-slate-900 font-medium">{{ $selectedPolicy->product?->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Kategori</p>
                        <p class="text-slate-900 font-medium">{{ strtoupper($selectedPolicy->product?->category) }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase text-slate-500">Coverage</p>
                        <p class="text-slate-900 font-medium">Rp{{ number_format($selectedPolicy->product?->coverage_amount, 0, ',', '.') }}</p>
                    </div>
                </div>
                <input type="hidden" name="policy_id" value="{{ $selectedPolicy->id }}">
                <p class="mt-3 text-xs text-slate-500">
                    <a href="{{ route('nasabah.claims.create') }}" class="text-slate-700 font-semibold hover:underline">Ganti polis</a>
                </p>
            </div>

            <div class="grid gap-4">
            @endif

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Tanggal Kejadian <span class="text-red-500">*</span></label>
                        <input type="date" name="incident_date" required class="mt-1 block w-full rounded-md border-gray-200" placeholder="Pilih tanggal kejadian">
                        @error('incident_date')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Nominal Klaim (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" name="amount_claimed" min="0" step="0.01" required class="mt-1 block w-full rounded-md border-gray-200" placeholder="Contoh: 2500000">
                        <p class="mt-2 text-xs text-slate-500" id="claimLimit">
                            @if($hasPreselectedPolicy)
                                Maksimal: Rp{{ number_format($selectedPolicy->product?->coverage_amount, 0, ',', '.') }}
                            @else
                                Maksimal sesuai coverage polis terpilih.
                            @endif
                        </p>
                        @error('amount_claimed')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Deskripsi Kejadian <span class="text-red-500">*</span></label>
                    <textarea name="description" rows="4" required class="mt-1 block w-full rounded-md border-gray-200" placeholder="Jelaskan kronologi kejadian secara singkat"></textarea>
                    @error('description')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Dokumen Pendukung <span class="text-red-500">*</span></label>
                    <div id="dropzone" class="mt-2 rounded-2xl border-2 border-dashed border-slate-200 bg-white px-4 py-5 text-center text-sm text-slate-600">
                        <input type="file" id="evidenceFiles" name="evidence_files[]" multiple required class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                        <p class="font-semibold text-slate-900">Drag & drop file di sini</p>
                        <p class="mt-1 text-xs text-slate-500">atau klik tombol di bawah untuk memilih file</p>
                        <button type="button" id="browseFiles" class="mt-3 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-slate-700">Pilih File</button>
                        <p class="mt-2 text-xs text-slate-500">Format: PDF/JPG/PNG, maksimal 5MB per file.</p>
                        <div id="fileList" class="mt-3 text-xs text-slate-700"></div>
                    </div>
                    @error('evidence_files')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    @error('evidence_files.*')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                    Status klaim akan berubah menjadi <strong>review</strong> setelah dokumen berhasil diverifikasi sistem.
                </div>

                <div class="pt-2 flex flex-col gap-3 sm:flex-row">
                    @if(!$hasPreselectedPolicy)
                    <button type="button" id="backStepBtn" class="w-full rounded-full border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700">Kembali</button>
                    @endif
                    <button type="submit" class="w-full rounded-full bg-slate-900 px-4 py-3 text-sm font-semibold text-white">Ajukan Klaim</button>
                </div>
            </div>
            @if(!$hasPreselectedPolicy)
            </div>
            @endif
        </form>
    </div>
</div>

<script>
    const preselectedPolicy = @json($selectedPolicy);
    const hasPreselectedPolicy = preselectedPolicy !== null;

    // Only setup wizard if no policy is pre-selected
    if (!hasPreselectedPolicy) {
        const policySelect = document.getElementById('policy_id');
        const summaryCard = document.getElementById('policySummary');
        const summaryProduct = document.getElementById('summaryProduct');
        const summaryCategory = document.getElementById('summaryCategory');
        const summaryCoverage = document.getElementById('summaryCoverage');
        const previewPolicyNumber = document.getElementById('previewPolicyNumber');
        const previewProduct = document.getElementById('previewProduct');
        const previewCategory = document.getElementById('previewCategory');
        const previewCoverage = document.getElementById('previewCoverage');
        const claimLimit = document.getElementById('claimLimit');
        const nextStepBtn = document.getElementById('nextStepBtn');
        const backStepBtn = document.getElementById('backStepBtn');
        const step1 = document.getElementById('claimStep1');
        const step2 = document.getElementById('claimStep2');
        const wizardProgress = document.getElementById('wizardProgress');
        const wizardStepLabel1 = document.getElementById('wizardStepLabel1');
        const wizardStepLabel2 = document.getElementById('wizardStepLabel2');

        const updateStepState = (currentStep) => {
            const isStepTwo = currentStep === 2;
            step1.classList.toggle('hidden', isStepTwo);
            step2.classList.toggle('hidden', !isStepTwo);
            wizardProgress.style.width = isStepTwo ? '100%' : '50%';
            wizardStepLabel1.classList.toggle('text-slate-900', !isStepTwo);
            wizardStepLabel2.classList.toggle('text-slate-900', isStepTwo);
        };

        const updateSummary = () => {
            const option = policySelect.options[policySelect.selectedIndex];
            const hasValue = option && option.value;

            nextStepBtn.disabled = !hasValue;

            if (!hasValue) {
                summaryCard.classList.add('hidden');
                return;
            }

            const coverageText = option.dataset.coverage
                ? `Rp${new Intl.NumberFormat('id-ID').format(option.dataset.coverage)}`
                : '-';

            summaryProduct.textContent = option.dataset.product || '-';
            summaryCategory.textContent = option.dataset.category ? option.dataset.category.toUpperCase() : '-';
            summaryCoverage.textContent = coverageText;
            previewPolicyNumber.textContent = option.dataset.policyNumber || '-';
            previewProduct.textContent = option.dataset.product || '-';
            previewCategory.textContent = option.dataset.category ? option.dataset.category.toUpperCase() : '-';
            previewCoverage.textContent = coverageText;
            claimLimit.textContent = option.dataset.coverage
                ? `Maksimal klaim mengikuti coverage polis: ${coverageText}.`
                : 'Maksimal sesuai coverage polis terpilih.';

            summaryCard.classList.remove('hidden');
        };

        policySelect.addEventListener('change', updateSummary);
        nextStepBtn.addEventListener('click', () => updateStepState(2));
        backStepBtn.addEventListener('click', () => updateStepState(1));

        updateSummary();
        updateStepState(1);
    }

    // File handling (same for both cases)
    const fileInput = document.getElementById('evidenceFiles');
    const browseFiles = document.getElementById('browseFiles');
    const dropzone = document.getElementById('dropzone');
    const fileList = document.getElementById('fileList');

    const renderFileList = (files) => {
        if (!files || files.length === 0) {
            fileList.textContent = '';
            return;
        }
        fileList.innerHTML = Array.from(files)
            .map((file) => `<div>${file.name}</div>`)
            .join('');
    };

    browseFiles.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', () => {
        renderFileList(fileInput.files);
    });

    dropzone.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropzone.classList.add('border-slate-400', 'bg-slate-50');
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.classList.remove('border-slate-400', 'bg-slate-50');
    });

    dropzone.addEventListener('drop', (event) => {
        event.preventDefault();
        dropzone.classList.remove('border-slate-400', 'bg-slate-50');

        const droppedFiles = event.dataTransfer.files;
        if (!droppedFiles || droppedFiles.length === 0) {
            return;
        }

        const dataTransfer = new DataTransfer();
        Array.from(droppedFiles).forEach((file) => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
        renderFileList(fileInput.files);
    });

    document.addEventListener('DOMContentLoaded', function() {
        @if (session('show_sweet_alert') && session('success'))
            Swal.fire({
                title: 'Klaim Dikirim!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'Lihat Klaim',
                confirmButtonColor: '#0f172a',
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('nasabah.claims') }}';
                }
            });
        @endif
    });
</script>
@endsection
