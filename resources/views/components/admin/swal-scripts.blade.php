{{-- Shared SweetAlert2 Scripts for Admin Panel --}}
<script>
    window.addEventListener('swal:alert', event => {
        const isSuccess = event.detail[0].icon === 'success';
        const iconClass = isSuccess ? 'bi-check2-circle text-emerald-500' :
            'bi-exclamation-circle text-rose-500';
        const bgClass = isSuccess ? 'bg-emerald-50 border-emerald-100/30' : 'bg-rose-50 border-rose-100/30';

        Swal.fire({
            html: `
                <div class="text-center p-1">
                    <div class="mx-auto w-16 h-16 rounded-full ${bgClass} border flex items-center justify-center shrink-0 shadow-sm mb-4">
                        <i class="bi ${iconClass} text-3xl leading-none flex items-center justify-center"></i>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight leading-snug">${event.detail[0].title}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed font-semibold px-2">${event.detail[0].text}</p>
                    </div>
                </div>
            `,
            confirmButtonText: 'Selesai',
            buttonsStyling: false,
            customClass: {
                popup: 'rounded-3xl border border-slate-100/80 p-8 shadow-2xl bg-white max-w-md w-full',
                actions: 'flex justify-center mt-6 w-full',
                confirmButton: 'px-8 py-3 rounded-2xl font-semibold text-sm bg-blue-600 hover:bg-blue-700 text-white transition duration-200 outline-none shadow-sm hover:shadow-md active:scale-95 cursor-pointer'
            }
        });
    });

    window.addEventListener('swal:confirm', event => {
        Swal.fire({
            html: `
                <div class="text-center p-1">
                    <div class="mx-auto w-16 h-16 rounded-full bg-rose-50 border border-rose-100/40 flex items-center justify-center shrink-0 shadow-sm mb-4">
                        <i class="bi bi-trash3 text-rose-500 text-3xl leading-none flex items-center justify-center"></i>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="text-xl font-bold text-slate-800 tracking-tight leading-snug">${event.detail[0].title}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed font-medium px-2">${event.detail[0].text}</p>
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
                confirmButton: 'px-8 py-3 rounded-2xl font-semibold text-sm bg-rose-600 hover:bg-[#BE123C] text-white transition duration-200 outline-none shadow-sm hover:shadow-md active:scale-95 cursor-pointer',
                cancelButton: 'px-8 py-3 rounded-2xl font-semibold text-sm bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-800 transition duration-200 outline-none active:scale-95 cursor-pointer border border-slate-200/40 shadow-sm'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', event.detail[0].id);
            }
        });
    });
</script>
