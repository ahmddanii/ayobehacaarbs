<x-admin-layout>
    @slot('page_title')
        Profil Pengguna
    @endslot

    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Profile Header Card -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-2xl p-6 md:p-8 shadow-sm flex flex-col md:flex-row items-center gap-6 transition-all duration-300">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-3xl font-black shadow-lg shadow-blue-500/20 shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="text-center md:text-left flex-grow">
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ auth()->user()->name }}</h1>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">{{ auth()->user()->email }}</p>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 mt-3 border border-blue-150/40 dark:border-blue-900/40 uppercase tracking-wider">
                    <i class="bi bi-shield-check"></i> Administrator
                </span>
            </div>
        </div>

        <!-- 2-Column Grid: Profile Information & Update Password -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Profile Information Card -->
            <div class="p-6 md:p-8 bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-2xl shadow-sm hover:shadow-md transition duration-300">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Change Password Card -->
            <div class="p-6 md:p-8 bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-2xl shadow-sm hover:shadow-md transition duration-300 h-fit">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <!-- Full-Width Card: Delete Account -->
        <div class="p-6 md:p-8 bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-2xl shadow-sm hover:shadow-md transition duration-300">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-admin-layout>
