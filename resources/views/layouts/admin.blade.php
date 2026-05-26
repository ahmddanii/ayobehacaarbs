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
        .EasyMDEContainer {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px -2px rgba(148, 163, 184, 0.08);
            border: 1px solid #f1f5f9;
        }
        .EasyMDEContainer .CodeMirror {
            border-radius: 0 0 16px 16px;
            border: none !important;
            background-color: #f8fafc;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.875rem;
            min-height: 380px !important;
            max-height: 480px !important;
            padding: 12px 6px;
            transition: background-color 0.2s;
        }
        .EasyMDEContainer .CodeMirror-focused {
            background-color: #ffffff !important;
            box-shadow: inset 0 0 0 2px rgba(37, 99, 235, 0.06);
        }
        .EasyMDEContainer .editor-toolbar {
            border-radius: 16px 16px 0 0;
            border: none !important;
            border-bottom: 1px solid #f1f5f9 !important;
            background-color: #ffffff;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            padding: 10px 14px;
            align-items: center;
        }
        .EasyMDEContainer .editor-toolbar button,
        .EasyMDEContainer .editor-toolbar a {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 32px !important;
            height: 32px !important;
            border-radius: 8px !important;
            color: #475569 !important; /* slate-600 */
            border: 1px solid transparent !important;
            background: transparent !important;
            transition: all 0.2s ease !important;
            font-size: 13px !important;
            cursor: pointer !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .EasyMDEContainer .editor-toolbar button i,
        .EasyMDEContainer .editor-toolbar a i {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 13px !important;
            width: auto !important;
            height: auto !important;
        }
        .EasyMDEContainer .editor-toolbar button.active, 
        .EasyMDEContainer .editor-toolbar button:hover,
        .EasyMDEContainer .editor-toolbar a.active,
        .EasyMDEContainer .editor-toolbar a:hover {
            background-color: #f1f5f9 !important;
            color: #2563eb !important; /* blue-600 */
            border-color: #e2e8f0 !important;
        }
        /* Custom separator */
        .EasyMDEContainer .editor-toolbar .separator {
            display: inline-block !important;
            width: 1px !important;
            height: 18px !important;
            background-color: #e2e8f0 !important;
            margin: 0 4px !important;
            border-right: none !important;
        }
        
        /* Premium Editor Preview Styling */
        .EasyMDEContainer .editor-preview {
            background-color: #f8fafc !important;
            padding: 28px !important;
            color: #334155 !important;
            font-family: 'Inter', sans-serif !important;
            line-height: 1.7 !important;
        }
        .EasyMDEContainer .editor-preview h1,
        .EasyMDEContainer .editor-preview h2,
        .EasyMDEContainer .editor-preview h3 {
            font-weight: 800 !important;
            color: #1e293b !important;
            margin-top: 1.5rem !important;
            margin-bottom: 0.75rem !important;
        }
        .EasyMDEContainer .editor-preview p {
            margin-bottom: 1rem !important;
        }
        .EasyMDEContainer .editor-preview-active {
            border-radius: 0 0 16px 16px !important;
            border: none !important;
        }
        
        /* Fix Fullscreen and Side-by-Side Z-Index Bug */
        .EasyMDEContainer .editor-toolbar.fullscreen {
            z-index: 9999 !important;
            background-color: #ffffff !important;
            border-bottom: 1px solid #f1f5f9 !important;
            position: fixed !important;
            padding: 12px 24px !important;
        }
        .EasyMDEContainer .CodeMirror-fullscreen {
            z-index: 9998 !important;
            border-radius: 0 !important;
            position: fixed !important;
            background-color: #ffffff !important;
        }
        .EasyMDEContainer .editor-preview-side {
            background-color: #f8fafc !important;
            border-left: 1px solid #e2e8f0 !important;
            color: #334155 !important;
            font-family: 'Inter', sans-serif !important;
            line-height: 1.7 !important;
        }
        /* Style split preview specifically when editor is in fullscreen mode to avoid tearing */
        .EasyMDEContainer .CodeMirror-fullscreen + .editor-preview-side {
            z-index: 9997 !important;
            position: fixed !important;
            top: 50px !important;
            height: calc(100% - 50px) !important;
            width: 50% !important;
            background-color: #f8fafc !important;
        }

        /* Dark Mode Compatibility */
        .dark .EasyMDEContainer {
            border-color: #334155;
        }
        .dark .EasyMDEContainer .CodeMirror {
            background-color: #1e293b;
            color: #cbd5e1;
        }
        .dark .EasyMDEContainer .CodeMirror-focused {
            background-color: #0f172a !important;
        }
        .dark .EasyMDEContainer .editor-toolbar {
            background-color: #0f172a;
            border-color: #334155 !important;
        }
        .dark .EasyMDEContainer .editor-toolbar button,
        .dark .EasyMDEContainer .editor-toolbar a {
            color: #94a3b8 !important;
        }
        .dark .EasyMDEContainer .editor-toolbar button.active, 
        .dark .EasyMDEContainer .editor-toolbar button:hover,
        .dark .EasyMDEContainer .editor-toolbar a.active,
        .dark .EasyMDEContainer .editor-toolbar a:hover {
            background-color: #1e293b !important;
            color: #38bdf8 !important; /* sky-400 */
            border-color: #334155 !important;
        }
        .dark .EasyMDEContainer .editor-toolbar .separator {
            background-color: #334155 !important;
        }
        .dark .EasyMDEContainer .editor-preview {
            background-color: #0f172a !important;
            color: #cbd5e1 !important;
        }
        .dark .EasyMDEContainer .editor-preview h1,
        .dark .EasyMDEContainer .editor-preview h2,
        .dark .EasyMDEContainer .editor-preview h3 {
            color: #f8fafc !important;
        }
        .dark .EasyMDEContainer .editor-toolbar.fullscreen,
        .dark .EasyMDEContainer .CodeMirror-fullscreen {
            background-color: #0f172a !important;
        }
        .dark .EasyMDEContainer .editor-preview-side {
            background-color: #0f172a !important;
            border-color: #334155 !important;
        }
        .dark .EasyMDEContainer .CodeMirror-fullscreen + .editor-preview-side {
            background-color: #0f172a !important;
            border-color: #334155 !important;
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
