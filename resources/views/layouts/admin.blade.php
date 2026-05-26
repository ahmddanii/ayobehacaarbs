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

    <!-- Highlight.js for Premium Code Syntax Highlighting -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/atom-one-dark.min.css">
    <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/highlight.min.js"></script>

    @livewireStyles
    @stack('styles')

    <style>
        body {
            font-family: 'Inter', sans-serif !important;
        }

        /* ===== EasyMDE Editor: Premium Overhaul ===== */

        /* Container */
        .EasyMDEContainer {
            border-radius: 16px;
            box-shadow: 0 4px 20px -2px rgba(148, 163, 184, 0.08);
            border: 1px solid #e2e8f0;
        }

        /* Toolbar */
        .EasyMDEContainer .editor-toolbar {
            border-radius: 16px 16px 0 0;
            border: none;
            border-bottom: 1px solid #f1f5f9;
            background-color: #ffffff;
            padding: 8px 12px;
            opacity: 1;
        }
        .EasyMDEContainer .editor-toolbar::before,
        .EasyMDEContainer .editor-toolbar::after {
            display: none;
        }

        /* Toolbar Buttons */
        .EasyMDEContainer .editor-toolbar button {
            width: 34px !important;
            height: 34px !important;
            border-radius: 8px !important;
            border: 1px solid transparent !important;
            background: none !important;
            color: #475569 !important;
            margin: 0 1px !important;
            padding: 0 !important;
            text-align: center !important;
            cursor: pointer !important;
            transition: background 0.15s, color 0.15s, border-color 0.15s;
            box-shadow: none !important;
        }
        .EasyMDEContainer .editor-toolbar button:hover {
            background-color: #f1f5f9 !important;
            color: #2563eb !important;
            border-color: #e2e8f0 !important;
        }
        .EasyMDEContainer .editor-toolbar button.active {
            background-color: #eff6ff !important;
            color: #2563eb !important;
            border-color: #bfdbfe !important;
        }

        /* Separator (EasyMDE renders separators as <i class="separator">) */
        .EasyMDEContainer .editor-toolbar i.separator {
            display: inline-block !important;
            width: 1px !important;
            height: 20px !important;
            background-color: #e2e8f0 !important;
            border: none !important;
            border-left: none !important;
            border-right: none !important;
            margin: 0 6px !important;
            vertical-align: middle !important;
        }

        /* CodeMirror Canvas */
        .EasyMDEContainer .CodeMirror {
            border-radius: 0 0 16px 16px;
            border: none !important;
            border-top: none !important;
            background-color: #f8fafc;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.875rem;
            min-height: 380px !important;
            max-height: 480px !important;
            padding: 8px 4px;
            transition: background-color 0.2s;
        }
        .EasyMDEContainer .CodeMirror-focused {
            background-color: #ffffff !important;
        }
        .EasyMDEContainer .CodeMirror-placeholder {
            color: #94a3b8 !important;
        }

        /* EasyMDE Built-in Preview */
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
        .EasyMDEContainer .editor-preview-side {
            background-color: #f8fafc !important;
            border-left: 1px solid #e2e8f0 !important;
            color: #334155 !important;
            font-family: 'Inter', sans-serif !important;
            line-height: 1.7 !important;
        }

        /* ===== Code Syntax Highlighting ===== */
        .preview-content pre,
        .EasyMDEContainer .editor-preview pre {
            background-color: #282c34 !important;
            color: #abb2bf !important;
            padding: 1.25rem !important;
            border-radius: 12px !important;
            overflow-x: auto !important;
            margin: 1.5rem 0 !important;
            border: 1px solid #3e4451 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .preview-content pre code,
        .EasyMDEContainer .editor-preview pre code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Fira Code', 'JetBrains Mono', monospace !important;
            font-size: 0.875rem !important;
            background-color: transparent !important;
            color: inherit !important;
            padding: 0 !important;
            border-radius: 0 !important;
            border: none !important;
            line-height: 1.6 !important;
        }
        .preview-content code,
        .EasyMDEContainer .editor-preview code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
            font-size: 0.85em !important;
            background-color: #f1f5f9 !important;
            color: #e11d48 !important;
            padding: 0.15rem 0.35rem !important;
            border-radius: 6px !important;
            font-weight: 600 !important;
            border: 1px solid #e2e8f0 !important;
        }
        .dark .preview-content code,
        .dark .EasyMDEContainer .editor-preview code {
            background-color: #1e293b !important;
            color: #f43f5e !important;
            border-color: #334155 !important;
        }

        /* ===== Fullscreen Mode Fixes ===== */
        .EasyMDEContainer .editor-toolbar.fullscreen {
            z-index: 9999 !important;
            background-color: #ffffff !important;
            border-bottom: 1px solid #f1f5f9 !important;
            position: fixed !important;
            padding: 10px 24px !important;
        }
        .EasyMDEContainer .CodeMirror-fullscreen {
            z-index: 9998 !important;
            border-radius: 0 !important;
            position: fixed !important;
            background-color: #ffffff !important;
        }
        .EasyMDEContainer .CodeMirror-fullscreen + .editor-preview-side {
            z-index: 9997 !important;
            position: fixed !important;
            top: 50px !important;
            height: calc(100% - 50px) !important;
            width: 50% !important;
            background-color: #f8fafc !important;
        }

        /* ===== Dark Mode ===== */
        .dark .EasyMDEContainer {
            border-color: #334155;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.2);
        }
        .dark .EasyMDEContainer .editor-toolbar {
            background-color: #0f172a;
            border-bottom-color: #1e293b;
        }
        .dark .EasyMDEContainer .editor-toolbar button {
            color: #94a3b8 !important;
        }
        .dark .EasyMDEContainer .editor-toolbar button:hover {
            background-color: #1e293b !important;
            color: #38bdf8 !important;
            border-color: #334155 !important;
        }
        .dark .EasyMDEContainer .editor-toolbar button.active {
            background-color: #1e293b !important;
            color: #38bdf8 !important;
            border-color: #334155 !important;
        }
        .dark .EasyMDEContainer .editor-toolbar i.separator {
            background-color: #334155 !important;
        }
        .dark .EasyMDEContainer .CodeMirror {
            background-color: #1e293b;
            color: #cbd5e1;
        }
        .dark .EasyMDEContainer .CodeMirror-focused {
            background-color: #0f172a !important;
        }
        .dark .EasyMDEContainer .CodeMirror-placeholder {
            color: #475569 !important;
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
        .dark .EasyMDEContainer .editor-preview-side {
            background-color: #0f172a !important;
            border-color: #334155 !important;
        }
        .dark .EasyMDEContainer .editor-toolbar.fullscreen,
        .dark .EasyMDEContainer .CodeMirror-fullscreen {
            background-color: #0f172a !important;
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
