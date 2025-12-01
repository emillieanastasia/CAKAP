@extends('layouts.create-edit')
@section('title','Edit Profil Tentor')

@section('content')
<div class="min-h-screen bg-[#013C58] p-3 sm:px-4 font-sans text-white flex flex-col md:flex-row gap-4 justify-center items-start">

    {{-- BAGIAN KIRI: FORM EDIT --}}
    <div class="flex-1 w-full max-w-3xl">

        {{-- Header Compact --}}
        <div class="flex flex-row justify-between items-end mb-3">
            <div>
                <h2 class="text-xl font-bold text-white leading-tight"><i class="fas fa-user-edit mr-2"></i> Edit Profil</h2>
                <p class="text-[#A8E8F9] text-xs">Perbarui data akun tentor Anda.</p>
            </div>
            <div class="text-right">
                <p class="text-[10px] text-[#FFD35B]">{{ now()->format('d M Y') }}</p>
            </div>
        </div>

        {{-- Form Container Compact --}}
        <div class="bg-[#00537A] p-5 rounded-xl shadow-lg border border-[#A8E8F9]/10">
            
            @if(session('success'))
                <div class="mb-3 bg-green-500/20 border border-green-500 text-green-200 px-3 py-2 rounded text-xs">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-3 bg-red-500/20 border border-red-500 text-red-200 px-3 py-2 rounded text-xs">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('tentor.update.profil') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- INFORMASI AKUN --}}
                <h3 class="text-sm font-bold mb-3 border-b border-[#A8E8F9]/20 pb-1 text-[#FFD35B]">Informasi Akun</h3>
                
                <div class="grid grid-cols-1 gap-3 mb-4">
                    {{-- Nama --}}
                    <div>
                        <label class="block text-xs font-medium text-[#A8E8F9] mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                            class="w-full bg-[#013C58] border border-[#A8E8F9]/30 rounded-md px-3 py-2 text-sm text-white placeholder-gray-400 focus:outline-none focus:border-[#FFD35B] focus:ring-1 focus:ring-[#FFD35B] transition">
                        @error('name') <span class="text-red-400 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-medium text-[#A8E8F9] mb-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                            class="w-full bg-[#013C58] border border-[#A8E8F9]/30 rounded-md px-3 py-2 text-sm text-white placeholder-gray-400 focus:outline-none focus:border-[#FFD35B] focus:ring-1 focus:ring-[#FFD35B] transition">
                        @error('email') <span class="text-red-400 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-xs font-medium text-[#A8E8F9] mb-1">Password Baru <span class="text-[10px] text-gray-400 normal-case">(Kosongkan jika tetap)</span></label>
                        <input type="password" name="password" placeholder="Masukkan password baru" 
                            class="w-full bg-[#013C58] border border-[#A8E8F9]/30 rounded-md px-3 py-2 text-sm text-white placeholder-gray-400 focus:outline-none focus:border-[#FFD35B] focus:ring-1 focus:ring-[#FFD35B] transition">
                        @error('password') <span class="text-red-400 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- INFORMASI TENTOR --}}
                <h3 class="text-sm font-bold mb-3 border-b border-[#A8E8F9]/20 pb-1 text-[#FFD35B]">Informasi Tentor</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                    {{-- Mapel --}}
                    <div>
                        <label class="block text-xs font-medium text-[#A8E8F9] mb-1">Mata Pelajaran</label>
                        <select name="mata_pelajaran_id" required 
                            class="w-full bg-[#013C58] border border-[#A8E8F9]/30 rounded-md px-3 py-2 text-sm text-white focus:outline-none focus:border-[#FFD35B] focus:ring-1 focus:ring-[#FFD35B] transition">
                            <option value="" class="bg-[#013C58]">Pilih Mapel</option>
                            @foreach ($mataPelajaran as $mapel)
                                <option value="{{ $mapel->id }}" class="bg-[#013C58]"
                                    {{ old('mata_pelajaran_id', $tentor->mata_pelajaran_id) == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id') <span class="text-red-400 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    {{-- Pendidikan --}}
                    <div>
                        <label class="block text-xs font-medium text-[#A8E8F9] mb-1">Pendidikan Terakhir</label>
                        <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $tentor->pendidikan_terakhir) }}"
                            class="w-full bg-[#013C58] border border-[#A8E8F9]/30 rounded-md px-3 py-2 text-sm text-white placeholder-gray-400 focus:outline-none focus:border-[#FFD35B] focus:ring-1 focus:ring-[#FFD35B] transition">
                        @error('pendidikan_terakhir') <span class="text-red-400 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3 mb-4">
                    {{-- No HP --}}
                    <div>
                        <label class="block text-xs font-medium text-[#A8E8F9] mb-1">Nomor Telepon</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $tentor->no_hp) }}"
                            class="w-full bg-[#013C58] border border-[#A8E8F9]/30 rounded-md px-3 py-2 text-sm text-white placeholder-gray-400 focus:outline-none focus:border-[#FFD35B] focus:ring-1 focus:ring-[#FFD35B] transition">
                        @error('no_hp') <span class="text-red-400 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                    
                    {{-- Alamat --}}
                    <div>
                        <label class="block text-xs font-medium text-[#A8E8F9] mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2"
                            class="w-full bg-[#013C58] border border-[#A8E8F9]/30 rounded-md px-3 py-2 text-sm text-white placeholder-gray-400 focus:outline-none focus:border-[#FFD35B] focus:ring-1 focus:ring-[#FFD35B] transition">{{ old('alamat', $tentor->alamat) }}</textarea>
                        @error('alamat') <span class="text-red-400 text-[10px]">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-5">
                    <button type="submit" class="flex-1 bg-[#FFD35B] hover:bg-yellow-500 text-[#013C58] font-bold py-2 px-4 rounded-md text-sm transition shadow-md">
                        Simpan
                    </button>
                    <a href="{{ route('dashboard-tentor') }}" class="md:hidden block flex-none bg-[#013C58] border border-[#A8E8F9]/30 text-[#A8E8F9] font-bold py-2 px-4 rounded-md text-sm hover:bg-[#022c40] transition">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- BAGIAN KANAN: SIDEBAR PREVIEW --}}
    <div class="w-full md:w-64 flex-shrink-0">
        <div class="bg-[#00537A] p-4 rounded-xl shadow-lg border border-[#A8E8F9]/10 sticky top-4">
            <h5 class="text-sm font-bold text-white mb-4 border-b border-[#A8E8F9]/20 pb-2">Preview</h5>

            <div class="flex flex-col gap-3">
                {{-- Foto Profil Kecil --}}
                <div class="flex justify-center mb-1">
                    <div class="w-16 h-16 rounded-full bg-[#013C58] border-2 border-[#FFD35B] flex items-center justify-center text-xl font-bold text-[#FFD35B]">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>

                <div class="text-center mb-2">
                    <p class="text-white font-bold text-sm">{{ $user->name }}</p>
                    <p class="text-[#A8E8F9] text-xs">
                        {{ $tentor->mataPelajaran->nama_mapel ?? 'Mapel belum diset' }}
                    </p>
                </div>

                <div class="border-t border-[#A8E8F9]/10 pt-3 space-y-2">
                    <div>
                        <p class="text-[10px] text-[#A8E8F9]">Email</p>
                        <p class="text-white text-xs truncate">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-[#A8E8F9]">Pendidikan</p>
                        <p class="text-white text-xs">{{ $tentor->pendidikan_terakhir ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-[#A8E8F9]">No. HP</p>
                        <p class="text-white text-xs">{{ $tentor->no_hp ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('dashboard-tentor') }}" class="w-full block text-center bg-[#013C58] border border-[#A8E8F9]/30 hover:bg-[#022c40] text-white font-bold py-1.5 px-3 rounded-md text-xs transition">
                        &larr; Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection