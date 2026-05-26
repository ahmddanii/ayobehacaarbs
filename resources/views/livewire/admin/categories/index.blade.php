<div x-data="{ 
    open: false,
    compressing: false,
    compressImage(file, maxWidth = 800, maxHeight = 800, quality = 0.75) {
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
    }
}" @open-modal.window="open = true" @close-modal.window="open = false">
    @section('page_title', 'Manajemen Kategori')

    <div class="bg-white rounded-xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
        <!-- Action Header -->
        <div class="p-6 md:p-8 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="relative w-full sm:w-80 group">
                <input type="text" wire:model.live="search" placeholder="Cari kategori..." class="w-full pl-11 pr-5 py-2.5 bg-slate-50 border border-slate-200/60 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white outline-none transition duration-200 font-medium text-sm text-slate-700 placeholder:text-slate-400">
                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition duration-200 text-sm"></i>
            </div>
            
            <button @click="open = true; $wire.resetFields()" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-sm rounded-xl shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/35 hover:-translate-y-0.5 transition duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                <i class="bi bi-plus-lg text-sm"></i> Tambah Kategori
            </button>
        </div>

        <!-- Categories Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 text-[10px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-50">
                    <tr>
                        <th class="px-8 py-4">Thumbnail</th>
                        <th class="px-8 py-4">Nama Kategori</th>
                        <th class="px-8 py-4">Slug</th>
                        <th class="px-8 py-4">Jumlah Artikel</th>
                        <th class="px-8 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/40 transition-colors duration-150">
                            <td class="px-8 py-4">
                                <div class="w-12 h-12 rounded-xl bg-slate-50 overflow-hidden border border-slate-200/40 flex items-center justify-center shrink-0">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="text-slate-350">
                                            <i class="bi bi-image text-xl leading-none"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-4">
                                <span class="font-extrabold text-slate-800 text-sm leading-snug">{{ $category->name }}</span>
                            </td>
                            <td class="px-8 py-4 text-slate-400 font-semibold text-xs">{{ $category->slug }}</td>
                            <td class="px-8 py-4">
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold rounded-full uppercase tracking-wider">
                                    {{ $category->articles_count ?? 0 }} Artikel
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="edit({{ $category->id }})" class="w-9 h-9 rounded-lg bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-100 text-slate-400 hover:text-blue-600 transition duration-200 flex items-center justify-center" title="Ubah Kategori">
                                        <i class="bi bi-pencil-square text-sm"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $category->id }})" class="w-9 h-9 rounded-lg bg-slate-50 hover:bg-rose-50 border border-slate-100 hover:border-rose-100 text-slate-400 hover:text-rose-600 transition duration-200 flex items-center justify-center" title="Hapus Kategori">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-medium italic">Belum ada kategori yang ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Area -->
        <div class="p-6 md:p-8 bg-slate-50/20 border-t border-slate-50">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- Interactive Modal Form -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-350"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-[60] flex items-center justify-center px-4" x-cloak>
        
        <!-- Backdrop Blur -->
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md" @click="open = false"></div>
        
        <!-- Modal Card -->
        <div class="bg-white rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] w-full max-w-lg relative z-10 overflow-hidden border border-slate-100/50">
            <!-- Modal Header -->
            <div class="p-6 md:p-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h4 class="text-lg font-bold text-slate-800 tracking-tight">{{ $isEdit ? 'Ubah Kategori' : 'Tambah Kategori Baru' }}</h4>
                    <p class="text-slate-400 text-xs mt-0.5">{{ $isEdit ? 'Edit rincian data kategori yang dipilih' : 'Tambahkan kategori baru ke sistem' }}</p>
                </div>
                <button @click="open = false" class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-slate-800 hover:border-slate-350 transition flex items-center justify-center shadow-sm">
                    <i class="bi bi-x-lg text-xs leading-none"></i>
                </button>
            </div>
            
            <!-- Modal Form Body -->
            <form wire:submit.prevent="store" class="p-6 md:p-8 space-y-6">
                <!-- Name Field -->
                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Nama Kategori</label>
                    <input type="text" wire:model.live="name" class="w-full px-4 py-3 bg-slate-50 border border-slate-200/80 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white outline-none transition duration-200 font-bold text-slate-850 placeholder:font-normal placeholder:text-slate-400" placeholder="Contoh: Teknologi, Pendidikan">
                    @error('name') <span class="text-rose-500 text-xs font-semibold block mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span> @enderror
                </div>



                <!-- Image Upload (Thumbnail) Field -->
                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Gambar Sampul (Opsional)</label>
                    <div class="relative">
                        <input type="file" class="hidden" id="category_image" @change="
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
                        <label for="category_image" class="flex flex-col items-center justify-center p-6 bg-slate-50 border-2 border-dashed border-slate-200 hover:border-blue-500 hover:bg-blue-50/30 rounded-xl cursor-pointer transition duration-250 group relative overflow-hidden min-h-[140px]">
                            <!-- Temporary Preview -->
                            @if($image)
                                <div class="absolute inset-0 bg-white z-10 flex items-center justify-center p-2" x-show="!compressing">
                                    @if(is_string($image))
                                        <img src="{{ asset('storage/' . $image) }}" class="h-full w-full object-cover rounded-xl border border-slate-200">
                                    @else
                                        <img src="{{ $image->temporaryUrl() }}" class="h-full w-full object-cover rounded-xl border border-slate-200">
                                    @endif
                                    <div class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition duration-200 flex flex-col items-center justify-center rounded-xl">
                                        <i class="bi bi-cloud-arrow-up text-white text-2xl mb-1"></i>
                                        <span class="text-white text-xs font-bold">Ganti Gambar</span>
                                    </div>
                                </div>
                            @endif
                            <i class="bi bi-cloud-arrow-up text-2xl text-slate-350 group-hover:text-blue-500 mb-2 transition duration-200" x-show="!compressing"></i>
                            <span class="text-xs font-bold text-slate-500 group-hover:text-blue-500 transition duration-200">
                                <template x-if="compressing">
                                    <span>
                                        <i class="bi bi-arrow-repeat animate-spin text-blue-500 mr-1.5"></i>
                                        Mengompres Gambar...
                                    </span>
                                </template>
                                <template x-if="!compressing">
                                    <span>Pilih berkas dari perangkat Anda</span>
                                </template>
                            </span>
                            <span class="text-[10px] text-slate-350 mt-1">Format: JPG, PNG (Max 1MB)</span>
                        </label>
                    </div>
                    @error('image') <span class="text-rose-500 text-xs font-semibold block mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span> @enderror
                </div>

                <!-- Footer Buttons -->
                <div class="pt-4 flex gap-3">
                    <button type="button" @click="open = false" class="flex-grow py-3 bg-slate-50 border border-slate-200/60 text-slate-600 hover:bg-slate-100 hover:text-slate-800 font-bold rounded-xl transition duration-200">Batal</button>
                    <button type="submit" class="flex-grow py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-md shadow-blue-500/25 transition duration-200">
                        <span wire:loading.remove>{{ $isEdit ? 'Simpan' : 'Tambahkan' }}</span>
                        <span wire:loading><i class="bi bi-arrow-repeat animate-spin mr-1"></i> Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Alert and Confirm Modals Scripts -->
    <script>
        window.addEventListener('open-modal', event => {
            // Handled dynamically by alpine.js x-data
        });

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
