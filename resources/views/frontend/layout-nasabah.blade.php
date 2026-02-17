@extends('frontend.layout-guest')

@section('content')
@include('components.nasabah-navbar')

<div class="min-h-screen bg-slate-50">
    <div class="container mx-auto px-6 pt-6">
        @include('components.nasabah-alerts')
    </div>
    @yield('nasabah-content')
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            Swal.fire({
                title: 'Tidak Bisa Diproses',
                text: '{{ session('error') }}',
                icon: 'warning',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#0f172a',
            });
        @endif
    });
</script>
@endpush
@endsection
