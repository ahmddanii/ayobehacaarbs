@props(['article'])

<article class="bg-[#fcfcfc] dark:bg-slate-900/40 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800/80 overflow-hidden flex flex-col group transition-all duration-300 hover:shadow-lg hover:-translate-y-1" data-aos="fade-up">
    {{-- Card Image --}}
    <div class="relative block overflow-hidden aspect-video">
        <span class="absolute top-4 left-4 bg-blue-600 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-widest z-10">
            {{ $article->category->name ?? 'TEKNOLOGI' }}
        </span>
        
        <!-- Floating Bookmark Trigger (AlpineJS Global Store) -->
        <button 
            @click.prevent="$store.bookmarksStore.toggle({ id: {{ $article->id }}, title: '{{ addslashes($article->clean_title) }}', slug: '{{ $article->slug }}', category: '{{ $article->category->name ?? 'Artikel' }}', date: '{{ $article->created_at->format('d M Y') }}', image: '{{ $article->image ? smart_image_url($article->image) : asset('assets/img/12.jpg') }}' })"
            class="absolute top-3 right-3 z-20 w-8 h-8 rounded-full bg-slate-900/60 dark:bg-slate-950/70 backdrop-blur-md border border-white/20 dark:border-slate-800 text-white flex items-center justify-center hover:scale-110 transition duration-300 focus:outline-none"
            :title="$store.bookmarksStore.isBookmarked({{ $article->id }}) ? 'Hapus dari Daftar Bacaan' : 'Simpan ke Daftar Bacaan'">
            <i :class="$store.bookmarksStore.isBookmarked({{ $article->id }}) ? 'bi bi-bookmark-heart-fill text-red-500' : 'bi bi-bookmark-heart text-white'"></i>
        </button>

        <a href="{{ route('articles.show', $article->slug) }}" class="w-full h-full block">
            @if($article->image)
                <img src="{{ smart_image_url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            @else
                <img src="{{ asset('assets/img/12.jpg') }}" alt="Default" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
            @endif
        </a>
    </div>

    {{-- Card Content --}}
    <div class="p-6 space-y-3 flex-grow flex flex-col">
        <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
            <span class="text-xs font-medium">{{ $article->created_at->format('d M Y') }}</span>
            <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
            <span class="text-xs font-medium">Oleh {{ $article->user->name ?? 'Admin' }}</span>
        </div>
        <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2 leading-tight">
            <a href="{{ route('articles.show', $article->slug) }}">{{ $article->clean_title }}</a>
        </h3>
        <p class="text-slate-600 dark:text-slate-300 text-sm line-clamp-3 leading-relaxed flex-grow">
            {{ Str::limit($article->clean_content, 120) }}
        </p>
        <a href="{{ route('articles.show', $article->slug) }}" class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 font-bold text-sm pt-2 transition-colors">
            Baca Selengkapnya <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</article>
