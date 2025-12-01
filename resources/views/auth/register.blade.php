
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Logo Section -->
        <div class="mb-8 flex justify-center">
            <a href="/">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Bimbel Cakap" class="h-20 w-auto object-contain drop-shadow-lg">
            </a>
        </div>
        
        <!-- Header Kecil -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-white">Buat Akun Baru</h2>
            <p class="text-sky text-sm">Bergabunglah bersama kami sekarang!</p>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-sky font-semibold" />
            <x-text-input id="name" 
                class="block mt-1 w-full bg-navy border border-sky/20 text-white placeholder-gray-500 focus:border-gold focus:ring-gold rounded-xl px-4 py-3" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required autofocus autocomplete="name"
                placeholder="Nama lengkap anda..." />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-sky font-semibold" />
            <x-text-input id="email" 
                class="block mt-1 w-full bg-navy border border-sky/20 text-white placeholder-gray-500 focus:border-gold focus:ring-gold rounded-xl px-4 py-3" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required autocomplete="username"
                placeholder="contoh@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-sky font-semibold" />

            <x-text-input id="password" 
                class="block mt-1 w-full bg-navy border border-sky/20 text-white placeholder-gray-500 focus:border-gold focus:ring-gold rounded-xl px-4 py-3"
                type="password"
                name="password"
                required autocomplete="new-password"
                placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-sky font-semibold" />

            <x-text-input id="password_confirmation" 
                class="block mt-1 w-full bg-navy border border-sky/20 text-white placeholder-gray-500 focus:border-gold focus:ring-gold rounded-xl px-4 py-3"
                type="password"
                name="password_confirmation" required autocomplete="new-password"
                placeholder="Ulangi password..." />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-8">
            <x-primary-button class="w-full justify-center py-3 bg-gold hover:bg-lightgold text-navy font-bold text-lg rounded-xl transition-all duration-300 shadow-lg shadow-gold/20 border-none">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>

            <div class="mt-4 text-center">
                <span class="text-gray-300 text-sm">Sudah terdaftar?</span>
                <a class="text-sky font-bold hover:text-gold hover:underline transition ml-1 text-sm" href="{{ route('login') }}">
                    {{ __('Masuk disini') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>