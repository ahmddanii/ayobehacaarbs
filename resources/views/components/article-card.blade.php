@props(['article'])

<article class="bg-[#fcfcfc] rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col group transition-all duration-300 hover:shadow-lg hover:-translate-y-1" data-aos="fade-up">
    {{-- Card Image --}}
    <a href="{{ route('articles.show', $article->slug) }}" class="relative block overflow-hidden aspect-video">
        <span class="absolute top-4 left-4 bg-blue-600 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-widest z-10">
            {{ $article->category->name ?? 'TEKNOLOGI' }}
        </span>
        @if($article->image)
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        @else
            <img src="{{ asset('assets/img/12.jpg') }}" alt="Default" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
        @endif
    </a>

    {{-- Card Content --}}
    <div class="p-6 space-y-3 flex-grow flex flex-col">
        <div class="flex items-center gap-2 text-slate-500">
            <span class="text-xs font-medium">{{ $article->created_at->format('d M Y') }}</span>
            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
            <span class="text-xs font-medium">Oleh {{ $article->user->name ?? 'Admin' }}</span>
        </div>
        <h3 class="text-xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-tight">
            <a href="{{ route('articles.show', $article->slug) }}">{{ $article->clean_title }}</a>
        </h3>
        <p class="text-slate-600 text-sm line-clamp-3 leading-relaxed flex-grow">
            {{ Str::limit($article->clean_content, 120) }}
        </p>
        <a href="{{ route('articles.show', $article->slug) }}" class="inline-flex items-center gap-1 text-blue-600 font-bold text-sm pt-2 transition-colors">
            Baca Selengkapnya <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</article>
