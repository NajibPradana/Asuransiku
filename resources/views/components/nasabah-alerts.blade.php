@if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-300 bg-red-50 p-4">
        <p class="font-semibold text-red-900">Terjadi Kesalahan:</p>
        <ul class="mt-2 list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li class="text-sm text-red-800">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="mb-4 rounded-lg border border-emerald-300 bg-emerald-50 p-4">
        <p class="text-sm font-semibold text-emerald-900">{{ session('success') }}</p>
    </div>
@endif

@if (session('warning'))
    <div class="mb-4 rounded-lg border border-amber-300 bg-amber-50 p-4">
        <p class="text-sm font-semibold text-amber-900">{{ session('warning') }}</p>
    </div>
@endif

@if (session('info'))
    <div class="mb-4 rounded-lg border border-blue-300 bg-blue-50 p-4">
        <p class="text-sm font-semibold text-blue-900">{{ session('info') }}</p>
    </div>
@endif
