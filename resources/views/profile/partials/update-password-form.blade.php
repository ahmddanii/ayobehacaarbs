<section>
    <header>
        <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div x-data="{ showPassword: false }">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="relative mt-1">
                <x-text-input 
                    id="update_password_current_password" 
                    name="current_password" 
                    ::type="showPassword ? 'text' : 'password'" 
                    class="block w-full pr-10" 
                    autocomplete="current-password" 
                />
                <button 
                    type="button" 
                    @click="showPassword = !showPassword" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition focus:outline-none cursor-pointer"
                    title="Tampilkan/Sembunyikan Password"
                >
                    <i class="bi text-lg" :class="showPassword ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div x-data="{ showPassword: false }">
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div class="relative mt-1">
                <x-text-input 
                    id="update_password_password" 
                    name="password" 
                    ::type="showPassword ? 'text' : 'password'" 
                    class="block w-full pr-10" 
                    autocomplete="new-password" 
                />
                <button 
                    type="button" 
                    @click="showPassword = !showPassword" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition focus:outline-none cursor-pointer"
                    title="Tampilkan/Sembunyikan Password"
                >
                    <i class="bi text-lg" :class="showPassword ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div x-data="{ showPassword: false }">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div class="relative mt-1">
                <x-text-input 
                    id="update_password_password_confirmation" 
                    name="password_confirmation" 
                    ::type="showPassword ? 'text' : 'password'" 
                    class="block w-full pr-10" 
                    autocomplete="new-password" 
                />
                <button 
                    type="button" 
                    @click="showPassword = !showPassword" 
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition focus:outline-none cursor-pointer"
                    title="Tampilkan/Sembunyikan Password"
                >
                    <i class="bi text-lg" :class="showPassword ? 'bi-eye-slash-fill' : 'bi-eye-fill'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-500 dark:text-slate-400 font-semibold"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
