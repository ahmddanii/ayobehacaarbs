{{-- Article Editor Workspace (Split-Pane with Live Preview) --}}
<div class="space-y-6" wire:key="articles-editor" x-data="{
    content: @entangle('content'),
    title: @entangle('title'),
    slug: @entangle('slug'),
    categoryName: '',
    categoryId: @entangle('categoryId'),
    categories: {{ json_encode($categories->pluck('name', 'id')) }},
    showPreview: true,
    compressing: false,
    easyMDEInstance: null
}" x-init="
    $watch('categoryId', id => {
        categoryName = categories[id] || 'KATEGORI';
    });
    categoryName = categories[categoryId] || 'KATEGORI';

    const initMDE = () => {
        if (typeof EasyMDE === 'undefined') {
            setTimeout(initMDE, 100);
            return;
        }

        if (easyMDEInstance) {
            setTimeout(() => {
                easyMDEInstance.codemirror.refresh();
            }, 50);
            return;
        }

        easyMDEInstance = new EasyMDE({
            element: $refs.editor,
            autoDownloadFontAwesome: false,
            spellChecker: false,
            placeholder: 'Tulis isi tulisan artikel Anda di sini menggunakan markdown...',
            status: false,
            maxHeight: '480px',
            codemirrorOptions: {
                viewportMargin: Infinity
            },
            toolbar: [
                'bold', 'italic', 'heading-2', 'heading-3', '|',
                'quote', 'unordered-list', 'ordered-list', '|',
                'link', 'image', 'table', '|',
                {
                    name: 'highlight',
                    action: (editor) => {
                        let cm = editor.codemirror;
                        let selected = cm.getSelection();
                        cm.replaceSelection('==' + (selected || 'highlight') + '==');
                    },
                    className: 'fa-solid fa-paintbrush',
                    title: 'Highlight Teks penting (==teks==)',
                }
            ],
        });

        const highlightPreview = () => {
            $nextTick(() => {
                document.querySelectorAll('.preview-content pre code').forEach((block) => {
                    if (typeof hljs !== 'undefined') {
                        block.removeAttribute('data-highlighted');
                        hljs.highlightElement(block);
                    }
                });
            });
        };

        // Set initial value
        easyMDEInstance.value(content || '');
        highlightPreview();

        // Sync changes to Alpine state
        easyMDEInstance.codemirror.on('change', () => {
            content = easyMDEInstance.value();
            highlightPreview();
        });

        // Watch Alpine content change (like resets or edits)
        $watch('content', value => {
            if (value !== easyMDEInstance.value()) {
                easyMDEInstance.value(value || '');
            }
            highlightPreview();
        });

        // Force CodeMirror to refresh size calculations after DOM completes layout
        setTimeout(() => {
            easyMDEInstance.codemirror.refresh();
        }, 150);
    };

    setTimeout(initMDE, 50);
