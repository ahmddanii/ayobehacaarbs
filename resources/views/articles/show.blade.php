@extends('layouts.main')

@section('title', $article->title . ' - Ayo Behacaar')

@section('content')
    @push('styles')
        <style>
            .reading-progress-container {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 4px;
                z-index: 1000;
                pointer-events: none;
            }

            #reading-progress-bar {
                height: 100%;
                background-color: #2563eb;
                width: 0%;
                transition: width 0.1s ease-out;
            }

            .preview-content p {
                margin-bottom: 1.5rem;
                line-height: 1.85;
                color: #334155;
                font-size: 1.075rem;
            }

            .preview-content ul,
            .preview-content ol {
                margin-left: 2rem;
                margin-bottom: 1.5rem;
                list-style-type: disc;
            }

            .preview-content ol {
                list-style-type: decimal;
            }

            .preview-content li {
                margin-bottom: 0.5rem;
                color: #334155;
                font-size: 1.075rem;
                line-height: 1.75;
            }

            .preview-content h1,
            .preview-content h2,
            .preview-content h3,
            .preview-content h4 {
                font-weight: 800;
                color: #0f172a;
                margin-top: 2.25rem;
                margin-bottom: 1rem;
                line-height: 1.35;
                letter-spacing: -0.02em;
            }

            .preview-content h1 {
                font-size: 2rem;
            }

            .preview-content h2 {
                font-size: 1.5rem;
                border-left: 4px solid #2563eb;
                padding-left: 0.75rem;
                margin-top: 2.5rem;
            }

            .preview-content h3 {
                font-size: 1.25rem;
            }

            .preview-content h4 {
                font-size: 1.125rem;
            }

            .preview-content code {
                font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
                font-size: 0.9em;
                background-color: #f1f5f9;
                color: #0f172a;
                padding: 0.2em 0.4em;
                border-radius: 0.30rem;
                font-weight: 600;
            }

            .preview-content pre {
                background-color: #0f172a;
                color: #f8fafc;
                padding: 1.25rem;
                border-radius: 0.75rem;
                overflow-x: auto;
                margin: 1.5rem 0;
            }

            .preview-content pre code {
                background-color: transparent;
                color: inherit;
                padding: 0;
                border-radius: 0;
                font-weight: 400;
            }

            .preview-content blockquote {
                border-left: 4px solid #2563eb;
                background-color: #f8fafc;
                padding: 1rem 1.5rem;
                border-radius: 0.5rem;
                margin: 1.5rem 0;
                color: #475569;
                font-style: italic;
            }

            .preview-content blockquote p {
                margin-bottom: 0;
                color: #475569;
                font-style: italic;
            }

            .preview-content mark {
                background-color: #fef08a;
                color: #1e293b;
                padding: 0.15em 0.35em;
                border-radius: 0.25em;
                font-weight: 600;
            }
        </style>
    @endpush

    <div class="reading-progress-container">
        <div id="reading-progress-bar"></div>
    </div>

    <main class="pt-8 pb-20 bg-[#fcfcfc]">
        <!-- Breadcrumb -->
        <div class="container mx-auto px-6 md:px-8 lg:px-12 py-4">
            <nav class="flex mb-6 text-[10px] font-black uppercase tracking-widest text-slate-400" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-blue-600 transition">Beranda</a></li>
                    <li><i class="bi bi-chevron-right opacity-50"></i></li>
                    <li><a href="{{ route('articles.index') }}" class="hover:text-blue-600 transition">Artikel</a></li>
                    <li><i class="bi bi-chevron-right opacity-50"></i></li>
                    <li class="text-slate-600">Detail</li>
                </ol>
            </nav>
        </div>

        <div class="container mx-auto px-6 md:px-8 lg:px-12 grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Article Content Area -->
            <article class="lg:col-span-8">
                <!-- Category Tag -->
                <div class="mb-4">
                    <span
                        class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold uppercase tracking-wider">{{ $article->category->name ?? 'Kategori' }}</span>
                </div>

                <!-- Headline -->
                <h1 class="font-bold text-3xl md:text-4xl lg:text-5xl text-slate-900 mb-6 leading-tight">
                    {{ $article->title }}</h1>

                <!-- Meta Info -->
                <div class="flex flex-wrap items-center gap-6 mb-12 py-4 border-y border-slate-200">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-lg">
                            {{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="text-sm text-slate-900 font-semibold">{{ $article->user->name ?? 'Admin Ayo Behacaar' }}</span>
                            <span class="text-xs text-slate-500">Editor Senior</span>
                        </div>
                    </div>

                    <div class="h-8 w-px bg-slate-200 hidden md:block"></div>

                    <div class="flex flex-col">
                        <span class="text-sm text-slate-600 font-medium">{{ $article->created_at->format('d F Y') }}</span>
                        <span class="text-xs text-slate-500">8 Menit Baca</span>
                    </div>

                    <div class="flex-grow"></div>

                    <!-- Social Share -->
                    <div class="flex gap-2">
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition-colors text-slate-500 hover:text-blue-600">
                            <i class="bi bi-share-fill"></i>
                        </button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-slate-100 transition-colors text-slate-500 hover:text-blue-600">
                            <i class="bi bi-bookmark-fill"></i>
                        </button>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="rounded-xl overflow-hidden mb-12 shadow-sm">
                    @if ($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                            class="w-full aspect-[16/9] object-cover">
                    @else
                        <img src="{{ asset('assets/img/13.jpg') }}" alt="Default"
                            class="w-full aspect-[16/9] object-cover">
                    @endif
                </div>

                <!-- Editorial Content -->
                @php
                    $processedContent = preg_replace('/==(.*?)==/', '<mark>$1</mark>', $article->content);
                @endphp
                <div class="prose prose-lg max-w-[720px] mx-auto text-slate-700 leading-relaxed preview-content">
                    {!! Illuminate\Support\Str::markdown($processedContent) !!}
                </div>

                <!-- Tags Section -->
                <div class="mt-12 pt-8 border-t border-slate-200 flex flex-wrap gap-2">
                    <span class="text-sm text-slate-600 bg-slate-100 px-3 py-1 rounded-full">#LiterasiDigital</span>
                    <span
                        class="text-sm text-slate-600 bg-slate-100 px-3 py-1 rounded-full">#{{ Str::slug($article->category->name ?? 'artikel') }}</span>
                </div>
            </article>

            <!-- Sidebar -->
            <aside class="lg:col-span-4 space-y-12">

                <!-- Related Articles -->
                <div class="space-y-6">
                    <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <i class="bi bi-bookmark-heart-fill text-blue-600"></i> Baca Juga
                    </h3>

                    @forelse($related_articles as $rel)
                        <a href="{{ route('articles.show', $rel->slug) }}"
                            class="group cursor-pointer flex gap-4 items-center">
                            <div class="w-24 h-24 flex-shrink-0 rounded-lg overflow-hidden">
                                @if ($rel->image)
                                    <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <img src="{{ asset('assets/img/11.jpg') }}" alt="Default"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @endif
                            </div>
                            <div class="flex flex-col justify-center">
                                <span
                                    class="text-xs text-blue-600 uppercase font-bold mb-1">{{ $rel->category->name ?? 'Kategori' }}</span>
                                <h4
                                    class="text-sm font-semibold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2">
                                    {{ $rel->clean_title }}</h4>
                            </div>
                        </a>
                    @empty
                        <p class="text-slate-500 text-sm italic">Belum ada artikel terkait.</p>
                    @endforelse
                </div>
            </aside>
        </div>
    </main>

    @push('scripts')
        <script>
            // Reading Progress Logic
            window.addEventListener('scroll', function() {
                let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                let scrolled = (winScroll / height) * 100;
                let bar = document.getElementById("reading-progress-bar");
                if (bar) bar.style.width = scrolled + "%";
            });

            // Micro-interactions
            document.querySelectorAll('button').forEach(btn => {
                btn.addEventListener('mousedown', () => btn.classList.add('scale-95'));
                btn.addEventListener('mouseup', () => btn.classList.remove('scale-95'));
                btn.addEventListener('mouseleave', () => btn.classList.remove('scale-95'));
            });
        </script>
    @endpush
@endsection
