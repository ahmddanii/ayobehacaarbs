<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="space-y-2">
            <label for="name" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 italic ml-2">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full px-6 py-4 rounded-2xl bg-white/5 border-2 border-white/10 focus:border-blue-500 focus:bg-white/10 outline-none transition-all text-white placeholder:text-slate-500 font-bold"
                   placeholder="Admin Name">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 font-bold text-xs" />
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 italic ml-2">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full px-6 py-4 rounded-2xl bg-white/5 border-2 border-white/10 focus:border-blue-500 focus:bg-white/10 outline-none transition-all text-white placeholder:text-slate-500 font-bold"
                   placeholder="admin@ayobehacaar.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 font-bold text-xs" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 italic ml-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full px-6 py-4 rounded-2xl bg-white/5 border-2 border-white/10 focus:border-blue-500 focus:bg-white/10 outline-none transition-all text-white placeholder:text-slate-500 font-bold"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 font-bold text-xs" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 italic ml-2">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full px-6 py-4 rounded-2xl bg-white/5 border-2 border-white/10 focus:border-blue-500 focus:bg-white/10 outline-none transition-all text-white placeholder:text-slate-500 font-bold"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 font-bold text-xs" />
        </div>

        <div class="pt-4 space-y-4">
            <button type="submit" class="w-full py-5 bg-blue-600 text-white font-black rounded-2xl hover:bg-blue-700 transition shadow-2xl shadow-blue-600/40 uppercase tracking-widest text-xs">
                {{ __('Register Admin') }}
            </button>
            
            <a class="block text-center text-xs font-bold text-slate-400 hover:text-white transition" href="{{ route('login') }}">
                {{ __('Already registered? Sign In') }}
            </a>
        </div>
    </form>
</x-guest-layout>