">

    {{-- Sticky Workspace Action Bar --}}
    <div
        class="bg-white rounded-xl border border-slate-100 p-4 md:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.02)] flex flex-col sm:flex-row sm:items-center justify-between gap-4 sticky top-24 z-30">
        <div class="flex items-center gap-4">
            <button wire:click="resetFields"
                class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-200 text-slate-500 hover:text-slate-800 hover:bg-slate-100 flex items-center justify-center transition duration-200 shadow-sm"
                title="Kembali ke Daftar">
                <i class="bi bi-arrow-left text-lg"></i>
            </button>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Workspace Editor</span>
                <h4 class="text-sm font-extrabold text-slate-800 tracking-tight leading-none mt-1">
                    {{ $isEdit ? 'Ubah Draf Artikel' : 'Tulis Gagasan Artikel Baru' }}
                </h4>
            </div>
        </div>

        <div class="flex items-center gap-3">
            {{-- Toggle Live Preview --}}
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

    {{-- Split Pane Grid Workspace --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Left Pane: Form & Editor --}}
        <div :class="showPreview ? 'lg:col-span-7' : 'lg:col-span-12'"
            class="bg-white p-6 md:p-8 rounded-xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] space-y-6 transition-all duration-300">

            {{-- Title Input --}}
            <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Judul Artikel</label>
                <input type="text" wire:model.blur="title"
                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white outline-none transition duration-200 font-bold text-slate-850 placeholder:font-normal placeholder:text-slate-400 text-base"
                    placeholder="Masukkan judul artikel yang menarik...">
                @error('title')
                    <span class="text-rose-500 text-xs font-semibold block mt-1"><i
                            class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                @enderror
            </div>

            {{-- Category & Upload Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Category Picker --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Pilih Kategori</label>
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

                {{-- Thumbnail Upload --}}
                <div class="space-y-2 flex flex-col">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block shrink-0">Gambar Unggulan (Thumbnail)</label>
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
                            <span class="text-xs font-bold text-slate-500 group-hover:text-blue-600 transition truncate">
                                <template x-if="compressing">
                                    <span>
                                        <i class="bi bi-arrow-repeat animate-spin text-blue-500 mr-1.5"></i>
                                        Mengompres Gambar...
                                    </span>
                                </template>
                                <template x-if="!compressing">
                                    <span>
                                        @if ($image)
                                            <i class="bi bi-check-circle-fill text-emerald-500 mr-1"></i> Gambar berhasil diupload!
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

            {{-- Markdown Content Editor --}}
            <div class="space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Konten Artikel (Markdown Didukung)</label>
                    <span class="text-[10px] text-slate-450 font-semibold flex items-center gap-1"><i
                            class="bi bi-info-circle text-blue-500"></i> Blok teks & klik tombol untuk memformat secara cepat</span>
                </div>

                <div wire:ignore>
                    <textarea x-ref="editor"></textarea>
                </div>
                @error('content')
                    <span class="text-rose-500 text-xs font-semibold block mt-1"><i
                            class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Right Pane: Live Preview --}}
        <div x-show="showPreview" x-transition.opacity
            class="lg:col-span-5 bg-slate-50/40 p-6 md:p-8 rounded-xl border border-slate-200/40 flex flex-col gap-6 max-h-[85vh] overflow-y-auto relative">

            {{-- Live Indicator --}}
            <div class="flex items-center justify-between pb-4 border-b border-slate-200/60 shrink-0">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1.5">
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

            {{-- Category Badge --}}
            <div>
                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider"
                    x-text="categoryName"></span>
            </div>

            {{-- Title Preview --}}
            <h1 class="font-extrabold text-2xl md:text-3xl text-slate-850 leading-tight tracking-tight"
                x-text="title || 'Judul Draf Artikel...'"></h1>

            {{-- Meta Info --}}
            <div class="flex items-center gap-3 py-2 border-y border-slate-200/60 text-slate-500">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-extrabold text-sm shadow-sm shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex flex-col">
                    <span class="text-xs text-slate-850 font-bold leading-none">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] text-slate-400 font-semibold mt-0.5">{{ date('d F Y') }}</span>
                </div>
            </div>

            {{-- Featured Image Preview --}}
            <div class="rounded-xl overflow-hidden shadow-sm border border-slate-200/40 aspect-[16/9] bg-slate-100 relative shrink-0">
                @if ($image)
                    @if ($image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                    @elseif(is_string($image))
                        <img src="{{ asset('storage/' . $image) }}" class="w-full h-full object-cover">
                    @endif
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 text-sm gap-2">
                        <i class="bi bi-image text-3xl text-slate-300"></i>
                        <span class="text-xs font-semibold text-slate-350">Belum ada gambar terpilih</span>
                    </div>
                @endif
            </div>

            {{-- Markdown Content Preview --}}
            <div class="prose prose-slate leading-relaxed preview-content max-w-full"
                x-html="content ? marked.parse(content.replace(/==(.*?)==/g, '<mark>$1</mark>')) : '<p class=\'text-slate-400 italic\'>Mulai menulis draf artikel di editor sebelah kiri untuk memicu pratinjau langsung...</p>'">
            </div>
        </div>
    </div>
</div>
