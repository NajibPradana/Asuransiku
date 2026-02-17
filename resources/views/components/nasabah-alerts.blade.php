@if (session('success'))
    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
        {{ session('success') }}
    </div>
@endif

@if (session('info'))
    <div class="mb-6 rounded-2xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
        {{ session('info') }}
    </div>
@endif

@if (session('warning'))
    <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
        {{ session('warning') }}
    </div>
@endif
