<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        @php
        $generalSettings = app(\App\Settings\GeneralSettings::class);
        $seoSettings = app(\App\Settings\SiteSeoSettings::class);
        $siteSettings = app(\App\Settings\SiteSettings::class);
        $siteSocialSettings = app(\App\Settings\SiteSocialSettings::class);
        $favicon = $generalSettings->site_favicon;
        $brandLogo = $generalSettings->brand_logo;
        $brandName = $siteSettings->name ?? $generalSettings->brand_name ?? config('app.name', 'Super Starter Kit');
        $tagLine = $siteSettings->tagline ?? "";

        $separator = $seoSettings->title_separator ?? '|';
        $page_type = $page_type ?? 'standard';

        $_main_variables = [
            '{site_name}' => $brandName,
            '{separator}' => $separator,
        ];

        switch ($page_type) {
            case 'blog_post':
                $titleFormat = $seoSettings->blog_title_format ?? '{post_title} {separator} {site_name}';
                $variables = array_merge($_main_variables, [
                    '{post_title}' => $postTitle ?? '',
                    '{post_category}' => $postCategory ?? '',
                    '{author_name}' => $authorName ?? '',
                    '{publish_date}' => isset($publishDate) ? $publishDate->format('Y') : '',
                ]);
                break;

            case 'product':
                $titleFormat = $seoSettings->product_title_format ?? '{product_name} {separator} {product_category} {separator} {site_name}';
                $variables = array_merge($_main_variables, [
                    '{product_name}' => $productName ?? '',
                    '{product_category}' => $productCategory ?? '',
                    '{product_brand}' => $productBrand ?? '',
                    '{price}' => $productPrice ?? '',
                ]);
                break;

            case 'category':
                $titleFormat = $seoSettings->category_title_format ?? '{category_name} {separator} {site_name}';
                $variables = array_merge($_main_variables, [
                    '{category_name}' => $categoryName ?? '',
                    '{parent_category}' => $parentCategory ?? '',
                    '{products_count}' => $productsCount ?? '',
                ]);
                break;

            case 'search':
                $titleFormat = $seoSettings->search_title_format ?? 'Search results for "{search_term}" {separator} {site_name}';
                $variables = array_merge($_main_variables, [
                    '{search_term}' => $searchTerm ?? '',
                    '{results_count}' => $resultsCount ?? '',
                ]);
                break;

            case 'author':
                $titleFormat = $seoSettings->author_title_format ?? 'Posts by {author_name} {separator} {site_name}';
                $variables = array_merge($_main_variables, [
                    '{author_name}' => $authorName ?? '',
                    '{post_count}' => $postCount ?? '',
                ]);
                break;

            default:
                $titleFormat = $seoSettings->meta_title_format ?? '{page_title} {separator} {site_name}';
                $variables = array_merge($_main_variables, [
                    '{page_title}' => $pageTitle ?? '',
                ]);
        }

        // Process the format by replacing placeholders
        $title = str_replace(
            array_keys($variables),
            array_values($variables),
            $titleFormat
        );

        // Clean up the title (remove double separators, eliminate leading/trailing separators)
        $title = preg_replace('/\s*' . preg_quote($separator) . '\s*' . preg_quote($separator) . '\s*/', " $separator ", $title);
        $title = trim($title);
        $title = trim($title, " $separator");

        // Fallback if empty
        if (empty(trim($title))) {
            $title = $brandName;
        }
        @endphp
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="application-name" content="{{ $brandName }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if (!$generalSettings->search_engine_indexing)
        <meta name="robots" content="noindex, nofollow">
        @endif

        <!-- Canonical URL -->
        <link rel="canonical" href="{{ $seoSettings->canonical_url ?? url()->current() }}" />
        
        <!-- SEO Meta Tags -->
        <meta name="description"
            content="{{ $siteSettings->description ?? '' }}">
        
        <title>{{ $title }} | {{ $tagLine }}</title>

        <!-- Favicon from settings -->
        <link rel="shortcut icon" href="{{ $favicon ? Storage::url($favicon) : 'https://placehold.co/50x50.jpeg?text=Favicon' }}"
            type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700&display=swap" rel="stylesheet" />

        <style>
            .nims-header-font {
                font-family: "Space Grotesk", "Helvetica Neue", Helvetica, sans-serif;
            }
        </style>

        @vite(['resources/css/app.css'])
    </head>

    @if(isset($siteSettings->is_maintenance) && $siteSettings->is_maintenance)
    <body class="antialiased">
        <div class="maintenance-mode">
            <div class="container">
                <h1>Site Under Maintenance</h1>
                <p>We're currently performing maintenance. Please check back soon.</p>
            </div>
        </div>
    </body>
    @else
    <body class="antialiased flex flex-col min-h-screen">
        @php
        $siteLogo = $siteSettings->logo ? Storage::url($siteSettings->logo) : 'https://placehold.co/240x50.jpeg?text=No%20Image';
        @endphp
        <main class="flex-1">
            <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-lg border-b border-slate-100 nims-header-font">
                <div class="container mx-auto px-6">
                    <div class="flex items-center justify-between h-16 md:h-20">
                        <!-- Logo -->
                        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                            <img src="{{ Storage::url($generalSettings->brand_logo) }}" 
                                 alt="NIMS Logo" 
                                 class="h-9 md:h-10 transition-transform duration-300 group-hover:scale-105" 
                                 style="height: {{ $generalSettings->brand_logoHeight ?? 50 }}px">
                        </a>

                        <!-- Navigation Links -->
                        <nav class="hidden lg:flex items-center gap-1">
                            <a href="{{ route('home') }}" class="px-4 py-2 rounded-full text-slate-700 hover:text-slate-900 hover:bg-slate-100 font-semibold transition-all duration-300 text-sm">
                                Beranda
                            </a>
                            <a href="#layanan" class="px-4 py-2 rounded-full text-slate-700 hover:text-slate-900 hover:bg-slate-100 font-semibold transition-all duration-300 text-sm">
                                Layanan
                            </a>
                            <a href="#tentang" class="px-4 py-2 rounded-full text-slate-700 hover:text-slate-900 hover:bg-slate-100 font-semibold transition-all duration-300 text-sm">
                                Tentang
                            </a>
                            <a href="#kontak" class="px-4 py-2 rounded-full text-slate-700 hover:text-slate-900 hover:bg-slate-100 font-semibold transition-all duration-300 text-sm">
                                Kontak
                            </a>
                        </nav>

                        <!-- Auth Buttons -->
                        <div class="flex items-center gap-3">
                            <a href="/nasabah" 
                                class="group flex items-center gap-2 px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-full transition-all duration-300 shadow-lg shadow-slate-900/20 hover:shadow-slate-900/30 hover:-translate-y-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4.5 h-4.5 transition-transform duration-300 group-hover:scale-110">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <span class="text-sm">Portal Nasabah</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            @yield('content')

        </main>

        <footer class="bg-slate-900 text-white nims-header-font">
            <div class="container mx-auto px-6 py-12">
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Brand Section -->
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <img src="{{ Storage::url($generalSettings->brand_logo_square) }}" 
                                 alt="NIMS Logo" 
                                 class="h-10 w-10 object-contain transition-transform duration-300">
                            <div>
                                <div class="text-xl font-bold">NIMS</div>
                                <div class="text-xs text-slate-400">Nusantara Insurance Management System</div>
                            </div>
                        </div>
                        <p class="text-sm text-slate-300 leading-relaxed">
                            Managing Protection with Precision - Sistem manajemen asuransi digital yang terpercaya, efisien, dan terintegrasi.
                        </p>
                    </div>
                    
                    <!-- Company Info -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Hubungi Kami</h4>
                        <div class="space-y-3 text-sm text-slate-300">
                            <div class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-amber-400 flex-shrink-0 mt-0.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                </svg>
                                <span>{{ $siteSettings->company_phone ?? '(021) 1234-5678' }}</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-amber-400 flex-shrink-0 mt-0.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                                <span>{{ $siteSettings->company_email ?? 'info@nusantara-insurance.co.id' }}</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-amber-400 flex-shrink-0 mt-0.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                <span>{{ $siteSettings->company_address ?? 'Jakarta Pusat, Indonesia' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Ikuti Kami</h4>
                        <div class="flex gap-3">
                            @if($siteSocialSettings->facebook_url)
                            <a href="{{ $siteSocialSettings->facebook_url }}" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                                <svg fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                                </svg>
                            </a>
                            @endif
                            @if($siteSocialSettings->twitter_url)
                            <a href="{{ $siteSocialSettings->twitter_url }}" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                                <svg fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                                    <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
                                </svg>
                            </a>
                            @endif
                            @if($siteSocialSettings->instagram_url)
                            <a href="{{ $siteSocialSettings->instagram_url }}" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                                <svg fill="currentColor" class="w-5 h-5" viewBox="0 0 30 30">
                                    <path d="M 9.9980469 3 C 6.1390469 3 3 6.1419531 3 10.001953 L 3 20.001953 C 3 23.860953 6.1419531 27 10.001953 27 L 20.001953 27 C 23.860953 27 27 23.858047 27 19.998047 L 27 9.9980469 C 27 6.1390469 23.858047 3 19.998047 3 L 9.9980469 3 z M 22 7 C 22.552 7 23 7.448 23 8 C 23 8.552 22.552 9 22 9 C 21.448 9 21 8.552 21 8 C 21 7.448 21.448 7 22 7 z M 15 9 C 18.309 9 21 11.691 21 15 C 21 18.309 18.309 21 15 21 C 11.691 21 9 18.309 9 15 C 9 11.691 11.691 9 15 9 z M 15 11 A 4 4 0 0 0 11 15 A 4 4 0 0 0 15 19 A 4 4 0 0 0 19 15 A 4 4 0 0 0 15 11 z"></path>
                                </svg>
                            </a>
                            @endif
                            @if($siteSocialSettings->linkedin_url)
                            <a href="{{ $siteSocialSettings->linkedin_url }}" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
                                <svg fill="currentColor" class="w-5 h-5" viewBox="0 0 50 50">
                                    <path d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M17,20v19h-6V20H17z M11,14.47c0-1.4,1.2-2.47,3-2.47s2.93,1.07,3,2.47c0,1.4-1.12,2.53-3,2.53C12.2,17,11,15.87,11,14.47z M39,39h-6c0,0,0-9.26,0-10 c0-2-1-4-3.5-4.04h-0.08C27,24.96,26,27.02,26,29c0,0.91,0,10,0,10h-6V20h6v2.56c0,0,1.93-2.56,5.81-2.56 c3.97,0,7.19,2.73,7.19,8.26V39z"></path>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-slate-800 mt-8 pt-6 text-center">
                    <p class="text-sm text-slate-400">
                        © {{ date('Y') }} NIMS - Nusantara Insurance Management System. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
        @vite(['resources/js/app.js'])
    </body>
    @endif
</html>
