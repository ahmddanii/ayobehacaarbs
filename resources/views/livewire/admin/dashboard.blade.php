<div>
    <!-- Stat Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Artikel Card -->
        <div class="bg-white p-6 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-slate-100 relative overflow-hidden group hover:shadow-[0_20px_40px_rgba(37,99,235,0.06)] hover:scale-[1.02] transition-all duration-300">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-gradient-to-tr from-blue-500 to-indigo-500 rounded-full opacity-10 blur-xl group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-wider">Total Artikel</p>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm">
                        <i class="bi bi-file-earmark-richtext-fill text-lg"></i>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-4xl font-extrabold text-slate-800 tracking-tight">{{ $total_articles }}</h3>
                        <span class="text-emerald-500 font-bold text-xs">Aktif</span>
                    </div>
                    <p class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-slate-400">
                        <i class="bi bi-check-circle-fill text-emerald-500"></i>
                        Semua terbit publik
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Kategori Card -->
        <div class="bg-white p-6 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-slate-100 relative overflow-hidden group hover:shadow-[0_20px_40px_rgba(168,85,247,0.06)] hover:scale-[1.02] transition-all duration-300">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-gradient-to-tr from-purple-500 to-fuchsia-500 rounded-full opacity-10 blur-xl group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-wider">Total Kategori</p>
                    <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shadow-sm">
                        <i class="bi bi-grid-3x3-gap-fill text-lg"></i>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-4xl font-extrabold text-slate-800 tracking-tight">{{ $total_categories }}</h3>
                        <span class="text-purple-500 font-bold text-xs">Topik</span>
                    </div>
                    <p class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-slate-400">
                        <i class="bi bi-tags-fill text-purple-400"></i>
                        Navigasi tertata
                    </p>
                </div>
            </div>
        </div>

        <!-- Pengunjung Card -->
        <div class="bg-white p-6 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-slate-100 relative overflow-hidden group hover:shadow-[0_20px_40px_rgba(16,185,129,0.06)] hover:scale-[1.02] transition-all duration-300">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-gradient-to-tr from-emerald-500 to-teal-500 rounded-full opacity-10 blur-xl group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-wider">Total Kunjungan Artikel</p>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-sm">
                        <i class="bi bi-eye-fill text-lg"></i>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-4xl font-extrabold text-slate-800 tracking-tight">{{ number_format($total_views) }}</h3>
                        <span class="text-emerald-500 font-bold text-xs">Riil</span>
                    </div>
                    <p class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-slate-400">
                        <i class="bi bi-graph-up text-emerald-500"></i>
                        Pembaca aktif terakumulasi
                    </p>
                </div>
            </div>
        </div>

        <!-- Komentar Card -->
        <div class="bg-white p-6 rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.02)] border border-slate-100 relative overflow-hidden group hover:shadow-[0_20px_40px_rgba(249,115,22,0.06)] hover:scale-[1.02] transition-all duration-300">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-gradient-to-tr from-orange-500 to-amber-500 rounded-full opacity-10 blur-xl group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 flex flex-col h-full justify-between">
                <div class="flex justify-between items-start mb-4">
                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-wider">Artikel Terpopuler</p>
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center shadow-sm">
                        <i class="bi bi-trophy-fill text-lg"></i>
                    </div>
                </div>
                <div>
                    @if($top_article)
                        <h4 class="text-sm font-bold text-slate-800 line-clamp-1 leading-snug tracking-tight mb-2">{{ $top_article->title }}</h4>
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ number_format($top_article->views_count) }}</span>
                            <span class="text-orange-500 font-bold text-xs">Pembaca</span>
                        </div>
                    @else
                        <h3 class="text-4xl font-extrabold text-slate-800 tracking-tight">-</h3>
                    @endif
                    <p class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-slate-400">
                        <i class="bi bi-star-fill text-orange-400"></i>
                        Rating teratas portal
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Latest Articles Table -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 md:p-8 border-b border-slate-50 flex items-center justify-between">
                    <div>
                        <h4 class="font-extrabold text-slate-850 text-lg tracking-tight">Artikel Terbaru</h4>
                        <p class="text-slate-400 text-xs mt-0.5">Daftar tulisan yang baru saja diterbitkan</p>
                    </div>
                    <a href="{{ route('admin.articles') }}" class="px-4 py-2 bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-100 text-xs font-bold text-blue-600 rounded-xl transition duration-200">
                        Lihat Semua
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50/50 text-[10px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-50">
                            <tr>
                                <th class="px-8 py-4">Judul Artikel</th>
                                <th class="px-8 py-4">Kategori</th>
                                <th class="px-8 py-4">Pembaca</th>
                                <th class="px-8 py-4">Status</th>
                                <th class="px-8 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($latest_articles as $article)
                                <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-8 rounded-lg bg-slate-100 overflow-hidden border border-slate-200/50 shrink-0">
                                                @if($article->image)
                                                    <img src="{{ asset('storage/' . $article->image) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                        <i class="bi bi-image text-xs"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800 text-sm line-clamp-1 leading-snug">{{ $article->title }}</p>
                                                <p class="text-[10px] text-slate-400 mt-0.5 font-medium truncate max-w-xs">{{ $article->slug }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-4">
                                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded-full uppercase tracking-wider">
                                            {{ $article->category->name ?? 'Kategori' }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4">
                                        <span class="text-slate-500 font-bold text-xs flex items-center gap-1">
                                            <i class="bi bi-eye text-sm"></i>
                                            {{ number_format($article->views_count) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-4">
                                        <span class="flex items-center gap-1.5 text-xs text-emerald-600 font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Terbit
                                        </span>
                                    </td>
                                    <td class="px-8 py-4 text-right">
                                        <a href="{{ route('admin.articles') }}" class="inline-flex w-8 h-8 rounded-lg bg-slate-50 hover:bg-blue-50 text-slate-400 hover:text-blue-600 transition duration-200 items-center justify-center">
                                            <i class="bi bi-arrow-right-short text-xl leading-none"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-12 text-center text-slate-400 font-medium italic">Belum ada artikel yang ditambahkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="p-4 bg-slate-50/20 border-t border-slate-50 text-center shrink-0">
                <p class="text-[10px] text-slate-400 font-semibold">Menampilkan 5 entri artikel teratas</p>
            </div>
        </div>

        <!-- Recent Activity Column -->
        <div class="bg-white rounded-xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] p-6 md:p-8">
            <h4 class="font-extrabold text-slate-850 text-lg tracking-tight mb-6">Aktivitas Terakhir</h4>
            
            <div class="relative pl-6 border-l-2 border-slate-100 space-y-6">
                <!-- Activity Item 1 -->
                <div class="relative">
                    <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-blue-50 border-4 border-blue-500 ring-4 ring-white shrink-0"></div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">Artikel baru ditambahkan</p>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Membuat artikel teknologi berkelanjutan.</p>
                        <span class="text-[10px] text-slate-400 font-semibold block mt-1"><i class="bi bi-clock mr-1"></i>2 jam yang lalu</span>
                    </div>
                </div>

                <!-- Activity Item 2 -->
                <div class="relative">
                    <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-purple-50 border-4 border-purple-500 ring-4 ring-white shrink-0"></div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">Kategori baru dibuat</p>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Menambahkan kategori "Tips & Trik".</p>
                        <span class="text-[10px] text-slate-400 font-semibold block mt-1"><i class="bi bi-clock mr-1"></i>5 jam yang lalu</span>
                    </div>
                </div>

                <!-- Activity Item 3 -->
                <div class="relative">
                    <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-emerald-50 border-4 border-emerald-500 ring-4 ring-white shrink-0"></div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">Login Sistem Terdeteksi</p>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Sesi administrator dimulai dari IP local.</p>
                        <span class="text-[10px] text-slate-400 font-semibold block mt-1"><i class="bi bi-clock mr-1"></i>1 hari yang lalu</span>
                    </div>
                </div>

                <!-- Activity Item 4 -->
                <div class="relative">
                    <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-amber-50 border-4 border-amber-500 ring-4 ring-white shrink-0"></div>
                    <div>
                        <p class="text-sm font-bold text-slate-800">Update Password Profil</p>
                        <p class="text-xs text-slate-500 font-medium mt-0.5">Password diubah demi alasan keamanan berkala.</p>
                        <span class="text-[10px] text-slate-400 font-semibold block mt-1"><i class="bi bi-clock mr-1"></i>2 hari yang lalu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
