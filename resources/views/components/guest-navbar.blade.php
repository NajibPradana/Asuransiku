<!-- Guest Navbar -->
<nav class="sticky top-0 z-50 bg-white shadow-md">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo/Brand -->
            <div>
                <a href="{{ route('home') }}" class="text-xl font-semibold text-slate-900">
                    {{ $brandName ?? 'Portal Asuransi' }}
                </a>
            </div>

            <!-- Menu Items -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-slate-700 hover:text-slate-900 font-medium transition">
                    Beranda
                </a>
                <a href="#layanan" class="text-slate-700 hover:text-slate-900 font-medium transition">
                    Layanan
                </a>
                <a href="#tentang" class="text-slate-700 hover:text-slate-900 font-medium transition">
                    Tentang
                </a>
                <a href="#kontak" class="text-slate-700 hover:text-slate-900 font-medium transition">
                    Kontak
                </a>
            </div>

            <!-- Login Button -->
            <div class="flex items-center gap-4">
                <a href="{{ route('nasabah.login') }}" 
                   class="rounded-lg bg-sky-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-sky-700 transition shadow-sm">
                    Login Nasabah
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <details class="dropdown">
                    <summary class="btn btn-ghost text-slate-700">☰</summary>
                    <ul class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="#layanan">Layanan</a></li>
                        <li><a href="#tentang">Tentang</a></li>
                        <li><a href="#kontak">Kontak</a></li>
                        <li><a href="{{ route('nasabah.login') }}" class="text-sky-600 font-semibold">Login Nasabah</a></li>
                    </ul>
                </details>
            </div>
        </div>
    </div>
</nav>

