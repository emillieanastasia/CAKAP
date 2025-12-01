<aside 
    class="w-64 bg-teal border-r border-sky/10 shadow-xl min-h-full p-4 fixed md:static inset-y-0 left-0 z-30 transform 
           md:translate-x-0 transition-transform duration-300 flex flex-col"
    :class="openSidebar ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

    {{-- Tombol close mobile --}}
    <div class="md:hidden flex justify-end">
        <button 
            @click="openSidebar = false"
            class="text-sky hover:text-white mb-4">
            ✕
        </button>
    </div>

    {{-- Menu --}}
    <ul class="space-y-2 static">
        <li>
            <a href="{{ route('dashboard-admin') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 
               {{ request()->routeIs('dashboard-admin') ? 'bg-gold text-navy font-bold shadow-lg shadow-gold/20' : 'text-sky hover:bg-navy hover:text-lightgold' }}">
               <span>📊</span> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('siswa.index') }}" 
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 
                {{ request()->routeIs('siswa.index') ? 'bg-gold text-navy font-bold shadow-lg shadow-gold/20' : 'text-sky hover:bg-navy hover:text-lightgold' }}">
            <span>🎓</span> Data Siswa
            </a>
        </li>

        <li>
            <a href="{{ route('tentor.index') }}" 
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 
               {{ request()->routeIs('tentor.index') ? 'bg-gold text-navy font-bold shadow-lg shadow-gold/20' : 'text-sky hover:bg-navy hover:text-lightgold' }}">
               <span>👨‍🏫</span> Data Tentor
            </a>
        </li>
        <li>
            <a href="{{ route('kelas.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 
               {{ request()->routeIs('kelas.index') ? 'bg-gold text-navy font-bold shadow-lg shadow-gold/20' : 'text-sky hover:bg-navy hover:text-lightgold' }}">
            <span>📚</span> Kelas
            </a>
        </li>
        <li><a href="{{ route('matapelajaran.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 
            {{ request()->routeIs('matapelajaran.index') ? 'bg-gold text-navy font-bold shadow-lg shadow-gold/20' : 'text-sky hover:bg-navy hover:text-lightgold' }}">
            <span>📝</span> Mata Pelajaran
            </a>
        </li>
        <li><a href="{{ route('jadwal.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 
            {{ request()->routeIs('jadwal.index') ? 'bg-gold text-navy font-bold shadow-lg shadow-gold/20' : 'text-sky hover:bg-navy hover:text-lightgold' }}">
            <span>📅</span> Jadwal Kelas
            </a>
        </li>
        <li><a href="{{ route('pembayaran.index') }}" 
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 
            {{ request()->routeIs('pembayaran.index') ? 'bg-gold text-navy font-bold shadow-lg shadow-gold/20' : 'text-sky hover:bg-navy hover:text-lightgold' }}">
            <span>💰</span> Pembayaran</a></li>
    </ul>
</aside>