{{-- Article List View (Table) --}}
<div class="bg-white rounded-xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden"
    wire:key="articles-list">

    {{-- Action Header --}}
    <div class="p-6 md:p-8 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="relative w-full sm:w-80 group">
            <input type="text" wire:model.live="search" placeholder="Cari artikel..."
                class="w-full pl-11 pr-5 py-2.5 bg-slate-50 border border-slate-200/60 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white outline-none transition duration-200 font-medium text-sm text-slate-700 placeholder:text-slate-400">
            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition duration-200 text-sm"></i>
        </div>

        <button type="button" wire:click="create"
            class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/35 hover:-translate-y-0.5 transition duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
            <i class="bi bi-plus-lg text-sm"></i> Tulis Artikel
        </button>
    </div>

    {{-- Articles Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50/50 text-[10px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-50">
                <tr>
                    <th class="px-8 py-4">Thumbnail</th>
                    <th class="px-8 py-4">Judul Artikel</th>
                    <th class="px-8 py-4">Kategori</th>
                    <th class="px-8 py-4">Tanggal</th>
                    <th class="px-8 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($articles as $article)
                    <tr class="hover:bg-slate-50/40 transition-colors duration-150">
                        <td class="px-8 py-4">
                            <div class="w-16 h-10 rounded-lg bg-slate-50 overflow-hidden border border-slate-200/45 flex items-center justify-center shrink-0">
                                @if ($article->image)
                                    <img src="{{ asset('storage/' . $article->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-slate-300">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <div>
                                <p class="font-extrabold text-slate-800 text-sm line-clamp-1 leading-snug">{{ $article->title }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5 font-medium truncate max-w-xs">{{ $article->slug }}</p>
                            </div>
                        </td>
                        <td class="px-8 py-4">
                            <span class="px-2.5 py-1 bg-purple-50 text-purple-600 text-[10px] font-bold rounded-full uppercase tracking-wider">
                                {{ $article->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-slate-400 font-semibold text-xs">
                            {{ $article->created_at->format('d M Y') }}
                        </td>
                        <td class="px-8 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="edit({{ $article->id }})"
                                    class="w-9 h-9 rounded-lg bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-100 text-slate-400 hover:text-blue-600 transition duration-200 flex items-center justify-center"
                                    title="Ubah Artikel">
                                    <i class="bi bi-pencil-square text-sm"></i>
                                </button>
                                <button wire:click="confirmDelete({{ $article->id }})"
                                    class="w-9 h-9 rounded-lg bg-slate-50 hover:bg-rose-50 border border-slate-100 hover:border-rose-100 text-slate-400 hover:text-rose-600 transition duration-200 flex items-center justify-center"
                                    title="Hapus Artikel">
                                    <i class="bi bi-trash text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-medium italic">
                            Belum ada artikel yang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="p-6 md:p-8 bg-slate-50/20 border-t border-slate-50">
        {{ $articles->links() }}
    </div>
</div>
