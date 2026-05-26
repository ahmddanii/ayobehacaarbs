<nav class="sticky top-0 z-50 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 shadow-sm transition-colors duration-300" 
    x-data="{ 
        isOpen: false, 
        theme: localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'),
        isDrawerOpen: false
    }">

    <script>
        function initBookmarksStore() {
            if (window.Alpine && !window.Alpine.store('bookmarksStore')) {
                window.Alpine.store('bookmarksStore', {
                    items: (() => {
                        try {
                            let parsed = JSON.parse(localStorage.getItem('ayobehacaar_bookmarks') || '[]');
                            if (!Array.isArray(parsed)) return [];
                            // Sanitize: filter out null, non-objects, or items without id and title
                            let sanitized = parsed.filter(item => item && typeof item === 'object' && item.id && item.title);
                            localStorage.setItem('ayobehacaar_bookmarks', JSON.stringify(sanitized));
                            return sanitized;
                        } catch (e) {
                            localStorage.setItem('ayobehacaar_bookmarks', '[]');
                            return [];
                        }
                    })(),
                    
                    toggle(article) {
                        let index = this.items.findIndex(b => b.id === article.id);
                        if (index > -1) {
                            this.items = this.items.filter(b => b.id !== article.id);
                        } else {
                            this.items = [...this.items, article];
                        }
                        localStorage.setItem('ayobehacaar_bookmarks', JSON.stringify(this.items));
                    },
                    remove(id) {
                        this.items = this.items.filter(b => b.id !== id);
                        localStorage.setItem('ayobehacaar_bookmarks', JSON.stringify(this.items));
                    },
                    isBookmarked(id) {
                        return this.items.some(b => b.id === id);
                    },
                    clearAll() {
                        this.items = [];
                        localStorage.setItem('ayobehacaar_bookmarks', '[]');
                    }
                });
            }
        }

        if (window.Alpine) {
            initBookmarksStore();
        } else {
            document.addEventListener('alpine:init', initBookmarksStore);
            document.addEventListener('livewire:init', initBookmarksStore);
        }
    </script>
    
    <div class="container mx-auto px-4 md:px-12 py-3 flex items-center justify-between">

        <!-- Logo & Brand (Left) -->
        <div class="flex-shrink-0 lg:w-1/3 flex justify-start">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('assets/img/ayobehacaar.png') }}" alt="Logo" class="h-12 w-auto">
                <span class="text-[19px] font-semibold text-slate-900 dark:text-white tracking-tight font-brand">
                    ayo<span class="text-blue-600">behacaar</span>
                </span>
            </a>
        </div>

        <!-- Desktop Menu (Center) -->
        <div class="hidden lg:flex lg:w-1/3 justify-center">
            <ul class="flex items-center gap-8 font-medium text-slate-500 dark:text-slate-400 tracking-wide text-[15px]">
                <li>
                    <a href="{{ route('home') }}"
                        class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-300 {{ request()->routeIs('home') ? 'text-blue-600 font-bold' : '' }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('articles.index') }}"
                        class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-300 {{ request()->routeIs('articles.*') ? 'text-blue-600 font-bold' : '' }}">Artikel</a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}"
                        class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-300 {{ request()->routeIs('categories.*') ? 'text-blue-600 font-bold' : '' }}">Kategori</a>
                </li>
                <li>
                    <a href="{{ route('about') }}"
                        class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-300 {{ request()->routeIs('about') ? 'text-blue-600 font-bold' : '' }}">About</a>
                </li>
            </ul>
        </div>

        <!-- Theme Toggle, Bookmarks & Social Media (Right) -->
        <div class="hidden lg:flex lg:w-1/3 justify-end items-center gap-6 text-slate-400 dark:text-slate-500">
            <!-- Bookmark Button -->
            <button @click="isDrawerOpen = true" class="text-lg relative hover:scale-110 transform transition duration-300 flex items-center justify-center focus:outline-none p-1.5 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800" title="Daftar Bacaan">
                <i class="bi bi-bookmark-heart text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400"></i>
                <!-- Red Badge Count -->
                <span x-show="$store.bookmarksStore.items.length > 0" 
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center border border-white dark:border-slate-900" x-cloak x-text="$store.bookmarksStore.items.length">
                </span>
            </button>

            <!-- Theme Toggle Button -->
            <button @click="
                theme = theme === 'dark' ? 'light' : 'dark';
                localStorage.setItem('theme', theme);
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            " class="text-lg hover:scale-110 transform transition duration-300 flex items-center justify-center focus:outline-none p-1.5 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800" title="Ubah Mode Tema">
                <!-- Moon icon (when theme is light) -->
                <i x-show="theme === 'light'" class="bi bi-moon-stars-fill text-slate-600 hover:text-blue-600"></i>
                <!-- Sun icon (when theme is dark) -->
                <i x-show="theme === 'dark'" class="bi bi-sun-fill text-yellow-400" x-cloak></i>
            </button>

            @if($settings->instagram_url)
            <a href="{{ $settings->instagram_url }}" target="_blank"
                class="text-lg hover:text-[#e1306c] hover:scale-110 transform transition duration-300 flex items-center justify-center">
                <i class="bi bi-instagram"></i>
            </a>
            @endif
            @if($settings->tiktok_url)
            <a href="{{ $settings->tiktok_url }}" target="_blank"
                class="text-lg hover:text-black dark:hover:text-white hover:scale-110 transform transition duration-300 flex items-center justify-center">
                <i class="bi bi-tiktok"></i>
            </a>
            @endif
            @if($settings->youtube_url)
            <a href="{{ $settings->youtube_url }}" target="_blank"
                class="text-lg hover:text-[#ff0000] hover:scale-110 transform transition duration-300 flex items-center justify-center">
                <i class="bi bi-youtube"></i>
            </a>
            @endif
        </div>

        <!-- Mobile Actions -->
        <div class="flex items-center gap-3 lg:hidden">
            <!-- Bookmark Mobile Button -->
            <button @click="isDrawerOpen = true" class="text-lg relative focus:outline-none p-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition duration-300" aria-label="Daftar Bacaan">
                <i class="bi bi-bookmark-heart text-slate-600 dark:text-slate-350"></i>
                <!-- Red Badge Count -->
                <span x-show="$store.bookmarksStore.items.length > 0" 
                    class="absolute top-1 right-1 bg-red-500 text-white text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center border border-white dark:border-slate-900" x-cloak x-text="$store.bookmarksStore.items.length">
                </span>
            </button>

            <!-- Theme Toggle Mobile Button -->
            <button @click="
                theme = theme === 'dark' ? 'light' : 'dark';
                localStorage.setItem('theme', theme);
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            " class="text-lg focus:outline-none p-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition duration-300" aria-label="Ubah Mode Tema">
                <i x-show="theme === 'light'" class="bi bi-moon-stars-fill text-slate-600"></i>
                <i x-show="theme === 'dark'" class="bi bi-sun-fill text-yellow-400" x-cloak></i>
            </button>

            <!-- Mobile Hamburger Toggle -->
            <button @click="isOpen = !isOpen" class="flex flex-col justify-center focus:outline-none"
                aria-label="Toggle Menu">
                <span class="w-[25px] h-[2px] bg-slate-700 dark:bg-slate-300 mb-1.5 rounded transition-transform duration-300"
                    :class="isOpen ? 'translate-y-[8px] rotate-45' : ''"></span>
                <span class="w-[25px] h-[2px] bg-slate-700 dark:bg-slate-300 mb-1.5 rounded transition-opacity duration-300"
                    :class="isOpen ? 'opacity-0 scale-0' : ''"></span>
                <span class="w-[25px] h-[2px] bg-slate-700 dark:bg-slate-300 rounded transition-transform duration-300"
                    :class="isOpen ? '-translate-y-[8px] -rotate-45' : ''"></span>
            </button>
        </div>
    </div>

    <!-- Mobile Menu Collapse -->
    <div x-show="isOpen" 
        x-transition:enter="transition ease-out duration-300 transform origin-top"
        x-transition:enter-start="opacity-0 -translate-y-4 scale-y-90" 
        x-transition:enter-end="opacity-100 translate-y-0 scale-y-100"
        x-transition:leave="transition ease-in duration-200 transform origin-top" 
        x-transition:leave-start="opacity-100 translate-y-0 scale-y-100"
        x-transition:leave-end="opacity-0 -translate-y-4 scale-y-90"
        class="absolute top-full left-0 w-full lg:hidden flex flex-col bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 py-4 px-6 space-y-3 shadow-lg justify-center items-center transition-colors duration-300"
        @click.away="isOpen = false" x-cloak>
        <a href="{{ route('home') }}"
            class="block py-2 font-medium text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Home</a>
        <a href="{{ route('articles.index') }}"
            class="block py-2 font-medium text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Artikel</a>
        <a href="{{ route('categories.index') }}"
            class="block py-2 font-medium text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 transition">Kategori</a>
        <a href="{{ route('about') }}"
            class="block py-2 font-medium text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 transition">About</a>
        <hr class="border-slate-100 dark:border-slate-800 my-2 w-full">
        <div class="flex justify-center items-center gap-6 py-2">
            @if($settings->instagram_url)
            <a href="{{ $settings->instagram_url }}" target="_blank" class="text-2xl"
                style="background: linear-gradient(20deg, #feda75 0%, #fa7e1e 24%, #d62970 60%, #962fbf 81%, #4f5bd5 100%); -webkit-background-clip: text; background-clip: text; color: transparent;">
                <i class="bi bi-instagram"></i>
            </a>
            @endif
            @if($settings->youtube_url)
            <a href="{{ $settings->youtube_url }}" target="_blank" class="text-2xl text-red-600">
                <i class="bi bi-youtube"></i>
            </a>
            @endif
            @if($settings->tiktok_url)
            <a href="{{ $settings->tiktok_url }}" target="_blank" class="text-2xl text-black dark:text-slate-300">
                <i class="bi bi-tiktok"></i>
            </a>
            @endif
        </div>
    </div>

    <!-- Reading List Slide-Over Drawer -->
    <div x-show="isDrawerOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[100] bg-slate-950/40 backdrop-blur-md"
        @click="isDrawerOpen = false"
        x-cloak>
    </div>
    
    <div x-show="isDrawerOpen" 
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 h-screen w-full max-w-md bg-white dark:bg-slate-900 shadow-2xl z-[101] flex flex-col transition-colors duration-300"
        x-cloak>
        
        <!-- Drawer Header -->
        <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-900/50">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <i class="bi bi-bookmark-heart-fill text-lg"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-800 dark:text-white text-base">Daftar Bacaan</h3>
                    <p class="text-[11px] text-slate-400 dark:text-slate-550">Artikel yang Anda simpan</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-bold px-2.5 py-0.5 rounded-full" x-text="$store.bookmarksStore.items.length"></span>
                <button @click="isDrawerOpen = false" class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none transition">
                    <i class="bi bi-x-lg text-xs font-bold"></i>
                </button>
            </div>
        </div>

        <!-- Drawer Content -->
        <div class="flex-1 overflow-y-auto p-6 space-y-4 custom-scrollbar bg-white dark:bg-slate-900">
            <!-- Empty State -->
            <div x-show="$store.bookmarksStore.items.length === 0" class="flex flex-col items-center justify-center py-24 text-center text-slate-400 dark:text-slate-600">
                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800/50 text-slate-350 dark:text-slate-650 rounded-full flex items-center justify-center mb-6 text-4xl shadow-inner">
                    <i class="bi bi-book-half"></i>
                </div>
                <h4 class="font-bold text-slate-700 dark:text-slate-300 mb-2 text-base">Daftar Bacaan Kosong</h4>
                <p class="text-xs max-w-[260px] leading-relaxed text-slate-500 dark:text-slate-400">
                    Belum ada artikel yang Anda simpan. Klik ikon bookmark hati pada kartu artikel untuk menambahkannya ke sini.
                </p>
            </div>

            <!-- Articles List -->
            <div x-show="$store.bookmarksStore.items.length > 0" class="space-y-4">
                <template x-for="item in $store.bookmarksStore.items" :key="item.id">
                    <div class="flex gap-4 p-4 rounded-xl border border-slate-100 dark:border-slate-800/80 hover:border-blue-100 dark:hover:border-blue-900/30 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition duration-300 group shadow-sm hover:shadow relative overflow-hidden">
                        
                        <!-- Article Thumbnail -->
                        <div class="w-20 h-20 rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-850 flex-shrink-0 relative shadow-sm">
                            <img :src="item.image" :alt="item.title" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        </div>

                        <!-- Article Info -->
                        <div class="flex-1 min-w-0 flex flex-col justify-between py-0.5">
                            <div>
                                <span class="inline-block text-[9px] font-bold bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-full px-2 py-0.5 mb-1.5 uppercase tracking-wider" x-text="item.category"></span>
                                <h4 class="font-bold text-slate-800 dark:text-slate-200 text-xs leading-snug line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition duration-300" x-text="item.title"></h4>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <span class="text-[10px] text-slate-400 dark:text-slate-550 font-medium" x-text="item.date"></span>
                                <div class="flex items-center gap-3">
                                    <a :href="'/articles/' + item.slug" class="text-[10px] font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 flex items-center gap-0.5 hover:underline">
                                        Baca <i class="bi bi-arrow-right text-[8px]"></i>
                                    </a>
                                    <button @click="$store.bookmarksStore.remove(item.id)" class="text-slate-400 hover:text-red-500 dark:hover:text-red-400 transition duration-300 focus:outline-none p-1 hover:bg-red-50 dark:hover:bg-red-950/20 rounded" title="Hapus dari daftar">
                                        <i class="bi bi-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </template>
            </div>
        </div>

        <!-- Drawer Footer -->
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex justify-between items-center text-xs text-slate-400 mt-auto">
            <span class="font-medium tracking-wide">Daftar Bacaan Pribadi</span>
            <button @click="$store.bookmarksStore.clearAll()" 
                x-show="$store.bookmarksStore.items.length > 0" 
                class="text-red-500 dark:text-red-400 font-bold hover:text-red-600 dark:hover:text-red-300 hover:underline focus:outline-none transition">
                Hapus Semua
            </button>
        </div>

    </div>
</nav>
