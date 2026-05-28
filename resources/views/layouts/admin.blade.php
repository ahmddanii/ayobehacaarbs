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
            padding: 8px 4px;
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

        /* ===== Live Preview: Links ===== */
        .preview-content a,
        .EasyMDEContainer .editor-preview a {
            color: #2563eb !important;
            text-decoration: underline !important;
            text-underline-offset: 3px !important;
            font-weight: 600 !important;
            transition: color 0.15s;
        }
        .preview-content a:hover,
        .EasyMDEContainer .editor-preview a:hover {
            color: #1d4ed8 !important;
        }

        /* ===== Live Preview: Blockquotes ===== */
        .preview-content blockquote,
        .EasyMDEContainer .editor-preview blockquote {
            border-left: 4px solid #3b82f6 !important;
            background-color: #eff6ff !important;
            padding: 1rem 1.25rem !important;
            margin: 1.25rem 0 !important;
            border-radius: 0 10px 10px 0 !important;
            color: #334155 !important;
            font-style: italic !important;
        }
        .preview-content blockquote p,
        .EasyMDEContainer .editor-preview blockquote p {
            margin-bottom: 0 !important;
        }

        /* ===== Live Preview: Tables ===== */
        .preview-content table,
        .EasyMDEContainer .editor-preview table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin: 1.5rem 0 !important;
            font-size: 0.875rem !important;
            border-radius: 10px !important;
            overflow: hidden !important;
        }
        .preview-content th,
        .EasyMDEContainer .editor-preview th {
            background-color: #f1f5f9 !important;
            font-weight: 700 !important;
            color: #1e293b !important;
            padding: 0.75rem 1rem !important;
            text-align: left !important;
            border-bottom: 2px solid #e2e8f0 !important;
        }
        .preview-content td,
        .EasyMDEContainer .editor-preview td {
            padding: 0.65rem 1rem !important;
            border-bottom: 1px solid #f1f5f9 !important;
            color: #475569 !important;
        }
        .preview-content tr:hover td,
        .EasyMDEContainer .editor-preview tr:hover td {
            background-color: #f8fafc !important;
        }

        /* ===== Live Preview: Images ===== */
        .preview-content img,
        .EasyMDEContainer .editor-preview img {
            max-width: 100% !important;
            border-radius: 12px !important;
            margin: 1.25rem 0 !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        /* ===== Live Preview: Highlight / Mark ===== */
        .preview-content mark,
        .EasyMDEContainer .editor-preview mark {
            background: linear-gradient(120deg, #fef08a 0%, #fde68a 100%) !important;
            color: #1e293b !important;
            padding: 0.1rem 0.3rem !important;
            border-radius: 4px !important;
        }

        /* ===== Live Preview: Horizontal Rule ===== */
        .preview-content hr,
        .EasyMDEContainer .editor-preview hr {
            border: none !important;
            height: 1px !important;
            background-color: #e2e8f0 !important;
            margin: 2rem 0 !important;
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
    <div class="flex min-h-screen overflow-hidden" x-data="{ sidebarOpen: window.innerWidth > 768 }">
        {{-- Sidebar --}}
        @include('layouts.partials._sidebar')

        <!-- Main Content -->
        <div :class="sidebarOpen ? 'lg:pl-72 pl-0' : 'lg:pl-20 pl-0'"
            class="flex-grow flex flex-col min-w-0">
            <!-- Header -->
            <header
                class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-40 flex flex-col transition-all duration-300">
                
                {{-- Top Row Header --}}
                <div class="h-20 flex items-center justify-between px-4 md:px-8 w-full">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-200/60 hover:bg-slate-100 flex items-center justify-center text-slate-500 hover:text-blue-600 transition duration-200 shadow-sm">
                            <i class="bi bi-list text-xl"></i>
                        </button>
                        <h2 class="text-lg font-bold text-slate-900 tracking-tight">@yield('page_title', 'Dashboard')</h2>
                    </div>
                    <div class="flex items-center gap-5">
                        {{-- Dynamic Database-Backed Notifications --}}
                        @php
                            $notificationsList = [];
                            $idCounter = 1;

                            // 1. Latest Published Article
                            $latestArticle = \App\Models\Article::latest()->first();
                            if ($latestArticle) {
                                $notificationsList[] = [
                                    'id' => $idCounter++,
                                    'type' => 'system',
                                    'text' => 'Artikel baru "' . $latestArticle->title . '" berhasil disimpan / diterbitkan!',
                                    'time' => $latestArticle->created_at->diffForHumans(),
                                    'is_read' => false
                                ];
                            }

                            // 2. Latest Created Category
                            $latestCategory = \App\Models\Category::latest()->first();
                            if ($latestCategory) {
                                $notificationsList[] = [
                                    'id' => $idCounter++,
                                    'type' => 'comment',
                                    'text' => 'Kategori baru "' . $latestCategory->name . '" sukses terdaftar di portal.',
                                    'time' => $latestCategory->created_at->diffForHumans(),
                                    'is_read' => false
                                ];
                            }

                            // 3. Total Articles Milestone
                            $totalArticles = \App\Models\Article::count();
                            if ($totalArticles > 0) {
                                $notificationsList[] = [
                                    'id' => $idCounter++,
                                    'type' => 'stats',
                                    'text' => 'Luar biasa! Portal Anda kini aktif mengudara dengan ' . $totalArticles . ' artikel.',
                                    'time' => 'Terbaru',
                                    'is_read' => false
                                ];
                            }
                        @endphp

                        <div class="relative" x-data="{ 
                            isOpen: false,
                            notifications: {{ json_encode($notificationsList) }},
                            get unreadCount() {
                                return this.notifications.filter(n => !n.is_read).length;
                            },
                            markAllAsRead() {
                                this.notifications.forEach(n => n.is_read = true);
                            }
                        }" @click.away="isOpen = false">
                            
                            {{-- Bell Button --}}
                            <button @click="isOpen = !isOpen"
                                class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-200/60 hover:bg-slate-100 flex items-center justify-center text-slate-500 hover:text-blue-600 transition duration-200 shadow-sm relative">
                                <i class="bi bi-bell text-lg"></i>
                                {{-- Red dot indicator --}}
                                <span x-show="unreadCount > 0"
                                    class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-rose-500 rounded-full border border-white animate-pulse"></span>
                            </button>

                            {{-- Notifications Dropdown Menu --}}
                            <div x-show="isOpen" 
                                x-transition:enter="transition ease-out duration-250 transform origin-top-right"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150 transform origin-top-right"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                class="absolute right-0 mt-2.5 w-80 bg-white rounded-xl shadow-[0_12px_40px_rgba(0,0,0,0.12)] border border-slate-150/60 z-50 overflow-hidden"
                                x-cloak>
                                
                                {{-- Header --}}
                                <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                                    <span class="font-bold text-slate-800 text-sm flex items-center gap-1.5">
                                        Notifikasi
                                        <span x-show="unreadCount > 0" class="bg-blue-100 text-blue-700 text-[10px] font-extrabold px-2 py-0.5 rounded-full" x-text="unreadCount"></span>
                                    </span>
                                    <button x-show="unreadCount > 0" @click="markAllAsRead()" class="text-xs font-bold text-blue-600 hover:text-blue-700 hover:underline">
                                        Tandai semua dibaca
                                    </button>
                                </div>

                                {{-- List --}}
                                <div class="max-h-[300px] overflow-y-auto divide-y divide-slate-100 custom-scrollbar">
                                    <template x-for="item in notifications" :key="item.id">
                                        <div class="p-4 hover:bg-slate-50/50 transition duration-150 flex gap-3 relative group"
                                            :class="!item.is_read ? 'bg-blue-50/20' : ''">
                                            
                                            {{-- Icon based on type --}}
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                                :class="{
                                                    'bg-blue-50 text-blue-600': item.type === 'comment',
                                                    'bg-amber-50 text-amber-600': item.type === 'stats',
                                                    'bg-emerald-50 text-emerald-600': item.type === 'system'
                                                }">
                                                <i class="bi" :class="{
                                                    'bi-chat-left-text-fill': item.type === 'comment',
                                                    'bi-trophy-fill': item.type === 'stats',
                                                    'bi-check-circle-fill': item.type === 'system'
                                                }"></i>
                                            </div>

                                            {{-- Text & Time --}}
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-semibold text-slate-700 leading-snug break-words" :class="!item.is_read ? 'text-slate-850' : 'text-slate-500'" x-text="item.text"></p>
                                                <span class="text-[10px] font-medium text-slate-400 mt-1 block" x-text="item.time"></span>
                                            </div>

                                            {{-- Unread Blue Dot --}}
                                            <span x-show="!item.is_read" class="absolute right-4 top-1/2 -translate-y-1/2 w-2 h-2 bg-blue-600 rounded-full"></span>
                                        </div>
                                    </template>

                                    <div x-show="notifications.length === 0" class="py-12 text-center text-slate-400 text-xs italic">
                                        Tidak ada notifikasi baru.
                                    </div>
                                </div>

                                {{-- Footer --}}
                                <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/30 text-center">
                                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Ayo Behacaar Portal</span>
                                </div>
                            </div>
                        </div>

                        <div class="h-6 w-[1px] bg-slate-200"></div>

                        <form method="POST" action="{{ route('logout') }}" id="logout-form-desktop" class="hidden sm:block">
                            @csrf
                            <button type="button" onclick="confirmLogout('logout-form-desktop')"
                                class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 hover:bg-rose-50 border border-slate-100 hover:border-rose-100 text-xs font-bold text-slate-600 hover:text-rose-600 transition duration-200">
                                <span>Keluar</span>
                                <i class="bi bi-box-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Mobile Dropdown Menu --}}
                <div x-show="sidebarOpen" class="lg:hidden border-t border-slate-100 px-6 py-4 pb-6 space-y-5 bg-white shadow-lg"
                    x-transition:enter="transition ease-out duration-300 transform origin-top"
                    x-transition:enter-start="opacity-0 -translate-y-4 scale-y-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-y-100"
                    x-transition:leave="transition ease-in duration-200 transform origin-top"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-y-100"
                    x-transition:leave-end="opacity-0 -translate-y-4 scale-y-95"
                    x-cloak>
                    
                    {{-- Nav Items --}}
                    <div class="space-y-1">
                        @php
                            $mobileNavs = [
                                ['route' => 'admin.dashboard', 'icon' => 'bi-speedometer2', 'label' => 'Dashboard'],
                                ['route' => 'admin.categories', 'icon' => 'bi-grid-3x3-gap', 'label' => 'Kategori'],
                                ['route' => 'admin.articles', 'icon' => 'bi-file-earmark-richtext', 'label' => 'Artikel'],
                                ['route' => 'admin.settings', 'icon' => 'bi-gear', 'label' => 'Pengaturan'],
                            ];
                        @endphp
                        
                        @foreach ($mobileNavs as $item)
                            <a href="{{ route($item['route']) }}"
                                class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs($item['route']) ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                                <i class="bi {{ $item['icon'] }} text-lg"></i>
                                <span class="text-sm">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>

                    {{-- User Profile Card --}}
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between px-2">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 group text-decoration-none">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-extrabold shadow-sm group-hover:scale-105 transition">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800 leading-none group-hover:text-blue-600 transition">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1.5 flex items-center gap-1">
                                    <span>Administrator</span>
                                    <i class="bi bi-pencil-square text-xs text-slate-400 group-hover:text-blue-600 transition"></i>
                                </p>
                            </div>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile">
                            @csrf
                            <button type="button" onclick="confirmLogout('logout-form-mobile')"
                                class="px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 border border-rose-100 hover:border-rose-200 text-xs font-bold text-rose-600 transition duration-200 flex items-center gap-1.5 shadow-sm">
                                <span>Keluar</span>
                                <i class="bi bi-box-arrow-right"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="p-4 md:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- SweetAlert Session Flash Overlays -->
    @if(session('welcome'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Selamat Datang!',
                    text: "{{ session('welcome') }}",
                    icon: 'success',
                    showConfirmButton: true,
                    confirmButtonText: 'Masuk Dashboard',
                    confirmButtonColor: '#2563eb',
                    background: '#ffffff',
                    color: '#1e293b',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-100 p-6',
                        confirmButton: 'px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 hover:scale-[1.02]'
                    }
                });
            });
        </script>
    @endif

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    background: '#ffffff',
                    color: '#1e293b',
                    customClass: {
                        popup: 'rounded-2xl shadow-xl border border-slate-100 p-6'
                    }
                });
            });
        </script>
    @endif

    <!-- Logout Confirmation Script -->
    <script>
        function confirmLogout(formId) {
            Swal.fire({
                html: `
                    <div class="text-center p-1">
                        <div class="mx-auto w-16 h-16 rounded-full bg-rose-50 border border-rose-100/40 flex items-center justify-center shrink-0 shadow-sm mb-4">
                            <i class="bi bi-box-arrow-right text-rose-500 text-3xl leading-none flex items-center justify-center"></i>
                        </div>
                        <div class="flex flex-col gap-2">
                            <h3 class="text-xl font-bold text-slate-800 tracking-tight leading-snug">Apakah Anda yakin?</h3>
                            <p class="text-slate-500 text-sm leading-relaxed font-medium px-2">Anda akan keluar dari sesi administrator.</p>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-3xl border border-slate-100/80 p-8 shadow-2xl bg-white max-w-md w-full',
                    actions: 'flex justify-center gap-3 mt-6 w-full',
                    confirmButton: 'px-8 py-3 rounded-2xl font-semibold text-sm bg-rose-600 hover:bg-[#BE123C] text-white transition duration-200 outline-none shadow-sm hover:shadow-md active:scale-95 cursor-pointer',
                    cancelButton: 'px-8 py-3 rounded-2xl font-semibold text-sm bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-800 transition duration-200 outline-none active:scale-95 cursor-pointer border border-slate-200/40 shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>

    @livewireScripts
    @stack('scripts')
</body>

</html>
