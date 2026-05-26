<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Ayo Behacaar</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireStyles

    <style>
        body {
            font-family: 'Inter', sans-serif !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <div class="flex min-h-screen overflow-hidden" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-72' : 'w-20'"
            class="bg-slate-950 border-r border-slate-900/50 transition-all duration-300 flex flex-col shrink-0 fixed inset-y-0 z-50">
            <div class="p-6 flex items-center justify-between border-b border-slate-900/50" :class="sidebarOpen ? 'p-6 justify-between' : 'p-4 justify-center'">
                <a href="{{ route('home') }}"
                    class="flex items-center gap-3 font-black tracking-tighter text-white">
                    <div
                        class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shrink-0 shadow-md shadow-blue-500/20 h-12 w-12 flex items-center justify-center transition-all duration-300">
                        <img src="{{ asset('assets/img/ayobehacaar.png') }}" alt="Logo"
                            class="h-6 w-auto brightness-0 invert">
                    </div>
                    <span x-show="sidebarOpen" x-transition.opacity
                        class="font-bold tracking-widest text-sm bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent whitespace-nowrap">ADMIN PANEL</span>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" x-show="sidebarOpen"
                    class="w-8 h-8 rounded-lg bg-slate-900/50 border border-slate-800/80 flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-800 transition duration-200">
                    <i class="bi bi-chevron-left"></i>
                </button>
            </div>

            <nav class="flex-grow p-4 space-y-1.5 mt-4 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                    :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'"
                    class="group flex items-center gap-4 py-3.5 rounded-xl transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/25' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                    <i
                        class="bi bi-speedometer2 text-xl group-hover:scale-110 transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.categories') }}"
                    :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'"
                    class="group flex items-center gap-4 py-3.5 rounded-xl transition duration-200 {{ request()->routeIs('admin.categories') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/25' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                    <i
                        class="bi bi-grid-3x3-gap text-xl group-hover:scale-110 transition duration-200 {{ request()->routeIs('admin.categories') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-medium">Kategori</span>
                </a>
                <a href="{{ route('admin.articles') }}"
                    :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'"
                    class="group flex items-center gap-4 py-3.5 rounded-xl transition duration-200 {{ request()->routeIs('admin.articles') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/25' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                    <i
                        class="bi bi-file-earmark-richtext text-xl group-hover:scale-110 transition duration-200 {{ request()->routeIs('admin.articles') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-medium">Artikel</span>
                </a>
                <div class="pt-6 px-4 pb-1 text-[10px] font-bold uppercase tracking-widest text-slate-500/80"
                    x-show="sidebarOpen">System</div>
                <a href="#"
                    :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'"
                    class="group flex items-center gap-4 py-3.5 rounded-xl text-slate-400 hover:bg-slate-900 hover:text-slate-100 transition duration-200">
                    <i
                        class="bi bi-people text-xl group-hover:scale-110 transition duration-200 text-slate-400 group-hover:text-blue-400"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-medium">Users</span>
                </a>
                <a href="#"
                    :class="sidebarOpen ? 'px-4 justify-start' : 'px-0 justify-center'"
                    class="group flex items-center gap-4 py-3.5 rounded-xl text-slate-400 hover:bg-slate-900 hover:text-slate-100 transition duration-200">
                    <i
                        class="bi bi-gear text-xl group-hover:scale-110 transition duration-200 text-slate-400 group-hover:text-blue-400"></i>
                    <span x-show="sidebarOpen" x-transition.opacity class="text-sm font-medium">Pengaturan</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-900/50">
                <div class="flex items-center gap-3.5 px-3 py-3 bg-slate-900/40 border border-slate-800/40 rounded-xl">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-extrabold shadow-sm shadow-blue-500/20">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden" x-show="sidebarOpen" x-transition.opacity>
                        <p class="text-sm font-semibold text-slate-100 truncate leading-snug">
                            {{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Administrator
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div :class="sidebarOpen ? 'pl-72' : 'pl-20'"
            class="flex-grow flex flex-col transition-all duration-300 min-w-0">
            <!-- Header -->
            <header
                class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/60 flex items-center justify-between px-8 sticky top-0 z-40">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-200/60 hover:bg-slate-100 flex items-center justify-center text-slate-500 hover:text-blue-600 transition duration-200 shadow-sm">
                        <i class="bi bi-list text-xl"></i>
                    </button>
                    <h2 class="text-lg font-bold text-slate-900 tracking-tight">@yield('page_title', 'Dashboard')</h2>
                </div>
                <div class="flex items-center gap-5">
                    <div class="relative group">
                        <button
                            class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition duration-200">
                            <i class="bi bi-bell text-lg"></i>
                        </button>
                        <span
                            class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border border-white animate-pulse"></span>
                    </div>

                    <div class="h-6 w-[1px] bg-slate-200"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 hover:bg-rose-50 border border-slate-100 hover:border-rose-100 text-xs font-bold text-slate-600 hover:text-rose-600 transition duration-200">
                            <span>Keluar</span>
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </header>

            <main class="p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
</body>

</html>
