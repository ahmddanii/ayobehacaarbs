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
    
    <!-- FontAwesome 6 for EasyMDE Toolbar Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- EasyMDE Markdown Editor -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>

    @livewireStyles
    @stack('styles')

    <style>
        body {
            font-family: 'Inter', sans-serif !important;
        }
        /* Custom EasyMDE Styling */
        .EasyMDEContainer .CodeMirror {
            border-radius: 0 0 12px 12px;
            border-color: #e2e8f0;
            background-color: #f8fafc;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.875rem;
            min-height: 380px !important;
            max-height: 480px !important;
        }
        .EasyMDEContainer .editor-toolbar {
            border-radius: 12px 12px 0 0;
            border-color: #e2e8f0;
            background-color: #ffffff;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .EasyMDEContainer .editor-toolbar button {
            border-radius: 6px;
            transition: all 0.2s;
        }
        .EasyMDEContainer .editor-toolbar button.active, 
        .EasyMDEContainer .editor-toolbar button:hover {
            background-color: #f1f5f9;
            color: #2563eb;
        }
        .dark .EasyMDEContainer .CodeMirror {
            background-color: #1e293b;
            color: #cbd5e1;
            border-color: #334155;
        }
        .dark .EasyMDEContainer .editor-toolbar {
            background-color: #0f172a;
            border-color: #334155;
        }
        .dark .EasyMDEContainer .editor-toolbar button {
            color: #94a3b8;
        }
        .dark .EasyMDEContainer .editor-toolbar button.active, 
        .dark .EasyMDEContainer .editor-toolbar button:hover {
            background-color: #1e293b;
            color: #38bdf8;
        }
    </style>
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <div class="flex min-h-screen overflow-hidden" x-data="{ sidebarOpen: true }">
        {{-- Sidebar --}}
        @include('layouts.partials._sidebar')

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
