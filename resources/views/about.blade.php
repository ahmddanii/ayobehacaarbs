@extends('layouts.main')

@section('title', 'Tentang Kami - Ayo Behacaar')

@section('meta_description', $settings->description)
@section('meta_image', $settings->about_hero_image ? smart_image_url($settings->about_hero_image) : asset('assets/img/17.jpg'))

@section('content')
<x-cinematic-header
    :image="$settings->about_hero_image ? smart_image_url($settings->about_hero_image) : asset('assets/img/17.jpg')"
    badge="Mengenal Kami"
    title="ABOUT"
>
    <div class="w-24 h-1.5 bg-blue-500/50 mx-auto rounded-full backdrop-blur-sm mt-6"></div>
</x-cinematic-header>

<main class="py-20">
    <article class="max-w-[720px] mx-auto px-6">
        <!-- Origin Story -->
        <section class="mb-20" data-aos="fade-up">
            <div class="bg-white dark:bg-slate-900/40 p-8 md:p-12 rounded-2xl border border-slate-200 dark:border-slate-800/80 shadow-sm relative overflow-hidden transition-colors duration-300">
                <div class="absolute top-0 right-0 opacity-5 dark:opacity-10 w-32 h-32 -mt-4 -mr-4 text-slate-900 dark:text-white">
                    <i class="bi bi-quote text-9xl"></i>
                </div>
                <div class="flex justify-center mb-8 relative z-10">
                    <img src="{{ asset('assets/img/ayobehacaar.png') }}" alt="Ayo Behacaar" class="h-auto w-[140px] md:w-[180px]">
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-6 text-center tracking-tight relative z-10">Filosofi Nama</h2>
                <p class="text-lg md:text-xl text-slate-600 dark:text-slate-350 leading-relaxed text-center italic font-serif relative z-10">
                    "Nama ayobehacaar berasal dari bahasa dayak tunjung 'behacaar' yang berarti 'belajar' bila kedua suku kata ini digabungkan maka akan memiliki arti 'ayo belajar!'"
                </p>
            </div>
        </section>

        <!-- Mission & Vision Content -->
        <section class="space-y-12" data-aos="fade-up" data-aos-delay="100">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-blue-600 dark:text-blue-400 mb-6 tracking-tight">{{ $settings->tagline }}</h2>
                <p class="text-base md:text-lg text-slate-700 dark:text-slate-300 mb-6 leading-relaxed">
                    {{ $settings->description }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6">
                <div class="p-8 bg-white dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800/80 rounded-2xl hover:shadow-lg transition-all duration-300 group">
                    <div class="text-blue-600 dark:text-blue-400 mb-6 bg-blue-50 dark:bg-blue-900/30 w-16 h-16 flex items-center justify-center rounded-full group-hover:bg-blue-600 group-hover:text-white dark:group-hover:text-white transition-colors duration-300">
                        <i class="bi bi-lightbulb text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Modernitas</h3>
                    <p class="text-slate-600 dark:text-slate-350 leading-relaxed">Menyajikan konten edukatif dengan pendekatan teknologi terkini yang relevan dengan kebutuhan industri masa kini.</p>
                </div>
                
                <div class="p-8 bg-white dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800/80 rounded-2xl hover:shadow-lg transition-all duration-300 group">
                    <div class="text-blue-600 dark:text-blue-400 mb-6 bg-blue-50 dark:bg-blue-900/30 w-16 h-16 flex items-center justify-center rounded-full group-hover:bg-blue-600 group-hover:text-white dark:group-hover:text-white transition-colors duration-300">
                        <i class="bi bi-people text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Komunitas</h3>
                    <p class="text-slate-600 dark:text-slate-350 leading-relaxed">Membangun ekosistem belajar yang suportif di mana setiap orang dapat berbagi pengetahuan dan pengalaman.</p>
                </div>
            </div>

            <p class="text-base md:text-lg text-slate-700 dark:text-slate-300 leading-relaxed border-l-4 border-blue-600 dark:border-blue-500 pl-6 py-2 bg-blue-50/50 dark:bg-blue-950/30 rounded-r-xl">
                {{ $settings->about_text }}
            </p>
        </section>

        <!-- Social Media & Connect -->
        <section class="mt-20 pt-16 border-t border-slate-200 dark:border-slate-800 text-center" data-aos="fade-up" data-aos-delay="200">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-10 tracking-tight">Hubungkan Dengan Kami</h2>
            
            <div class="flex justify-center gap-6 md:gap-12">
                @if($settings->instagram_url)
                <a href="{{ $settings->instagram_url }}" target="_blank" class="group flex flex-col items-center gap-4">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-slate-100 dark:bg-slate-900 flex items-center justify-center text-slate-500 dark:text-slate-400 group-hover:bg-gradient-to-tr group-hover:from-yellow-400 group-hover:via-pink-500 group-hover:to-purple-600 group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-lg transform group-hover:-translate-y-2">
                        <i class="bi bi-instagram text-2xl md:text-3xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400 group-hover:text-slate-900 group-hover:dark:text-white transition-colors">Instagram</span>
                </a>
                @endif
                
                @if($settings->youtube_url)
                <a href="{{ $settings->youtube_url }}" target="_blank" class="group flex flex-col items-center gap-4">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-slate-100 dark:bg-slate-900 flex items-center justify-center text-slate-500 dark:text-slate-400 group-hover:bg-red-600 group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-lg transform group-hover:-translate-y-2">
                        <i class="bi bi-youtube text-2xl md:text-3xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400 group-hover:text-slate-900 group-hover:dark:text-white transition-colors">YouTube</span>
                </a>
                @endif
                
                @if($settings->tiktok_url)
                <a href="{{ $settings->tiktok_url }}" target="_blank" class="group flex flex-col items-center gap-4">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-slate-100 dark:bg-slate-900 flex items-center justify-center text-slate-500 dark:text-slate-400 group-hover:bg-black group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-lg transform group-hover:-translate-y-2">
                        <i class="bi bi-tiktok text-2xl md:text-3xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400 group-hover:text-slate-900 group-hover:dark:text-white transition-colors">TikTok</span>
                </a>
                @endif
            </div>
            
            <div class="mt-20 text-xs font-bold text-slate-400 dark:text-slate-500 tracking-[0.3em] uppercase">
                {{ $settings->site_name }} Platform &bull; Est. 2023
            </div>
        </section>
    </article>
</main>
@endsection
