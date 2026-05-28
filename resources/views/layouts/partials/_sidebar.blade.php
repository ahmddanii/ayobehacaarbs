{{-- Admin Sidebar Navigation Partial --}}
<aside :class="sidebarOpen ? 'w-72 translate-x-0' : 'w-20 lg:translate-x-0'"
    class="bg-slate-950 border-r border-slate-900/50 transition-all duration-300 hidden lg:flex flex-col shrink-0 fixed inset-y-0 z-50 overflow-x-hidden">

    {{-- Logo & Toggle --}}
    <div class="p-6 flex items-center justify-between border-b border-slate-900/50"
        :class="sidebarOpen ? 'p-6 justify-between' : 'p-4 justify-center'">
        <a href="{{ route('home') }}" class="flex items-center gap-3 font-black tracking-tighter text-white">
            <div
                class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shrink-0 shadow-md shadow-blue-500/20 h-12 w-12 flex items-center justify-center transition-all duration-300">
                <img src="{{ asset('assets/img/ayobehacaar.png') }}" alt="Logo"
                    class="h-6 w-auto brightness-0 invert">
            </div>
            <span x-show="sidebarOpen" x-transition.opacity
                class="font-bold tracking-widest text-sm bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent whitespace-nowrap">ADMIN
                PANEL</span>
        </a>
        <button @click="sidebarOpen = !sidebarOpen" x-show="sidebarOpen"
            class="w-8 h-8 rounded-lg bg-slate-900/50 border border-slate-800/80 flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-800 transition duration-200">
            <i class="bi bi-chevron-left"></i>
        </button>
    </div>

    {{-- Navigation Links --}}
    <nav class="flex-grow p-4 space-y-1.5 mt-4 overflow-y-auto overflow-x-hidden">
        @php
            $navItems = [
                ['route' => 'admin.dashboard', 'icon' => 'bi-speedometer2', 'label' => 'Dashboard'],
                ['route' => 'admin.categories', 'icon' => 'bi-grid-3x3-gap', 'label' => 'Kategori'],
                ['route' => 'admin.articles', 'icon' => 'bi-file-earmark-richtext', 'label' => 'Artikel'],
            ];
        @endphp

        @foreach ($navItems as $item)
            <a href="{{ route($item['route']) }}"
                :class="sidebarOpen ? 'w-full px-4 py-3.5 justify-start' : 'w-12 h-12 justify-center mx-auto'"
                class="group flex items-center gap-4 rounded-xl transition duration-200 overflow-hidden {{ request()->routeIs($item['route']) ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/25' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <i class="bi {{ $item['icon'] }} text-xl group-hover:scale-110 transition duration-200 {{ request()->routeIs($item['route']) ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }} shrink-0"></i>
                <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-medium">{{ $item['label'] }}</span>
            </a>
        @endforeach

        <div class="pt-6 px-4 pb-1 text-[10px] font-bold uppercase tracking-widest text-slate-500/80"
            x-show="sidebarOpen">System</div>

        @php
            $systemItems = [
                ['route' => 'admin.settings', 'icon' => 'bi-gear', 'label' => 'Pengaturan'],
            ];
        @endphp

        @foreach ($systemItems as $item)
            <a href="{{ route($item['route']) }}"
                :class="sidebarOpen ? 'w-full px-4 py-3.5 justify-start' : 'w-12 h-12 justify-center mx-auto'"
                class="group flex items-center gap-4 rounded-xl transition duration-200 overflow-hidden {{ request()->routeIs($item['route']) ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/25' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                <i class="bi {{ $item['icon'] }} text-xl group-hover:scale-110 transition duration-200 {{ request()->routeIs($item['route']) ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }} shrink-0"></i>
                <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-medium">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    {{-- User Profile --}}
    <div class="p-4 border-t border-slate-900/50">
        <a href="{{ route('profile.edit') }}" :class="sidebarOpen ? 'flex items-center gap-3.5 px-3 py-3 bg-slate-900/40 border border-slate-800/40 hover:bg-slate-900/80 hover:border-slate-700/60 rounded-xl' : 'flex items-center justify-center p-0 bg-transparent border-transparent hover:scale-105'"
            class="transition-all duration-300 group block text-decoration-none">
            <div class="flex items-center gap-3.5 w-full">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-extrabold shadow-sm shadow-blue-500/20 shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden flex-grow" x-show="sidebarOpen" x-transition.opacity>
                    <p class="text-sm font-semibold text-slate-100 truncate leading-snug group-hover:text-blue-400 transition">
                        {{ auth()->user()->name }}</p>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5 flex items-center justify-between">
                        <span>Admin</span>
                        <i class="bi bi-pencil-square text-slate-600 group-hover:text-blue-400 transition text-xs"></i>
                    </p>
                </div>
            </div>
        </a>
    </div>
</aside>
