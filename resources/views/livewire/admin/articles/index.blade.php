<div>
    @section('page_title', $isWriting ? ($isEdit ? 'Ubah Artikel' : 'Tulis Artikel Baru') : 'Manajemen Artikel')

    @if ($isWriting)
        <!-- Immersive Full-Page Split-Pane Editor Workspace -->
        <div class="space-y-6" wire:key="articles-editor" x-data="{
            content: @entangle('content'),
            title: @entangle('title'),
            slug: @entangle('slug'),
            categoryName: '',
            categoryId: @entangle('categoryId'),
            categories: {{ json_encode($categories->pluck('name', 'id')) }},
            showPreview: true,
            compressing: false,
            compressImage(file, maxWidth = 1200, maxHeight = 1200, quality = 0.75) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = event => {
                        const img = new Image();
                        img.src = event.target.result;
                        img.onload = () => {
                            const canvas = document.createElement('canvas');
                            let width = img.width;
                            let height = img.height;
        
                            if (width > height) {
                                if (width > maxWidth) {
                                    height = Math.round((height * maxWidth) / width);
                                    width = maxWidth;
                                }
                            } else {
                                if (height > maxHeight) {
                                    width = Math.round((width * maxHeight) / height);
                                    height = maxHeight;
                                }
                            }
        
                            canvas.width = width;
                            canvas.height = height;
        
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, width, height);
        
                            canvas.toBlob(blob => {
                                if (blob) {
                                    const compressedFile = new File([blob], file.name, {
                                        type: 'image/jpeg',
                                        lastModified: Date.now()
                                    });
                                    resolve(compressedFile);
                                } else {
                                    reject(new Error('Canvas toBlob failed'));
                                }
                            }, 'image/jpeg', quality);
                        };
                        img.onerror = err => reject(err);
                    };
                    reader.onerror = err => reject(err);
                });
            },
            insertMarkdown(type) {
                const textarea = this.$refs.editor;
                if (!textarea) return;
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const text = textarea.value || '';
                const selected = text.substring(start, end);
        
                let replacement = '';
                let cursorOffset = 0;
        
                switch (type) {
                    case 'bold':
                        replacement = `**${selected || 'teks tebal'}**`;
                        cursorOffset = selected ? 0 : 2;
                        break;
                    case 'italic':
                        replacement = `*${selected || 'teks miring'}*`;
                        cursorOffset = selected ? 0 : 1;
                        break;
                    case 'highlight':
                        replacement = `==${selected || 'highlight'}==`;
                        cursorOffset = selected ? 0 : 2;
                        break;
                    case 'quote':
                        replacement = `\n> ${selected || 'kutipan penting'}\n`;
                        cursorOffset = selected ? 0 : 1;
                        break;
                    case 'h2':
                        replacement = `\n## ${selected || 'Subjudul'}\n`;
                        cursorOffset = selected ? 0 : 1;
                        break;
                    case 'list':
                        replacement = `\n- ${selected || 'item'}\n`;
                        cursorOffset = selected ? 0 : 1;
                        break;
                }
        
                this.content = text.substring(0, start) + replacement + text.substring(end);
        
                this.$nextTick(() => {
                    textarea.focus();
                    const newCursorPos = start + replacement.length - cursorOffset;
                    textarea.setSelectionRange(newCursorPos, newCursorPos);
                });
            }
        }" x-init="$watch('categoryId', id => {
            categoryName = categories[id] || 'KATEGORI';
        });
        categoryName = categories[categoryId] || 'KATEGORI';">
            <!-- Sticky Workspace Action Bar -->
            <div
                class="bg-white rounded-xl border border-slate-100 p-4 md:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex flex-col sm:flex-row sm:items-center justify-between gap-4 sticky top-24 z-30">
                <div class="flex items-center gap-4">
                    <button wire:click="resetFields"
                        class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-200 text-slate-500 hover:text-slate-800 hover:bg-slate-100 flex items-center justify-center transition duration-200 shadow-sm"
                        title="Kembali ke Daftar">
                        <i class="bi bi-arrow-left text-lg"></i>
                    </button>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Workspace
                            Editor</span>
                        <h4 class="text-sm font-extrabold text-slate-800 tracking-tight leading-none mt-1">
                            {{ $isEdit ? 'Ubah Draf Artikel' : 'Tulis Gagasan Artikel Baru' }}
                        </h4>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Toggle Live Preview Button -->
                    <button type="button" @click="showPreview = !showPreview"
                        class="px-4 py-2.5 bg-slate-50 border border-slate-200/80 hover:bg-slate-100 text-slate-600 hover:text-slate-800 font-bold text-xs rounded-xl transition duration-200 flex items-center gap-2 shadow-sm"
                        title="Tampilkan/Sembunyikan Pratinjau">
                        <i class="bi"
                            :class="showPreview ? 'bi-eye-slash-fill text-rose-500' : 'bi-eye-fill text-emerald-500'"></i>
                        <span x-text="showPreview ? 'Sembunyikan Live' : 'Tampilkan Live'"></span>
                    </button>

                    <button wire:click="resetFields"
                        class="px-5 py-2.5 bg-white border border-slate-200/60 hover:bg-slate-50 text-slate-600 hover:text-slate-800 font-bold text-xs rounded-xl transition duration-200 shadow-sm">
                        Batal
                    </button>
                    <button wire:click="store"
                        class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg transition duration-200 flex items-center gap-2">
                        <span wire:loading.remove>{{ $isEdit ? 'Simpan Perubahan' : 'Terbitkan Sekarang' }}</span>
                        <span wire:loading><i class="bi bi-arrow-repeat animate-spin"></i> Memproses...</span>
                    </button>
                </div>
            </div>

            <!-- Split Pane Grid Workspace -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Pane: The Form & Editor Input (7 or 12 Columns) -->
                <div :class="showPreview ? 'lg:col-span-7' : 'lg:col-span-12'"
                    class="bg-white p-6 md:p-8 rounded-xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] space-y-6 transition-all duration-300">
                    <!-- Title Input -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Judul
                            Artikel</label>
                        <input type="text" wire:model.blur="title"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white outline-none transition duration-200 font-bold text-slate-850 placeholder:font-normal placeholder:text-slate-400 text-base"
                            placeholder="Masukkan judul artikel yang menarik...">
                        @error('title')
                            <span class="text-rose-500 text-xs font-semibold block mt-1"><i
                                    class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category & Upload Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category Picker -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Pilih
                                Kategori</label>
                            <div class="relative">
                                <select wire:model="categoryId"
                                    class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white outline-none transition duration-200 font-bold text-slate-700 appearance-none cursor-pointer text-xs">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('categoryId')
                                <span class="text-rose-500 text-xs font-semibold block mt-1"><i
                                        class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Thumbnail Image Upload -->
                        <div class="space-y-2 flex flex-col">
                            <label
                                class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block shrink-0">Gambar
                                Unggulan (Thumbnail)</label>
                            <div class="relative h-[48px]">
                                <input type="file" class="hidden" id="article_image_full"
                                    @change="
                                    const file = $event.target.files[0];
                                    if (!file) return;
                                    compressing = true;
                                    compressImage(file).then(compressedFile => {
                                        @this.upload('image', compressedFile, 
                                            () => { compressing = false; },
                                            () => { compressing = false; alert('Gagal mengompres gambar.'); }
                                        );
                                    }).catch(err => {
                                        compressing = false;
                                        @this.upload('image', file);
                                    });
                                ">
                                <label for="article_image_full"
                                    class="w-full h-full flex items-center justify-between px-4 bg-slate-50 border border-slate-200 hover:border-blue-500 hover:bg-blue-50/20 rounded-xl cursor-pointer transition duration-200 group overflow-hidden">
                                    <span
                                        class="text-xs font-bold text-slate-500 group-hover:text-blue-600 transition truncate">
                                        <template x-if="compressing">
                                            <span>
                                                <i class="bi bi-arrow-repeat animate-spin text-blue-500 mr-1.5"></i>
                                                Mengompres Gambar...
                                            </span>
                                        </template>
                                        <template x-if="!compressing">
                                            <span>
                                                @if ($image)
                                                    <i class="bi bi-check-circle-fill text-emerald-500 mr-1"></i> Gambar
                                                    berhasil diupload!
                                                @else
                                                    Pilih berkas sampul...
                                                @endif
                                            </span>
                                        </template>
                                    </span>
                                    <i class="bi bi-cloud-arrow-up text-lg text-slate-450 group-hover:text-blue-600 transition duration-200 shrink-0"
                                        x-show="!compressing"></i>
                                </label>
                            </div>
                            @error('image')
                                <span class="text-rose-500 text-xs font-semibold block mt-1"><i
                                        class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Markdown Content Editor Textarea -->
                    <div class="space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Konten
                                Artikel (Markdown Didukung)</label>
                            <span class="text-[10px] text-slate-450 font-semibold flex items-center gap-1"><i
                                    class="bi bi-info-circle text-blue-500"></i> Blok teks & klik tombol untuk memformat
                                secara cepat</span>
                        </div>

                        <!-- Rich Markdown Helper Toolbar -->
                        <div
                            class="flex flex-wrap items-center gap-2 p-2 bg-slate-50 border border-slate-200/85 rounded-xl">
                            <!-- Headings & Block level -->
                            <button type="button" @click="insertMarkdown('h2')"
                                class="h-9 w-9 text-slate-500 hover:text-blue-600 hover:bg-blue-50/60 rounded-lg transition flex items-center justify-center border border-transparent hover:border-blue-100"
                                title="Subjudul (H2)">
                                <i class="bi bi-type-h2 text-base"></i>
                            </button>

                            <div class="h-5 w-[1px] bg-slate-200 mx-1"></div>

                            <!-- Standard Format Inline -->
                            <button type="button" @click="insertMarkdown('bold')"
                                class="h-9 w-9 text-slate-500 hover:text-blue-600 hover:bg-blue-50/60 rounded-lg transition flex items-center justify-center border border-transparent hover:border-blue-100"
                                title="Tebal (Bold)">
                                <i class="bi bi-type-bold text-base"></i>
                            </button>
                            <button type="button" @click="insertMarkdown('italic')"
                                class="h-9 w-9 text-slate-500 hover:text-blue-600 hover:bg-blue-50/60 rounded-lg transition flex items-center justify-center border border-transparent hover:border-blue-100"
                                title="Miring (Italic)">
                                <i class="bi bi-type-italic text-base"></i>
                            </button>
                            <button type="button" @click="insertMarkdown('list')"
                                class="h-9 w-9 text-slate-500 hover:text-blue-600 hover:bg-blue-50/60 rounded-lg transition flex items-center justify-center border border-transparent hover:border-blue-100"
                                title="Daftar Poin">
                                <i class="bi bi-list-task text-base"></i>
                            </button>

                            <div class="h-5 w-[1px] bg-slate-200 mx-1"></div>

                            <!-- Custom Features requested by User (Highlight and Quote) -->
                            <button type="button" @click="insertMarkdown('highlight')"
                                class="h-9 px-3 text-xs text-rose-600 hover:text-rose-700 bg-rose-50/60 hover:bg-rose-50 border border-rose-100 hover:border-rose-200 rounded-lg font-bold flex items-center gap-1.5 transition shadow-sm"
                                title="Highlight Teks (==teks==)">
                                <span
                                    class="bg-rose-150 text-[10px] px-1 py-0.5 rounded leading-none border border-rose-200/50 font-black">==</span>
                                Highlight
                            </button>
                            <button type="button" @click="insertMarkdown('quote')"
                                class="h-9 px-3 text-xs text-blue-600 hover:text-blue-700 bg-blue-50/60 hover:bg-blue-50 border border-blue-100 hover:border-blue-200 rounded-lg font-bold flex items-center gap-1.5 transition shadow-sm"
                                title="Kutipan Khusus (Quote Note)">
                                <i class="bi bi-chat-quote-fill text-sm"></i> Quote Note
                            </button>
                        </div>

                        <textarea x-ref="editor" wire:model.live.debounce.150ms="content"
                            class="w-full px-4 py-4 bg-slate-50 border border-slate-200/80 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white outline-none transition duration-200 font-medium text-slate-700 min-h-[380px] text-sm leading-relaxed"
                            placeholder="Tulis isi tulisan artikel Anda di sini menggunakan markdown...

