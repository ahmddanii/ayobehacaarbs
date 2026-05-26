@extends('layouts.main')

@section('title', 'Ayo Behacaar - Platform Belajar Masa Kini')

@section('meta_description', $settings->tagline)

@section('content')
<main class="container mx-auto px-6 md:px-8 lg:px-12 my-6">

    {{-- Hero Carousel --}}
    <div class="swiper main-carousel rounded-2xl overflow-hidden shadow-xl mb-12 relative group">
        <div class="swiper-wrapper">
            @foreach($slides as $slide)
            <div class="swiper-slide relative">
                @if($slide->image)
                    <img src="{{ asset('storage/' . $slide->image) }}" alt="{{ $slide->title }}" class="w-full h-[400px] md:h-[550px] object-cover">
                @else
                    <img src="{{ asset('assets/img/13.jpg') }}" alt="Default Slide" class="w-full h-[400px] md:h-[550px] object-cover">
                @endif

                {{-- Gradient Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>

                {{-- Slide Content --}}
                <div class="absolute inset-0 flex flex-col justify-end p-8 md:p-12 lg:p-16 z-10 w-full lg:w-4/5">
                    <div class="mb-4 md:mb-6">
                        <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                            {{ $slide->category->name ?? 'Artikel' }}
                        </span>
                    </div>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight lg:leading-tight">
                        {{ $slide->clean_title }}
                    </h2>
                    <p class="text-gray-200 text-sm md:text-base lg:text-lg mb-8 max-w-2xl line-clamp-3 md:line-clamp-none">
                        {{ Str::limit($slide->clean_content, 160) }}
                    </p>
                    <div class="flex items-center gap-6">
                        <a href="{{ route('articles.show', $slide->slug) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 md:py-3 px-6 md:px-8 rounded-xl transition shadow-lg hover:shadow-xl">
                            Mulai Membaca
                        </a>
                        <div class="flex items-center text-gray-300 gap-2 font-medium">
                            <i class="bi bi-clock text-lg"></i>
                            @php
                                $wordCount = count(explode(' ', strip_tags($slide->content)));
                                $readTime = max(1, ceil($wordCount / 150));
                            @endphp
                            <span class="text-sm">{{ $readTime }} Menit Baca</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Navigation Arrows --}}
        <div class="absolute bottom-8 right-8 z-20 flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="swiper-button-prev-custom w-10 h-10 md:w-12 md:h-12 rounded-full border border-gray-400 text-white flex items-center justify-center hover:bg-white/20 transition cursor-pointer backdrop-blur-sm">
                <i class="bi bi-arrow-left text-lg md:text-xl"></i>
            </div>
            <div class="swiper-button-next-custom w-10 h-10 md:w-12 md:h-12 rounded-full border border-gray-400 text-white flex items-center justify-center hover:bg-white/20 transition cursor-pointer backdrop-blur-sm">
                <i class="bi bi-arrow-right text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    {{-- Artikel Terbaru --}}
    <section class="mb-16" id="artikel-terbaru">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h1 class="font-bold text-3xl md:text-4xl text-slate-900 dark:text-white font-sans mb-4 md:mb-0">
                @if(request('filter') === 'populer')
                    Artikel Terpopuler
                @elseif(request('filter') === 'terlama')
                    Artikel Terlama
                @else
                    Artikel Terbaru
                @endif
            </h1>
            <div class="flex gap-2">
                <a href="{{ route('home', ['filter' => 'semua']) }}#artikel-terbaru"
                    class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('filter', 'semua') === 'semua' ? 'bg-blue-600 text-white shadow-sm font-semibold' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800' }}">Semua</a>
                <a href="{{ route('home', ['filter' => 'populer']) }}#artikel-terbaru"
                    class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('filter') === 'populer' ? 'bg-blue-600 text-white shadow-sm font-semibold' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800' }}">Populer</a>
                <a href="{{ route('home', ['filter' => 'terlama']) }}#artikel-terbaru"
                    class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ request('filter') === 'terlama' ? 'bg-blue-600 text-white shadow-sm font-semibold' : 'bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800' }}">Terlama</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            @foreach($latest_articles as $article)
                <x-article-card :article="$article" />
            @endforeach
        </div>

        <div class="flex justify-center">
            <a href="{{ route('articles.index') }}" class="px-6 py-2.5 bg-white dark:bg-slate-900 border border-blue-600 dark:border-blue-500/30 text-blue-600 dark:text-blue-400 font-semibold rounded-lg hover:bg-blue-50 dark:hover:bg-slate-800/80 transition-colors duration-300 shadow-sm">
                Muat Lebih Banyak Artikel
            </a>
        </div>
    </section>

    {{-- Kategori --}}
    <section class="mb-16">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8">
            <div>
                <h1 class="font-bold text-3xl md:text-4xl text-slate-900 dark:text-white mb-2 font-sans">Kategori</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm md:text-base">Eksplorasi topik pilihan kami</p>
            </div>
            <a href="{{ route('categories.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm mt-4 md:mt-0 flex items-center gap-1 transition-colors">
                Lihat Semua <i class="bi bi-chevron-right text-xs"></i>
            </a>
        </div>

        <div class="swiper category-carousel pb-2">
            <div class="swiper-wrapper">
                @foreach($categories as $c)
                <div class="swiper-slide">
                    <a href="{{ route('articles.index', ['category' => $c->slug]) }}" class="relative block overflow-hidden rounded-xl shadow-sm aspect-[4/3] md:aspect-[3/2] group" data-aos="fade-up">
                        @if($c->image)
                            <img src="{{ asset('storage/' . $c->image) }}" alt="{{ $c->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <img src="{{ asset('assets/img/11.jpg') }}" alt="Default" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent opacity-90 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <div class="absolute inset-0 p-5 md:p-6 flex flex-col justify-end">
                            <h3 class="text-white font-medium text-lg md:text-xl tracking-wide">{{ $c->name }}</h3>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.main-carousel', {
            loop: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            effect: 'fade',
            fadeEffect: { crossFade: true },
            navigation: {
                nextEl: '.swiper-button-next-custom',
                prevEl: '.swiper-button-prev-custom',
            },
        });

        new Swiper('.category-carousel', {
            slidesPerView: 1.2,
            spaceBetween: 16,
            breakpoints: {
                768:  { slidesPerView: 2.2, spaceBetween: 24 },
                1024: { slidesPerView: 3,   spaceBetween: 24 },
            },
        });
    });
</script>
@endpush
@endsection
