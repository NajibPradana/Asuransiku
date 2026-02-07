<!-- Nasabah Navbar -->
<nav class="sticky top-0 z-50 bg-white shadow-md">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo/Brand -->
            <div>
                <a href="{{ route('nasabah.dashboard') }}" class="text-xl font-semibold text-slate-900">
                    Portal Nasabah
                </a>
            </div>

            <!-- Menu Items -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('nasabah.dashboard') }}" class="text-slate-700 hover:text-slate-900 font-medium transition {{ request()->routeIs('nasabah.dashboard') ? 'text-slate-900 border-b-2 border-slate-900' : '' }}">
                    Home
                </a>
                <a href="{{ route('nasabah.products') }}" class="text-slate-700 hover:text-slate-900 font-medium transition {{ request()->routeIs('nasabah.products') ? 'text-slate-900 border-b-2 border-slate-900' : '' }}">
                    Produk
                </a>
                <a href="{{ route('nasabah.policies') }}" class="text-slate-700 hover:text-slate-900 font-medium transition {{ request()->routeIs('nasabah.policies*') ? 'text-slate-900 border-b-2 border-slate-900' : '' }}">
                    Polis
                </a>
                <a href="{{ route('nasabah.claims') }}" class="text-slate-700 hover:text-slate-900 font-medium transition {{ request()->routeIs('nasabah.claims*') ? 'text-slate-900 border-b-2 border-slate-900' : '' }}">
                    Klaim
                </a>
                <a href="{{ route('nasabah.profile') }}" class="text-slate-700 hover:text-slate-900 font-medium transition {{ request()->routeIs('nasabah.profile') ? 'text-slate-900 border-b-2 border-slate-900' : '' }}">
                    Profil
                </a>
            </div>

            <!-- Profile & Logout -->
            <div class="flex items-center gap-4">
                <div class="hidden md:block text-sm text-slate-600">
                    {{ auth('nasabah')->user()->firstname ?? 'Nasabah' }}
                </div>
                <form method="POST" action="{{ route('nasabah.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition">
                        Logout
                    </button>
                </form>
            </div>

            <!-- Mobile Menu Button (optional) -->
            <div class="md:hidden flex items-center gap-2">
                <details class="dropdown">
                    <summary class="btn btn-ghost">☰</summary>
                    <ul class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('nasabah.dashboard') }}">Home</a></li>
                        <li><a href="{{ route('nasabah.products') }}">Produk</a></li>
                        <li><a href="{{ route('nasabah.policies') }}">Polis</a></li>
                        <li><a href="{{ route('nasabah.claims') }}">Klaim</a></li>
                        <li><a href="{{ route('nasabah.profile') }}">Profil</a></li>
                        <li><form method="POST" action="{{ route('nasabah.logout') }}">@csrf<button type="submit">Logout</button></form></li>
                    </ul>
                </details>
            </div>
        </div>
    </div>
</nav>