Gunakan blockquote dengan '>' untuk membuat quote note:
> ini adalah sebuah quote note yang indah.

Gunakan ==teks== untuk highlight teks penting:
Mari belajar ==literasi digital== demi masa depan cerah."></textarea>
                        @error('content')
                            <span class="text-rose-500 text-xs font-semibold block mt-1"><i
                                    class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Right Pane: Real-Time Split Markdown Live Preview (5 Columns) -->
                <div x-show="showPreview" x-transition.opacity
                    class="lg:col-span-5 bg-slate-50/40 p-6 md:p-8 rounded-xl border border-slate-200/40 flex flex-col gap-6 max-h-[85vh] overflow-y-auto relative">
                    <!-- Live Indicator Label -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200/60 shrink-0">
                        <span
                            class="text-[10px] font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Pratinjau Live Draf
                        </span>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] text-slate-400 font-semibold">GitHub-Style Render</span>
                            <button type="button" @click="showPreview = false"
                                class="w-5 h-5 rounded-md hover:bg-slate-200/60 flex items-center justify-center text-slate-400 hover:text-rose-500 transition duration-150"
                                title="Sembunyikan Pratinjau">
                                <i class="bi bi-x text-base leading-none"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Category badge preview -->
                    <div>
                        <span
                            class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider"
                            x-text="categoryName"></span>
                    </div>

                    <!-- Title Preview -->
                    <h1 class="font-extrabold text-2xl md:text-3xl text-slate-850 leading-tight tracking-tight"
                        x-text="title || 'Judul Draf Artikel...'"></h1>

                    <!-- Meta info preview -->
                    <div class="flex items-center gap-3 py-2 border-y border-slate-200/60 text-slate-500">
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-extrabold text-sm shadow-sm shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="text-xs text-slate-850 font-bold leading-none">{{ auth()->user()->name }}</span>
                            <span class="text-[10px] text-slate-400 font-semibold mt-0.5">{{ date('d F Y') }}</span>
                        </div>
                    </div>

                    <!-- Featured Image Live Preview (using Livewire temporary upload object) -->
                    <div
                        class="rounded-xl overflow-hidden shadow-sm border border-slate-200/40 aspect-[16/9] bg-slate-100 relative shrink-0">
                        @if ($image)
                            @if ($image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif(is_string($image))
                                <img src="{{ asset('storage/' . $image) }}" class="w-full h-full object-cover">
                            @endif
                        @else
                            <div
                                class="w-full h-full flex flex-col items-center justify-center text-slate-400 text-sm gap-2">
                                <i class="bi bi-image text-3xl text-slate-300"></i>
                                <span class="text-xs font-semibold text-slate-350">Belum ada gambar terpilih</span>
                            </div>
                        @endif
                    </div>

                    <!-- Markdown Content Parser Live Area -->
                    <div class="prose prose-slate leading-relaxed preview-content max-w-full"
                        x-html="content ? marked.parse(content.replace(/==(.*?)==/g, '<mark>$1</mark>')) : '<p class=\'text-slate-400 italic\'>Mulai menulis draf artikel di editor sebelah kiri untuk memicu pratinjau langsung...</p>'">
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Standard Article List View (Table) -->
        <div class="bg-white rounded-xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden"
            wire:key="articles-list">
            <!-- Action Header -->
            <div
                class="p-6 md:p-8 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="relative w-full sm:w-80 group">
                    <input type="text" wire:model.live="search" placeholder="Cari artikel..."
                        class="w-full pl-11 pr-5 py-2.5 bg-slate-50 border border-slate-200/60 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white outline-none transition duration-200 font-medium text-sm text-slate-700 placeholder:text-slate-400">
                    <i
                        class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition duration-200 text-sm"></i>
                </div>

                <button type="button" wire:click="create"
                    class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/35 hover:-translate-y-0.5 transition duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="bi bi-plus-lg text-sm"></i> Tulis Artikel
                </button>
            </div>

            <!-- Articles Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead
                        class="bg-slate-50/50 text-[10px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-50">
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
                                    <div
                                        class="w-16 h-10 rounded-lg bg-slate-50 overflow-hidden border border-slate-200/45 flex items-center justify-center shrink-0">
                                        @if ($article->image)
                                            <img src="{{ asset('storage/' . $article->image) }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div class="text-slate-300">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                    <div>
                                        <p class="font-extrabold text-slate-800 text-sm line-clamp-1 leading-snug">
                                            {{ $article->title }}</p>
                                        <p class="text-[10px] text-slate-400 mt-0.5 font-medium truncate max-w-xs">
                                            {{ $article->slug }}</p>
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                    <span
                                        class="px-2.5 py-1 bg-purple-50 text-purple-600 text-[10px] font-bold rounded-full uppercase tracking-wider">
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

            <!-- Pagination Area -->
            <div class="p-6 md:p-8 bg-slate-50/20 border-t border-slate-50">
                {{ $articles->links() }}
            </div>
        </div>
    @endif

    <!-- Styles for the live markdown preview rendering -->
    <style>
        .preview-content blockquote {
            border-left: 4px solid #2563eb;
            background-color: #f8fafc;
            padding: 1rem 1.25rem;
            border-radius: 0.5rem;
            margin: 1.5rem 0;
            color: #475569;
            font-style: italic;
        }

        .preview-content mark {
            background-color: #fef08a;
            color: #1e293b;
            padding: 0.1em 0.3em;
            border-radius: 0.2em;
            font-weight: 600;
        }

        .preview-content p {
            margin-bottom: 1rem;
            line-height: 1.7;
            color: #334155;
            font-size: 0.925rem;
        }

        .preview-content ul,
        .preview-content ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
            list-style-type: disc;
        }

        .preview-content ol {
            list-style-type: decimal;
        }

        .preview-content li {
            margin-bottom: 0.25rem;
            color: #334155;
            font-size: 0.925rem;
        }

        .preview-content h1,
        .preview-content h2,
        .preview-content h3 {
            font-weight: 800;
            color: #0f172a;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .preview-content h1 {
            font-size: 1.5rem;
        }

        .preview-content h2 {
            font-size: 1.25rem;
        }

        .preview-content h3 {
            font-size: 1.1rem;
        }
    </style>

    <!-- Modals Alert and Confirm Scripts -->
    <script>
        window.addEventListener('swal:alert', event => {
            const isSuccess = event.detail[0].icon === 'success';
            const iconClass = isSuccess ? 'bi-check2-circle text-emerald-500' : 'bi-exclamation-circle text-rose-500';
            const bgClass = isSuccess ? 'bg-emerald-50 border-emerald-100/30' : 'bg-rose-50 border-rose-100/30';
            
            Swal.fire({
                html: `
                    <div class="text-center p-1">
                        <!-- Top: Circular Icon -->
                        <div class="mx-auto w-16 h-16 rounded-full ${bgClass} border flex items-center justify-center shrink-0 shadow-sm mb-4">
                            <i class="bi ${iconClass} text-3xl leading-none flex items-center justify-center"></i>
                        </div>
                        <!-- Bottom: Content Column -->
                        <div class="flex flex-col gap-2">
                            <h3 class="text-xl font-extrabold text-slate-800 tracking-tight leading-snug">${event.detail[0].title}</h3>
                            <p class="text-slate-500 text-sm leading-relaxed font-semibold px-2">${event.detail[0].text}</p>
                        </div>
                    </div>
                `,
                confirmButtonText: 'Selesai',
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-3xl border border-slate-100/80 p-8 shadow-2xl bg-white max-w-md w-full',
                    actions: 'flex justify-center mt-6 w-full',
                    confirmButton: 'px-8 py-3 rounded-2xl font-bold text-sm bg-blue-600 hover:bg-blue-700 text-white transition duration-200 outline-none shadow-sm hover:shadow-md active:scale-95 cursor-pointer'
                }
            });
        });

        window.addEventListener('swal:confirm', event => {
            Swal.fire({
                html: `
                    <div class="text-center p-1">
                        <!-- Top: Circular Icon -->
                        <div class="mx-auto w-16 h-16 rounded-full bg-rose-50 border border-rose-100/40 flex items-center justify-center shrink-0 shadow-sm mb-4">
                            <i class="bi bi-trash3 text-rose-500 text-3xl leading-none flex items-center justify-center"></i>
                        </div>
                        <!-- Bottom: Content Column -->
                        <div class="flex flex-col gap-2">
                            <h3 class="text-xl font-extrabold text-slate-800 tracking-tight leading-snug">${event.detail[0].title}</h3>
                            <p class="text-slate-500 text-sm leading-relaxed font-semibold px-2">${event.detail[0].text}</p>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Urungkan',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-3xl border border-slate-100/80 p-8 shadow-2xl bg-white max-w-md w-full',
                    actions: 'flex justify-center gap-3 mt-6 w-full',
                    confirmButton: 'px-8 py-3 rounded-2xl font-bold text-sm bg-rose-600 hover:bg-[#BE123C] text-white transition duration-200 outline-none shadow-sm hover:shadow-md active:scale-95 cursor-pointer',
                    cancelButton: 'px-8 py-3 rounded-2xl font-bold text-sm bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-800 transition duration-200 outline-none active:scale-95 cursor-pointer border border-slate-200/40 shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', event.detail[0].id);
                }
            });
        });
    </script>
</div>
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
@endpush
