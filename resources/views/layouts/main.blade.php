<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Ayo Behacaar')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', $settings->description ?? '')">
    <meta name="keywords" content="@yield('meta_keywords', 'ayobehacaar, belajar, edukasi, kalimantan, dayak tunjung')">
    <meta name="author" content="@yield('meta_author', 'Ayo Behacaar')">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', $settings->site_name ?? 'Ayo Behacaar')">
    <meta property="og:description" content="@yield('meta_description', $settings->description ?? '')">
    <meta property="og:image" content="@yield('meta_image', asset('assets/img/ayobehacaar.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $settings->site_name ?? 'Ayo Behacaar' }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $settings->site_name ?? 'Ayo Behacaar')">
    <meta name="twitter:description" content="@yield('meta_description', $settings->description ?? '')">
    <meta name="twitter:image" content="@yield('meta_image', asset('assets/img/ayobehacaar.png'))">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@500&family=Inter:wght@100..900&family=Poppins:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Early theme detection script -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>

<body class="font-sans antialiased bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 selection:bg-blue-600 selection:text-white transition-colors duration-300">

    @livewire('layout.navbar')

    <main x-data>
        @yield('content')
    </main>

    <!-- Footer Start -->
    <footer class="bg-slate-100 dark:bg-slate-900/60 pt-10 pb-6 px-4 md:px-12 relative mt-auto border-t border-slate-200 dark:border-slate-800 transition-colors duration-300">
        <div class="container mx-auto flex flex-col lg:flex-row justify-between items-center gap-6 lg:gap-8 mb-8">
            <div class="text-center lg:text-left">
                <a href="{{ route('home') }}"
                    class="text-2xl font-semibold text-slate-900 dark:text-white text-decoration-none font-brand">
                    @if(strtolower($settings->site_name) === 'ayo behacaar')
                        ayo<span class="text-blue-600">behacaar</span>
                    @else
                        {{ $settings->site_name }}
                    @endif
                </a>
                <p class="text-slate-500 dark:text-slate-400 mt-3 text-sm md:text-base leading-relaxed">
                    {{ $settings->tagline }}
                </p>
            </div>
            <div class="flex flex-col items-center lg:items-end w-full lg:w-auto mt-2 lg:mt-0">
                <div class="flex flex-wrap justify-center lg:justify-end gap-5 md:gap-8">
                    <a href="#" class="text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white font-medium transition">Privacy
                        Policy</a>
                    <a href="#" class="text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white font-medium transition">Terms of
                        Service</a>
                    <button onclick="document.getElementById('contactModal').classList.remove('hidden')"
                        class="text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white font-medium transition cursor-pointer bg-transparent border-none p-0 m-0">Contact</button>
                </div>
            </div>
        </div>

        <!-- Centered Copyright -->
        <div class="container mx-auto text-center border-t border-slate-200 dark:border-slate-800 pt-6">
            <p class="text-slate-400 dark:text-slate-500 text-xs md:text-sm">
                &copy; 2023 Ayo Behacaar. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Contact Modal -->
    <div id="contactModal"
        class="hidden fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <!-- Overlay click to close -->
        <div class="absolute inset-0" onclick="document.getElementById('contactModal').classList.add('hidden')"></div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-transparent dark:border-slate-700 shadow-xl w-full max-w-sm p-6 relative z-10" data-aos="zoom-in"
            data-aos-duration="300">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Hubungi Kami</h3>
                <button onclick="document.getElementById('contactModal').classList.add('hidden')"
                    class="text-slate-400 hover:text-red-500 dark:hover:text-red-400 transition text-2xl leading-none">&times;</button>
            </div>
            <div class="text-center py-6">
                <div
                    class="w-16 h-16 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                    <i class="bi bi-envelope-fill"></i>
                </div>
                <p class="text-slate-600 dark:text-slate-400 mb-1 text-sm">Email resmi kami:</p>
                <p class="text-lg font-semibold text-slate-800 dark:text-slate-200 select-all">
                    {{ $settings->contact_email }}
                </p>
            </div>
            <div class="text-center">
                <a href="mailto:{{ $settings->contact_email }}"
                    class="block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-xl transition shadow hover:shadow-md w-full">
                    Kirim Email
                </a>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });
    </script>

    @livewireScripts
    @stack('scripts')
</body>

</html>
