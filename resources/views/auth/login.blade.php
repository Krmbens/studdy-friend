<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Adresse Email')" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="exemple@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex justify-between items-center">
                <x-input-label for="password" :value="__('Mot de passe')" />
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold uppercase tracking-wider text-blue-400 hover:text-white transition-colors" href="{{ route('password.request') }}">
                        {{ __('Oublié ?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="*************" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-white/10 bg-white/5 text-blue-600 focus:ring-offset-0 focus:ring-blue-500/20 transition-all cursor-pointer" name="remember">
                <span class="ms-3 text-[10px] font-bold uppercase tracking-widest text-slate-500 group-hover:text-slate-300 transition-colors">{{ __('Rester connecté') }}</span>
            </label>
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Se connecter') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <div class="text-center pt-6 border-t border-white/5">
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-600">
                    Nouveau ici ? <a href="{{ route('register') }}" class="text-blue-400 hover:text-white transition-colors ml-1">Créer un compte</a>
                </p>
            </div>
        @endif
    </form>
</x-guest-layout>
