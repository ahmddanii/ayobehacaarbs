<div>
    @section('page_title', $isWriting ? ($isEdit ? 'Ubah Artikel' : 'Tulis Artikel Baru') : 'Manajemen Artikel')

    @if ($isWriting)
        @include('livewire.admin.articles._editor')
    @else
        @include('livewire.admin.articles._table')
    @endif

    {{-- Shared SweetAlert2 Scripts --}}
    <x-admin.swal-scripts />
</div>

@push('scripts')
    {{-- Marked.js for Markdown live preview --}}
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    {{-- Shared image compression utility --}}
    <x-admin.compress-image :maxWidth="1200" :maxHeight="1200" />
@endpush
