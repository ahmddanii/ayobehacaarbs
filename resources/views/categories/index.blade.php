@extends('layouts.main')

@section('title', 'Kategori - Ayo Behacaar')

@section('content')
    <x-cinematic-header :image="$settings->category_hero_image
        ? asset('storage/' . $settings->category_hero_image)
        : asset('assets/img/14.jpg')" badge="Eksplorasi Topik" title="KATEGORI"
        description="Temukan artikel berkualitas tinggi yang dikurasi khusus berdasarkan minat intelektual dan kebutuhan profesional Anda." />

    <main class="flex-grow">

        {{-- Category Grid --}}
        <section class="container mx-auto px-6 md:px-8 lg:px-12 py-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($categories as $index => $cat)
                    <a href="{{ route('articles.index', ['category' => $cat->slug]) }}"
                        class="group relative overflow-hidden rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 block aspect-[4/3] transform hover:-translate-y-2">
                        @if ($cat->image)
                            <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}"
                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <img src="{{ asset('assets/img/14.jpg') }}" alt="Default"
                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @endif

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/30 to-slate-900/10 opacity-80 group-hover:opacity-100 transition-opacity duration-300">
                        </div>

                        <div class="absolute inset-0 p-6 md:p-8 flex flex-col justify-end">
                            <span
                                class="text-blue-400 font-bold text-xs tracking-widest uppercase mb-2 drop-shadow-md transform translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                Topik {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <h3
                                class="text-2xl md:text-3xl font-semibold text-white drop-shadow-lg mb-2 transform group-hover:-translate-y-1 transition-transform duration-300">
                                {{ $cat->name }}
                            </h3>
                            <p
                                class="text-slate-300 text-sm line-clamp-2 transform translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300 delay-75">
                                Jelajahi kumpulan artikel terbaru seputar topik {{ $cat->name }}.
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-400 dark:text-slate-500 font-medium italic">
                        Belum ada kategori yang ditemukan.
                    </div>
                @endforelse
            </div>
        </section>

    </main>

    @push('scripts')
        <script>
            document.querySelectorAll('.group').forEach(card => {
                card.addEventListener('mousedown', () => card.classList.add('scale-95'));
                card.addEventListener('mouseup', () => card.classList.remove('scale-95'));
                card.addEventListener('mouseleave', () => card.classList.remove('scale-95'));
            });
        </script>
    @endpush
@endsection
