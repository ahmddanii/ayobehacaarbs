@props([
    'image',
    'badge',
    'title',
    'description' => null,
])

<header class="relative w-full h-[400px] md:h-[450px] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ $image }}')">
        <div class="absolute inset-0 bg-slate-900/60 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-blue-900/20"></div>
        <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-slate-50 dark:from-slate-950 via-slate-50/80 dark:via-slate-950/80 to-transparent"></div>
    </div>
    <div class="relative z-10 text-center px-6 container mx-auto">
        <span class="inline-block py-1.5 px-4 rounded-full bg-blue-500/20 text-blue-300 text-xs font-bold uppercase tracking-[0.2em] mb-6 backdrop-blur-md border border-blue-400/30">
            {{ $badge }}
        </span>
        <h1 class="text-5xl md:text-6xl lg:text-7xl text-white font-black drop-shadow-2xl tracking-tight mb-4">
            {{ $title }}
        </h1>
        @if($description)
            <p class="text-slate-100 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed font-medium drop-shadow-md">
                {{ $description }}
            </p>
        @endif
        {{ $slot }}
    </div>
</header>
