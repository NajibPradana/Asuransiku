@extends('frontend.layout-guest')

@section('content')
@include('components.nasabah-navbar')

<div class="min-h-screen bg-slate-50">
    @yield('nasabah-content')
</div>
@endsection
