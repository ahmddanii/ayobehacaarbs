@extends('layouts.main')

@section('title', 'Tentang Kami - Ayo Behacaar')

@section('content')
<x-cinematic-header
    :image="asset('assets/img/17.jpg')"
    badge="Mengenal Kami"
    title="ABOUT"
>
    <div class="w-24 h-1.5 bg-blue-500/50 mx-auto rounded-full backdrop-blur-sm mt-6"></div>
</x-cinematic-header>

<main class="py-20">
    <article class="max-w-[720px] mx-auto px-6">
        <!-- Origin Story -->
        <section class="mb-20" data-aos="fade-up">
            <div class="bg-white p-8 md:p-12 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 opacity-5 w-32 h-32 -mt-4 -mr-4">
                    <i class="bi bi-quote text-9xl"></i>
                </div>
                <div class="flex justify-center mb-8 relative z-10">
                    <img src="{{ asset('assets/img/ayobehacaar.png') }}" alt="Ayo Behacaar" class="w-[140px] md:w-[180px] h-auto">
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-6 text-center tracking-tight relative z-10">Filosofi Nama</h2>
                <p class="text-lg md:text-xl text-slate-600 leading-relaxed text-center italic font-serif relative z-10">
                    "Nama ayobehacaar berasal dari bahasa dayak tunjung 'behacaar' yang berarti 'belajar' bila kedua suku kata ini digabungkan maka akan memiliki arti 'ayo belajar!'"
                </p>
            </div>
        </section>

        <!-- Mission & Vision Content -->
        <section class="space-y-12" data-aos="fade-up" data-aos-delay="100">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-blue-600 mb-6 tracking-tight">Membangun Masa Depan Melalui Pembelajaran</h2>
                <p class="text-base md:text-lg text-slate-700 mb-6 leading-relaxed">
                    Ayo Behacaar hadir sebagai jembatan intelektual di era digital. Berakar dari nilai-nilai luhur budaya Kalimantan, khususnya suku Dayak Tunjung, kami membawa semangat belajar yang inklusif dan modern kepada masyarakat luas. Kami percaya bahwa setiap individu memiliki potensi tanpa batas yang dapat diasah melalui edukasi yang tepat.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6">
                <div class="p-8 bg-white border border-slate-200 rounded-2xl hover:shadow-lg transition-shadow duration-300 group">
                    <div class="text-blue-600 mb-6 bg-blue-50 w-16 h-16 flex items-center justify-center rounded-full group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <i class="bi bi-lightbulb text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Modernitas</h3>
                    <p class="text-slate-600 leading-relaxed">Menyajikan konten edukatif dengan pendekatan teknologi terkini yang relevan dengan kebutuhan industri masa kini.</p>
                </div>
                
                <div class="p-8 bg-white border border-slate-200 rounded-2xl hover:shadow-lg transition-shadow duration-300 group">
                    <div class="text-blue-600 mb-6 bg-blue-50 w-16 h-16 flex items-center justify-center rounded-full group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <i class="bi bi-people text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Komunitas</h3>
                    <p class="text-slate-600 leading-relaxed">Membangun ekosistem belajar yang suportif di mana setiap orang dapat berbagi pengetahuan dan pengalaman.</p>
                </div>
            </div>

            <p class="text-base md:text-lg text-slate-700 leading-relaxed border-l-4 border-blue-600 pl-6 py-2 bg-blue-50/50 rounded-r-xl">
                Sebagai platform yang mengedepankan kualitas konten editorial, Ayo Behacaar berkomitmen untuk menyediakan sumber daya pembelajaran yang terkurasi. Dari literasi teknologi hingga pengembangan diri, kami merancang setiap artikel dan program kami untuk memberikan wawasan yang jernih dan dapat segera dipraktikkan.
            </p>
        </section>

        <!-- Social Media & Connect -->
        <section class="mt-20 pt-16 border-t border-slate-200 text-center" data-aos="fade-up" data-aos-delay="200">
            <h2 class="text-2xl font-bold text-slate-900 mb-10 tracking-tight">Hubungkan Dengan Kami</h2>
            
            <div class="flex justify-center gap-6 md:gap-12">
                <a href="https://www.instagram.com/sainsaa__" target="_blank" class="group flex flex-col items-center gap-4">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-gradient-to-tr group-hover:from-yellow-400 group-hover:via-pink-500 group-hover:to-purple-600 group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-lg transform group-hover:-translate-y-2">
                        <i class="bi bi-instagram text-2xl md:text-3xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-500 group-hover:text-slate-900 transition-colors">Instagram</span>
                </a>
                
                <a href="https://www.youtube.com/@ayobehacaar" target="_blank" class="group flex flex-col items-center gap-4">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-red-600 group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-lg transform group-hover:-translate-y-2">
                        <i class="bi bi-youtube text-2xl md:text-3xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-500 group-hover:text-slate-900 transition-colors">YouTube</span>
                </a>
                
                <a href="http://www.tiktok.com/@ayobehacaar" target="_blank" class="group flex flex-col items-center gap-4">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-black group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-lg transform group-hover:-translate-y-2">
                        <i class="bi bi-tiktok text-2xl md:text-3xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-500 group-hover:text-slate-900 transition-colors">TikTok</span>
                </a>
            </div>
            
            <div class="mt-20 text-xs font-bold text-slate-400 tracking-[0.3em] uppercase">
                AyoBehacaar Platform &bull; Est. 2023
            </div>
        </section>
    </article>
</main>
@endsection
