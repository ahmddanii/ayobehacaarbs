@extends('layouts.main')

@section('title', 'Artikel - Ayo Behacaar')

@section('meta_description', 'Temukan kumpulan artikel terbaru, tutorial, wawasan baru, dan pembelajaran terkurasi dari Ayo Behacaar.')
@section('meta_image', $settings->article_hero_image ? asset('storage/' . $settings->article_hero_image) : asset('assets/img/18.jpg'))

@section('content')
<x-cinematic-header
    :image="$settings->article_hero_image ? asset('storage/' . $settings->article_hero_image) : asset('assets/img/18.jpg')"
    badge="Kumpulan Tulisan"
    title="ARTIKEL"
    description="Baca dan temukan berbagai wawasan, perspektif baru, dan informasi menarik yang kami kurasi khusus untuk Anda."
/>

<main id="kumpulan-artikel" class="container mx-auto px-6 md:px-8 lg:px-12 py-8 scroll-mt-24">

    {{-- Filter & Search --}}
    <div class="flex flex-col my-8 gap-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight font-sans">
                {{ request('category') ? optional($categories->where('slug', request('category'))->first())->name ?? 'Semua Artikel' : 'Semua Artikel' }}
            </h2>

            <form action="{{ route('articles.index') }}#kumpulan-artikel" method="GET" class="relative w-full lg:w-[400px] group">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari topik, judul, atau konten..."
                    class="w-full pl-12 pr-6 py-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none transition duration-300 font-medium text-slate-700 dark:text-slate-300 shadow-sm">
                <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 group-focus-within:text-blue-600 dark:group-focus-within:text-blue-400 transition duration-300">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        {{-- Category Filter Pills --}}
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('articles.index', ['search' => request('search')]) }}#kumpulan-artikel"
                class="px-4 py-2 rounded-full text-sm font-bold transition-all {{ !request('category') ? 'bg-blue-600 text-white shadow-md' : 'bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('articles.index', ['category' => $cat->slug, 'search' => request('search')]) }}#kumpulan-artikel"
                    class="px-4 py-2 rounded-full text-sm font-bold transition-all {{ request('category') == $cat->slug ? 'bg-blue-600 text-white shadow-md' : 'bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Articles Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
        @forelse ($articles as $article)
            <x-article-card :article="$article" />
        @empty
            <div class="col-span-full py-16 text-center text-slate-400 font-medium italic">
                Belum ada artikel yang ditambahkan.
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-16 flex justify-center">
        {{ $articles->links() }}
    </div>

</main>
@endsection
