<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Welcome Text -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-semibold mb-1 text-slate-800 tracking-tight">Selamat Datang Kembali</h2>
        <p class="text-slate-500 text-sm">Silakan masuk ke akun Anda untuk mengelola konten.</p>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <label for="email" class="text-sm font-medium text-slate-600 block">Email</label>
            <div class="relative group">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors">mail</span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username"
                    class="w-full pl-[44px] pr-4 py-3 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 outline-none transition-all placeholder:text-slate-400"
                    placeholder="nama@email.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500 text-xs" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <label for="password" class="text-sm font-medium text-slate-600 block">Kata Sandi</label>
            <div class="relative group">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-600 transition-colors">lock</span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full pl-[44px] pr-[44px] py-3 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 outline-none transition-all placeholder:text-slate-400"
                    placeholder="••••••••">
                <button type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors flex items-center justify-center"
                    onclick="togglePasswordVisibility()">
                    <span class="material-symbols-outlined" id="password-toggle">visibility</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-xs" />
        </div>

        <div class="flex items-center justify-between py-2">
            <label for="remember_me" class="flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember"
                    class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-600/20 transition-all">
                <span class="ml-2 text-sm font-medium text-slate-500 group-hover:text-slate-800 transition-colors">Ingat
                    Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-blue-600 hover:underline transition-all"
                    href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif
        </div>

        <button type="submit"
            class="w-full py-3 bg-blue-600 text-white font-semibold text-base rounded-xl shadow-sm hover:bg-blue-700 active:scale-[0.98] transition-all flex items-center justify-center gap-2 mt-2">
            Masuk
            <span class="material-symbols-outlined text-xl">arrow_forward</span>
        </button>
    </form>

    <!-- Divider -->
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-200"></div>
        </div>
        <div class="relative flex justify-center text-xs">
        </div>
    </div>

    <!-- Footer Link -->
    <div class="mt-6 text-center">
        <p class="text-sm font-medium text-slate-500">
            Belum punya akun?
            <a class="text-blue-600 font-bold hover:underline" href="#">Hubungi Admin</a>
        </p>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('password-toggle');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = 'visibility';
            }
        }
    </script>
</x-guest-layout>
