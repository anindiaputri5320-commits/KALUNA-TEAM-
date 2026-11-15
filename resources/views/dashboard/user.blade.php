<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - KALUNA Kas Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-[#fff5f7] font-sans antialiased">

    <div class="flex min-h-screen">
        
        <!-- Sidebar Navigation (Digabungkan agar Logout rapi di bagian bawah) -->
        <aside class="w-64 bg-white border-r border-pink-100 flex flex-col justify-between p-6 shrink-0 shadow-sm">
            
            <!-- Bagian Atas Sidebar (Logo & Menu Navigasi) -->
            <div>
                <div class="mb-8">
                    <h1 class="font-black text-gray-800 text-lg tracking-wide">KALUNA</h1>
                    <p class="text-[10px] font-bold text-gray-400 tracking-wider">KAS LUNAS TERPENUHI</p>
                </div>

                <div class="space-y-1.5">
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-2">Main Menu</span>
                    
                    <a href="{{ route('dashboard.user') }}" class="flex items-center gap-3 px-4 py-3 bg-rose-500 text-white rounded-2xl text-xs font-bold shadow-md shadow-rose-200 transition-all">
                        <span>🏠</span> Dashboard
                    </a>
                    <a href="{{ route('kelola.siswa') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-rose-50 hover:text-rose-600 rounded-2xl text-xs font-semibold transition-all">
                        <span>👥</span> Kelola Data Siswa
                    </a>
                    <a href="{{ route('kelola.user') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-rose-50 hover:text-rose-600 rounded-2xl text-xs font-semibold transition-all">
                        <span>⚙️</span> Kelola Data User
                    </a>
                    <a href="{{ route('kelola.iuran') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-rose-50 hover:text-rose-600 rounded-2xl text-xs font-semibold transition-all">
                        <span>💰</span> Kelola Data Iuran
                    </a>
                    <a href="{{ route('dashboard.kelola_walikelas') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-rose-50 hover:text-rose-600 rounded-2xl text-xs font-semibold transition-all">
                        <span>🏫</span> Kelola Data Wali Kelas
                    </a>
                </div>
            </div>

            <!-- Bagian Bawah Sidebar (Tombol Logout & Profil User) -->
            <div class="space-y-4 pt-4 border-t border-pink-50">
                
                <!-- Tombol Logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold rounded-xl transition-all shadow-sm">
                        <span>🚪</span> Keluar / Logout
                    </button>
                </form>

                <!-- Profil User -->
                <div class="flex items-center gap-3 pt-2">
                    <div class="w-9 h-9 rounded-full bg-rose-100 text-rose-600 font-bold flex items-center justify-center text-xs shadow-inner">U</div>
                    <div>
                        <div class="text-xs font-bold text-gray-800">User KALUNA</div>
                        <div class="text-[10px] text-rose-500 font-bold uppercase">USER</div>
                    </div>
                </div>

            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            
            <!-- Header Welcome Card -->
            <div class="mb-8 p-6 bg-white/85 backdrop-blur-md rounded-3xl border border-pink-100 shadow-sm flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-black text-slate-800">Dashboard Admin 🌸</h1>
                    <p class="text-xs font-semibold text-slate-400 mt-1">
                        Selamat datang, <span class="text-rose-500 font-bold">Admin</span>! Kelola seluruh master data KALUNA di sini.
                    </p>
                </div>
                <span class="px-4 py-1.5 bg-rose-100 text-rose-600 rounded-full text-[10px] font-black uppercase tracking-wider">
                    ROLE: ADMIN
                </span>
            </div>

            <!-- 3 Card Statistik Interaktif (Dapat Diklik & Otomatis Terhitung) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <!-- 1. Card Total Siswa -->
                <a href="{{ route('kelola.siswa') }}" 
                   class="bg-white p-6 rounded-3xl border border-pink-100 shadow-sm hover:shadow-md hover:border-rose-300 transition-all flex items-center justify-between group">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="p-2 bg-slate-100 rounded-xl group-hover:bg-rose-50 transition-colors">👥</span>
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Aktif</span>
                        </div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">TOTAL SISWA</p>
                        <p class="text-2xl font-black text-slate-800 mt-1">
                            {{ $totalSiswa ?? '120' }} <span class="text-xs font-semibold text-slate-400">Siswa</span>
                        </p>
                    </div>
                </a>

                <!-- 2. Card Kelas Terdaftar -->
               <a href="{{ route('dashboard.kelola_walikelas') }}"
                   class="bg-white p-6 rounded-3xl border border-pink-100 shadow-sm hover:shadow-md hover:border-rose-300 transition-all flex items-center justify-between group">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="p-2 bg-slate-100 rounded-xl group-hover:bg-rose-50 transition-colors">🏫</span>
                            <span class="text-[10px] font-bold text-rose-600 bg-rose-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">RPL</span>
                        </div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">KELAS TERDAFTAR</p>
                        <p class="text-2xl font-black text-slate-800 mt-1">
                            4 <span class="text-xs font-semibold text-slate-400">Kelas (XII RPL 1-4)</span>
                        </p>
                    </div>
                </a>

                <!-- 3. Card Total Saldo Kas (Otomatis Menambah & Mengurangi) -->
                <a href="{{ route('kelola.iuran') }}" 
                   class="bg-white p-6 rounded-3xl border border-pink-100 shadow-sm hover:shadow-md hover:border-rose-300 transition-all flex items-center justify-between group">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="p-2 bg-emerald-50 rounded-xl group-hover:bg-emerald-100 transition-colors">💰</span>
                            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-0.5 rounded-full uppercase tracking-wider">Terkumpul</span>
                        </div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">TOTAL SALDO KAS</p>
                        <p class="text-2xl font-black text-emerald-600 mt-1">
                            Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </a>

            </div>

        </main>
    </div>

</body>
</html>