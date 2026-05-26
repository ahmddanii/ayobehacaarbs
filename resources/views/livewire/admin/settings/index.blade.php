<div x-data="{ activeTab: 'general' }">
    @section('page_title', 'Pengaturan Sistem')

    <div class="bg-white rounded-xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] overflow-hidden">
        {{-- Navigation Header Tabs --}}
        <div class="p-6 md:p-8 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="space-y-1">
                <h3 class="text-lg font-bold text-slate-800 tracking-tight">Konfigurasi Situs</h3>
                <p class="text-slate-400 text-xs">Sesuaikan identitas, deskripsi tentang kami, dan media sosial portal secara dinamis.</p>
            </div>
            
            {{-- Tabs Controls --}}
            <div class="flex flex-wrap gap-1 p-1 bg-slate-100/80 rounded-xl w-full sm:w-auto">
                <button @click="activeTab = 'general'"
                    :class="activeTab === 'general' ? 'bg-white text-blue-600 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50/50 font-medium'"
                    class="flex-grow sm:flex-grow-0 px-4 py-2 text-xs rounded-lg transition duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="bi bi-info-circle text-sm"></i>
                    Umum
                </button>
                <button @click="activeTab = 'about'"
                    :class="activeTab === 'about' ? 'bg-white text-blue-600 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50/50 font-medium'"
                    class="flex-grow sm:flex-grow-0 px-4 py-2 text-xs rounded-lg transition duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="bi bi-book text-sm"></i>
                    Tentang Kami
                </button>
                <button @click="activeTab = 'social'"
                    :class="activeTab === 'social' ? 'bg-white text-blue-600 shadow-sm font-bold' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50/50 font-medium'"
                    class="flex-grow sm:flex-grow-0 px-4 py-2 text-xs rounded-lg transition duration-200 flex items-center justify-center gap-2 whitespace-nowrap">
                    <i class="bi bi-share text-sm"></i>
                    Media Sosial
                </button>
            </div>
        </div>

        {{-- Form Content --}}
        <form wire:submit.prevent="save" class="p-6 md:p-8 space-y-8">
            
            {{-- General Settings Tab --}}
            <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-200" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Site Name --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Nama Portal / Aplikasi</label>
                        <div class="relative group">
                            <input type="text" wire:model.live="siteName"
                                class="w-full pl-11 pr-5 py-3 bg-slate-50 border border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white rounded-xl outline-none transition duration-200 font-bold text-slate-800 placeholder:text-slate-400"
                                placeholder="Contoh: ayo behacaar">
                            <i class="bi bi-globe2 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition duration-200 text-base"></i>
                        </div>
                        @error('siteName')
                            <span class="text-rose-500 text-xs font-semibold block mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Contact Email --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Email Kontak Resmi</label>
                        <div class="relative group">
                            <input type="email" wire:model.live="contactEmail"
                                class="w-full pl-11 pr-5 py-3 bg-slate-50 border border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white rounded-xl outline-none transition duration-200 font-semibold text-slate-800 placeholder:text-slate-400"
                                placeholder="Contoh: info@ayobehacaar.com">
                            <i class="bi bi-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition duration-200 text-base"></i>
                        </div>
                        @error('contactEmail')
                            <span class="text-rose-500 text-xs font-semibold block mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Tagline --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Slogan / Tagline Footer</label>
                    <div class="relative group">
                        <input type="text" wire:model.live="tagline"
                            class="w-full pl-11 pr-5 py-3 bg-slate-50 border border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white rounded-xl outline-none transition duration-200 font-medium text-slate-800 placeholder:text-slate-400"
                            placeholder="Tulis tagline singkat untuk ditampilkan di footer...">
                        <i class="bi bi-quote absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition duration-200 text-base"></i>
                    </div>
                    @error('tagline')
                        <span class="text-rose-500 text-xs font-semibold block mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                {{-- Cover Images Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                    {{-- Category Page Hero Cover --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Sampul Hero Halaman Kategori</label>
                        <div class="relative">
                            <input type="file" class="hidden" id="category_hero_image" wire:model="categoryHeroImage">
                            <label for="category_hero_image"
                                class="flex flex-col items-center justify-center p-6 bg-slate-50 border-2 border-dashed border-slate-200 hover:border-blue-500 hover:bg-blue-50/30 rounded-xl cursor-pointer transition duration-250 group relative overflow-hidden min-h-[160px]">
                                @if ($categoryHeroImage)
                                    <div class="absolute inset-0 bg-white z-10 flex items-center justify-center p-2">
                                        @if (is_string($categoryHeroImage))
                                            <img src="{{ asset('storage/' . $categoryHeroImage) }}" class="h-full w-full object-cover rounded-xl border border-slate-200">
                                        @else
                                            <img src="{{ $categoryHeroImage->temporaryUrl() }}" class="h-full w-full object-cover rounded-xl border border-slate-200">
                                        @endif
                                        <div class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition duration-200 flex flex-col items-center justify-center rounded-xl">
                                            <i class="bi bi-cloud-arrow-up text-white text-2xl mb-1"></i>
                                            <span class="text-white text-xs font-bold">Ganti Sampul</span>
                                        </div>
                                    </div>
                                @endif
                                <i class="bi bi-image text-2xl text-slate-350 group-hover:text-blue-500 mb-2 transition duration-200"></i>
                                <span class="text-xs font-bold text-slate-500 group-hover:text-blue-500 transition duration-200">Pilih sampul halaman Kategori</span>
                                <span class="text-[10px] text-slate-350 mt-1">Format: JPG, PNG (Max 2MB)</span>
                            </label>
                        </div>
                        @error('categoryHeroImage')
                            <span class="text-rose-500 text-xs font-semibold block mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Article Page Hero Cover --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Sampul Hero Halaman Artikel</label>
                        <div class="relative">
                            <input type="file" class="hidden" id="article_hero_image" wire:model="articleHeroImage">
                            <label for="article_hero_image"
                                class="flex flex-col items-center justify-center p-6 bg-slate-50 border-2 border-dashed border-slate-200 hover:border-blue-500 hover:bg-blue-50/30 rounded-xl cursor-pointer transition duration-250 group relative overflow-hidden min-h-[160px]">
                                @if ($articleHeroImage)
                                    <div class="absolute inset-0 bg-white z-10 flex items-center justify-center p-2">
                                        @if (is_string($articleHeroImage))
                                            <img src="{{ asset('storage/' . $articleHeroImage) }}" class="h-full w-full object-cover rounded-xl border border-slate-200">
                                        @else
                                            <img src="{{ $articleHeroImage->temporaryUrl() }}" class="h-full w-full object-cover rounded-xl border border-slate-200">
                                        @endif
                                        <div class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition duration-200 flex flex-col items-center justify-center rounded-xl">
                                            <i class="bi bi-cloud-arrow-up text-white text-2xl mb-1"></i>
                                            <span class="text-white text-xs font-bold">Ganti Sampul</span>
                                        </div>
                                    </div>
                                @endif
                                <i class="bi bi-image text-2xl text-slate-350 group-hover:text-blue-500 mb-2 transition duration-200"></i>
                                <span class="text-xs font-bold text-slate-500 group-hover:text-blue-500 transition duration-200">Pilih sampul halaman Artikel</span>
                                <span class="text-[10px] text-slate-350 mt-1">Format: JPG, PNG (Max 2MB)</span>
                            </label>
                        </div>
                        @error('articleHeroImage')
                            <span class="text-rose-500 text-xs font-semibold block mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- About Us Tab --}}
            <div x-show="activeTab === 'about'" x-transition:enter="transition ease-out duration-200" class="space-y-6" x-cloak>
                {{-- Philosophy Description --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Deskripsi Utama Halaman About</label>
                    <textarea wire:model.live="description" rows="5"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white rounded-xl outline-none transition duration-200 font-medium text-slate-700 leading-relaxed placeholder:text-slate-400"
                        placeholder="Tuliskan perkenalan filosofi atau visi misi utama situs Anda..."></textarea>
                    @error('description')
                        <span class="text-rose-500 text-xs font-semibold block mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                {{-- Visi Misi / Komitmen --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Komitmen Platform / Teks Tambahan</label>
                    <textarea wire:model.live="aboutText" rows="5"
                        class="w-full px-5 py-4 bg-slate-50 border border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white rounded-xl outline-none transition duration-200 font-medium text-slate-700 leading-relaxed placeholder:text-slate-400"
                        placeholder="Tuliskan komitmen kualitas konten editorial, visi misi, atau pesan penutup..."></textarea>
                    @error('aboutText')
                        <span class="text-rose-500 text-xs font-semibold block mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>

                {{-- About Page Hero Cover --}}
                <div class="space-y-2 pt-4">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Sampul Hero Halaman Tentang Kami</label>
                    <div class="relative">
                        <input type="file" class="hidden" id="about_hero_image" wire:model="aboutHeroImage">
                        <label for="about_hero_image"
                            class="flex flex-col items-center justify-center p-6 bg-slate-50 border-2 border-dashed border-slate-200 hover:border-blue-500 hover:bg-blue-50/30 rounded-xl cursor-pointer transition duration-250 group relative overflow-hidden min-h-[160px] max-w-lg">
                            @if ($aboutHeroImage)
                                <div class="absolute inset-0 bg-white z-10 flex items-center justify-center p-2">
                                    @if (is_string($aboutHeroImage))
                                        <img src="{{ asset('storage/' . $aboutHeroImage) }}" class="h-full w-full object-cover rounded-xl border border-slate-200">
                                    @else
                                        <img src="{{ $aboutHeroImage->temporaryUrl() }}" class="h-full w-full object-cover rounded-xl border border-slate-200">
                                    @endif
                                    <div class="absolute inset-0 bg-black/40 opacity-0 hover:opacity-100 transition duration-200 flex flex-col items-center justify-center rounded-xl">
                                        <i class="bi bi-cloud-arrow-up text-white text-2xl mb-1"></i>
                                        <span class="text-white text-xs font-bold">Ganti Sampul</span>
                                    </div>
                                </div>
                            @endif
                            <i class="bi bi-image text-2xl text-slate-350 group-hover:text-blue-500 mb-2 transition duration-200"></i>
                            <span class="text-xs font-bold text-slate-500 group-hover:text-blue-500 transition duration-200">Pilih sampul halaman Tentang Kami</span>
                            <span class="text-[10px] text-slate-350 mt-1">Format: JPG, PNG (Max 2MB)</span>
                        </label>
                    </div>
                    @error('aboutHeroImage')
                        <span class="text-rose-500 text-xs font-semibold block mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Social Media Tab --}}
            <div x-show="activeTab === 'social'" x-transition:enter="transition ease-out duration-200" class="space-y-6" x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Instagram --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Tautan Instagram</label>
                        <div class="relative group">
                            <input type="url" wire:model.live="instagramUrl"
                                class="w-full pl-11 pr-5 py-3 bg-slate-50 border border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white rounded-xl outline-none transition duration-200 font-medium text-slate-800 placeholder:text-slate-400"
                                placeholder="https://instagram.com/akun">
                            <i class="bi bi-instagram absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#e1306c] transition duration-200 text-base"></i>
                        </div>
                        @error('instagramUrl')
                            <span class="text-rose-500 text-xs font-semibold block mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- TikTok --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Tautan TikTok</label>
                        <div class="relative group">
                            <input type="url" wire:model.live="tiktokUrl"
                                class="w-full pl-11 pr-5 py-3 bg-slate-50 border border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white rounded-xl outline-none transition duration-200 font-medium text-slate-800 placeholder:text-slate-400"
                                placeholder="https://tiktok.com/@akun">
                            <i class="bi bi-tiktok absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-black transition duration-200 text-base"></i>
                        </div>
                        @error('tiktokUrl')
                            <span class="text-rose-500 text-xs font-semibold block mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- YouTube --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Tautan YouTube</label>
                        <div class="relative group">
                            <input type="url" wire:model.live="youtubeUrl"
                                class="w-full pl-11 pr-5 py-3 bg-slate-50 border border-slate-200/80 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:bg-white rounded-xl outline-none transition duration-200 font-medium text-slate-800 placeholder:text-slate-400"
                                placeholder="https://youtube.com/c/saluran">
                            <i class="bi bi-youtube absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#ff0000] transition duration-200 text-base"></i>
                        </div>
                        @error('youtubeUrl')
                            <span class="text-rose-500 text-xs font-semibold block mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Save Action Button Footer --}}
            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit"
                    class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm rounded-xl shadow-md shadow-blue-500/25 transition duration-200 flex items-center justify-center gap-2">
                    <span wire:loading.remove><i class="bi bi-cloud-check text-base"></i> Simpan Perubahan</span>
                    <span wire:loading><i class="bi bi-arrow-repeat animate-spin text-base"></i> Menyimpan...</span>
                </button>
            </div>

        </form>
    </div>

    {{-- Shared SweetAlert2 Notification --}}
    <x-admin.swal-scripts />
</div>
