<!-- Nasabah Navbar -->
<style>
    .nims-navbar-font {
        font-family: "Space Grotesk", "Helvetica Neue", Helvetica, sans-serif;
    }
</style>

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700&display=swap" rel="stylesheet" />

<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md shadow-md border-b border-slate-200/50 nims-navbar-font">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo/Brand -->
            <div>
                <a href="{{ route('nasabah.dashboard') }}" class="flex items-center gap-2">
                    <img src="{{ Storage::url($generalSettings->brand_logo_square) }}" 
                         alt="NIMS Logo" 
                         class="h-8 w-8 object-contain">
                    <div>
                        <div class="text-lg font-bold text-slate-900">NIMS</div>
                        <div class="text-xs text-slate-500 -mt-1">Portal Nasabah</div>
                    </div>
                </a>
            </div>

            <!-- Menu Items -->
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('nasabah.dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900 transition {{ request()->routeIs('nasabah.dashboard') ? 'text-slate-900' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('nasabah.products') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900 transition {{ request()->routeIs('nasabah.products') ? 'text-slate-900' : '' }}">
                    Produk
                </a>
                <a href="{{ route('nasabah.policies') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900 transition {{ request()->routeIs('nasabah.policies*') ? 'text-slate-900' : '' }}">
                    Polis Saya
                </a>
                <a href="{{ route('nasabah.claims') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900 transition {{ request()->routeIs('nasabah.claims*') ? 'text-slate-900' : '' }}">
                    Klaim
                </a>
                <a href="{{ route('nasabah.profile') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-900 transition {{ request()->routeIs('nasabah.profile') ? 'text-slate-900' : '' }}">
                    Profil
                </a>
            </div>

            <!-- Profile & Logout -->
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-2 text-sm text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-semibold">{{ auth('nasabah')->user()->firstname ?? 'Nasabah' }}</span>
                </div>
                <form method="POST" action="{{ route('nasabah.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-800 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center gap-2">
                <button onclick="toggleMobileMenu()" class="p-2 text-slate-700 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden mt-4 pb-4 space-y-2">
            <a href="{{ route('nasabah.dashboard') }}" class="block px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 rounded-lg {{ request()->routeIs('nasabah.dashboard') ? 'bg-slate-100 text-slate-900' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('nasabah.products') }}" class="block px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 rounded-lg {{ request()->routeIs('nasabah.products') ? 'bg-slate-100 text-slate-900' : '' }}">
                Produk
            </a>
            <a href="{{ route('nasabah.policies') }}" class="block px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 rounded-lg {{ request()->routeIs('nasabah.policies*') ? 'bg-slate-100 text-slate-900' : '' }}">
                Polis Saya
            </a>
            <a href="{{ route('nasabah.claims') }}" class="block px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 rounded-lg {{ request()->routeIs('nasabah.claims*') ? 'bg-slate-100 text-slate-900' : '' }}">
                Klaim
            </a>
            <a href="{{ route('nasabah.profile') }}" class="block px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 rounded-lg {{ request()->routeIs('nasabah.profile') ? 'bg-slate-100 text-slate-900' : '' }}">
                Profil
            </a>
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    }
</script>
