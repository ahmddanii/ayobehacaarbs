<nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-100 shadow-sm" x-data="{ isOpen: false }">
    <div class="container mx-auto px-4 md:px-12 py-3 flex items-center justify-between">

        <!-- Logo & Brand (Left) -->
        <div class="flex-shrink-0 lg:w-1/3 flex justify-start">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('assets/img/ayobehacaar.png') }}" alt="Logo" class="h-12 w-auto">
                <span class="text-[19px] font-semibold text-slate-900 tracking-tight font-brand">
                    ayo<span class="text-blue-600">behacaar</span>
                </span>
            </a>
        </div>

        <!-- Desktop Menu (Center) -->
        <div class="hidden lg:flex lg:w-1/3 justify-center">
            <ul class="flex items-center gap-8 font-medium text-slate-500 tracking-wide text-[15px]">
                <li>
                    <a href="{{ route('home') }}"
                        class="hover:text-blue-600 transition duration-300 {{ request()->routeIs('home') ? 'text-blue-600 font-bold' : '' }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('articles.index') }}"
                        class="hover:text-blue-600 transition duration-300 {{ request()->routeIs('articles.*') ? 'text-blue-600 font-bold' : '' }}">Artikel</a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}"
                        class="hover:text-blue-600 transition duration-300 {{ request()->routeIs('categories.*') ? 'text-blue-600 font-bold' : '' }}">Kategori</a>
                </li>
                <li>
                    <a href="{{ route('about') }}"
                        class="hover:text-blue-600 transition duration-300 {{ request()->routeIs('about') ? 'text-blue-600 font-bold' : '' }}">About</a>
                </li>
            </ul>
        </div>

        <!-- Social Media (Right) -->
        <div class="hidden lg:flex lg:w-1/3 justify-end items-center gap-6 text-slate-400">
            <a href="https://www.instagram.com/sainsaa__" target="_blank"
                class="text-lg hover:text-[#e1306c] hover:scale-110 transform transition duration-300 flex items-center justify-center">
                <i class="bi bi-instagram"></i>
            </a>
            <a href="http://www.tiktok.com/@ayobehacaar" target="_blank"
                class="text-lg hover:text-black hover:scale-110 transform transition duration-300 flex items-center justify-center">
                <i class="bi bi-tiktok"></i>
            </a>
            <a href="https://www.youtube.com/@ayobehacaar" target="_blank"
                class="text-lg hover:text-[#ff0000] hover:scale-110 transform transition duration-300 flex items-center justify-center">
                <i class="bi bi-youtube"></i>
            </a>
        </div>

        <!-- Mobile Hamburger Toggle -->
        <button @click="isOpen = !isOpen" class="lg:hidden flex flex-col justify-center focus:outline-none"
            aria-label="Toggle Menu">
            <span class="w-[25px] h-[2px] bg-slate-700 mb-1.5 rounded transition-transform duration-300"
                :class="isOpen ? 'translate-y-[8px] rotate-45' : ''"></span>
            <span class="w-[25px] h-[2px] bg-slate-700 mb-1.5 rounded transition-opacity duration-300"
                :class="isOpen ? 'opacity-0 scale-0' : ''"></span>
            <span class="w-[25px] h-[2px] bg-slate-700 rounded transition-transform duration-300"
                :class="isOpen ? '-translate-y-[8px] -rotate-45' : ''"></span>
        </button>
    </div>

    <!-- Mobile Menu Collapse -->
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="lg:hidden flex flex-col bg-white border-t border-slate-100 py-4 px-6 space-y-3 shadow-lg justify-center items-center"
        @click.away="isOpen = false" x-cloak>
        <a href="{{ route('home') }}"
            class="block py-2 font-medium text-slate-700 hover:text-blue-600 transition">Home</a>
        <a href="{{ route('articles.index') }}"
            class="block py-2 font-medium text-slate-700 hover:text-blue-600 transition">Artikel</a>
        <a href="{{ route('categories.index') }}"
            class="block py-2 font-medium text-slate-700 hover:text-blue-600 transition">Kategori</a>
        <a href="{{ route('about') }}"
            class="block py-2 font-medium text-slate-700 hover:text-blue-600 transition">About</a>
        <hr class="border-slate-100 my-2">
        <div class="flex justify-e items-center gap-6 py-2">
            <a href="https://www.instagram.com/sainsaa__" target="_blank" class="text-2xl"
                style="background: linear-gradient(20deg, #feda75 0%, #fa7e1e 24%, #d62970 60%, #962fbf 81%, #4f5bd5 100%); -webkit-background-clip: text; background-clip: text; color: transparent;">
                <i class="bi bi-instagram"></i>
            </a>
            <a href="https://www.youtube.com/@ayobehacaar" target="_blank" class="text-2xl text-red-600">
                <i class="bi bi-youtube"></i>
            </a>
            <a href="http://www.tiktok.com/@ayobehacaar" target="_blank" class="text-2xl text-black">
                <i class="bi bi-tiktok"></i>
            </a>
        </div>
    </div>
</nav>
