
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-white">C.A.K.A.P</h1>
            <p class="text-base font-semibold text-yellow-400">Cerdas Aktif Kompetitif Analitis Progresif</p>
        </div>
        <!-- Logo Section -->
        <div class="mb-8 flex justify-center">
            <a href="/">
                {{-- Logo disesuaikan ukurannya --}}
                <img src="{{ asset('images/logo.png') }}" alt="Logo Bimbel Cakap" class="h-20 w-auto object-contain drop-shadow-lg">
            </a>
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sky font-semibold" />
            <x-text-input id="email" 
                class="block mt-1 w-full bg-navy border border-sky/20 text-white placeholder-gray-500 focus:border-gold focus:ring-gold rounded-xl px-4 py-3" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required autofocus autocomplete="username"
                placeholder="Masukkan Email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-sky font-semibold" />

            <x-text-input id="password" 
                class="block mt-1 w-full bg-navy border border-sky/20 text-white placeholder-gray-500 focus:border-gold focus:ring-gold rounded-xl px-4 py-3"
                type="password"
                name="password"
                required autocomplete="current-password"
                placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded bg-navy border-sky/30 text-gold shadow-sm focus:ring-gold" name="remember">
                <span class="ms-2 text-sm text-sky group-hover:text-white transition">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-sky hover:text-gold transition rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gold" href="{{ route('password.request') }}">
                    {{ __('Lupa Password?') }}
                </a>
            @endif
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-8">
            <x-primary-button class="w-full justify-center py-3 bg-gold hover:bg-lightgold text-navy font-bold text-lg rounded-xl transition-all duration-300 shadow-lg shadow-gold/20 border-none">
                {{ __('Login') }}
            </x-primary-button>

            <div class="mt-4 text-center">
                <span class="text-gray-300 text-sm">Belum punya akun?</span>
                <a class="text-sky font-bold hover:text-gold hover:underline transition ml-1 text-sm" href="{{ route('register') }}">
                    {{ __('Daftar disini') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>