<aside class="w-64 bg-white border-r border-rose-100 flex flex-col shrink-0 min-h-screen shadow-sm z-40">
    <!-- Logo / Brand -->
    <div class="p-6 border-b border-rose-100 flex items-center space-x-3">
        <div class="w-8 h-8 rounded-xl bg-rose-100 flex items-center justify-center text-rose-500 font-bold text-lg">🌸</div>
        <div>
            <span class="font-bold text-gray-800 text-sm tracking-wide">KALUNA</span>
            <p class="text-[10px] text-gray-400">Kas Digital Kelas</p>
        </div>
    </div>

    @php
        $role = Auth::user()->role ?? 'user';
        $dashboardRoute = match($role) {
            'admin'     => route('dashboard.user'),
            'bendahara' => route('dashboard.bendahara'),
            'walikelas' => route('dashboard.walikelas'),
            'siswa'     => route('dashboard.siswa'),
            default     => route('dashboard.user'),
        };
    @endphp

    <!-- Navigasi Menu -->
    <div class="flex-1 px-4 py-6 space-y-1.5 text-xs font-semibold text-gray-600 overflow-y-auto">
        <p class="px-3 text-[10px] uppercase tracking-wider text-gray-400 mb-2 font-bold">Main Menu</p>
        
        <!-- Dashboard Sesuai Role -->
        <a href="{{ $dashboardRoute }}" class="flex items-center gap-3 px-3 py-3 rounded-2xl transition-all {{ request()->routeIs('dashboard.*') && !request()->routeIs('laporan.keuangan') && !request()->routeIs('dashboard.kelola_walikelas') && !request()->routeIs('kelola.user') ? 'bg-rose-500 text-white shadow-md shadow-rose-200' : 'hover:bg-rose-50 text-gray-600' }}">
            <span>🏠</span> Dashboard
        </a>

        @if(in_array($role, ['admin', 'bendahara']))
            <!-- Kelola Data Siswa -->
            <a href="{{ route('kelola.siswa') }}" class="flex items-center gap-3 px-3 py-3 rounded-2xl transition-all {{ request()->routeIs('kelola.siswa*') ? 'bg-rose-500 text-white shadow-md shadow-rose-200' : 'hover:bg-rose-50 text-gray-600' }}">
                <span>🎓</span> Kelola Data Siswa
            </a>
        @endif

        @if($role == 'admin')
            <!-- Kelola Data User -->
            <a href="{{ route('kelola.user') }}" class="flex items-center gap-3 px-3 py-3 rounded-2xl transition-all {{ request()->routeIs('kelola.user*') ? 'bg-rose-500 text-white shadow-md shadow-rose-200' : 'hover:bg-rose-50 text-gray-600' }}">
                <span>👥</span> Kelola Data User
            </a>
        @endif

        @if(in_array($role, ['admin', 'bendahara']))
            <!-- Kelola Iuran Kas -->
            <a href="{{ route('kelola.iuran') }}" class="flex items-center gap-3 px-3 py-3 rounded-2xl transition-all {{ request()->routeIs('kelola.iuran*') || request()->routeIs('transaksi.*') ? 'bg-rose-500 text-white shadow-md shadow-rose-200' : 'hover:bg-rose-50 text-gray-600' }}">
                <span>💰</span> Kelola Iuran Kas
            </a>
        @endif

        @if($role == 'admin')
            <!-- Kelola Data Wali Kelas -->
            <a href="{{ route('dashboard.kelola_walikelas') }}" class="flex items-center gap-3 px-3 py-3 rounded-2xl transition-all {{ request()->routeIs('dashboard.kelola_walikelas*') ? 'bg-rose-500 text-white shadow-md shadow-rose-200' : 'hover:bg-rose-50 text-gray-600' }}">
                <span>👩‍🏫</span> Kelola Wali Kelas
            </a>
        @endif

       <!-- Laporan Keuangan (Ditampilkan langsung tanpa syarat role) -->
        <a href="{{ route('laporan.keuangan') }}" class="flex items-center gap-3 px-3 py-3 rounded-2xl transition-all {{ request()->routeIs('laporan.keuangan*') ? 'bg-rose-500 text-white shadow-md shadow-rose-200' : 'hover:bg-rose-50 text-gray-600' }}">
            <span>📊</span> Laporan Keuangan
        </a>
    </div>

    <!-- Footer Sidebar / Info User -->
    <div class="p-4 border-t border-rose-100 bg-rose-50/30">
        <p class="text-[11px] font-bold text-gray-800 truncate">{{ Auth::user()->name ?? 'User' }}</p>
        <p class="text-[10px] text-rose-500 font-semibold uppercase">{{ $role }}</p>
    </div>
</aside>