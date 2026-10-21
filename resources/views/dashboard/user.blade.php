<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - KALUNA Digital Cash</title>
    <!-- Tailwind CSS & Google Fonts Poppins -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #fff5f7; 
        }
        .pink-gradient {
            background: linear-gradient(135deg, #fb7185 0%, #e11d48 100%);
        }
    </style>
</head>
<body class="min-h-screen text-gray-800">

    <!-- Navbar Atas -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-rose-100 sticky top-0 z-50 px-6 py-4 flex justify-between items-center shadow-sm">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-lg shadow-inner">
                🌸
            </div>
            <div>
                <h1 class="font-bold text-lg text-gray-800 tracking-wide leading-tight">KALUNA</h1>
                <p class="text-[10px] text-rose-500 font-semibold tracking-wider uppercase">Kas Lunas Terpenuhi</p>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-gray-700">{{ Auth::user()->name ?? 'User Kaluna' }}</p>
                <p class="text-[10px] text-rose-500 uppercase font-medium">Role: User</p>
            </div>
            <!-- Tombol Logout -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center space-x-1">
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Konten Utama Dashboard -->
    <main class="max-w-5xl mx-auto p-4 sm:p-6 space-y-6">

        <!-- Welcome Banner -->
        <div class="pink-gradient rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-rose-200 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="relative z-10">
                <span class="bg-white/20 text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Dashboard Siswa / User</span>
                <h2 class="text-2xl sm:text-3xl font-black mt-3">Halo, {{ Auth::user()->name ?? 'Sobat Kaluna' }}! 👋</h2>
                <p class="text-rose-100 text-xs sm:text-sm mt-1 max-w-lg font-medium leading-relaxed">
                    Selamat datang kembali di sistem pengelolaan kas digital kelas. Mari cek status pembayaran kas kamu bulan ini dengan mudah dan transparan.
                </p>
            </div>
        </div>

        <!-- Menu Navigasi Kelola Data Master -->
        <div>
            <h2 class="text-base font-bold text-gray-800 mb-3 flex items-center space-x-2">
                <span>⚙️</span>
                <span>Menu Pengelolaan Data Master</span>
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <!-- Kelola Iuran -->
                <a href="{{ route('kelola.iuran') }}" class="bg-white p-4 rounded-3xl border border-rose-100 shadow-sm hover:shadow-md hover:border-rose-300 transition-all text-center group">
                    <div class="w-10 h-10 mx-auto rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-lg mb-2 group-hover:bg-rose-500 group-hover:text-white transition-all">
                        💰
                    </div>
                    <h4 class="font-bold text-xs sm:text-sm text-gray-800">Kelola Iuran</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5">Atur jenis & nominal</p>
                </a>

                <!-- Kelola Siswa -->
                <a href="{{ route('kelola.siswa') }}" class="bg-white p-4 rounded-3xl border border-rose-100 shadow-sm hover:shadow-md hover:border-rose-300 transition-all text-center group">
                    <div class="w-10 h-10 mx-auto rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-lg mb-2 group-hover:bg-rose-500 group-hover:text-white transition-all">
                        🎓
                    </div>
                    <h4 class="font-bold text-xs sm:text-sm text-gray-800">Kelola Siswa</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5">Data & NISD siswa</p>
                </a>

                <!-- Kelola Wali Kelas -->
                <a href="{{ route('kelola.walikelas') }}" class="bg-white p-4 rounded-3xl border border-rose-100 shadow-sm hover:shadow-md hover:border-rose-300 transition-all text-center group">
                    <div class="w-10 h-10 mx-auto rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-lg mb-2 group-hover:bg-rose-500 group-hover:text-white transition-all">
                        👩‍🏫
                    </div>
                    <h4 class="font-bold text-xs sm:text-sm text-gray-800">Wali Kelas</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5">Data guru & NIP</p>
                </a>

                <!-- Kelola User -->
                <a href="{{ route('kelola.user') }}" class="bg-white p-4 rounded-3xl border border-rose-100 shadow-sm hover:shadow-md hover:border-rose-300 transition-all text-center group">
                    <div class="w-10 h-10 mx-auto rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-lg mb-2 group-hover:bg-rose-500 group-hover:text-white transition-all">
                        👥
                    </div>
                    <h4 class="font-bold text-xs sm:text-sm text-gray-800">Kelola User</h4>
                    <p class="text-[10px] text-gray-400 mt-0.5">Akun & hak akses</p>
                </a>
            </div>
        </div>

        <!-- Ringkasan Statistik Keuangan Kas -->
        <div>
            <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center space-x-2">
                <span>📊</span>
                <span>Ringkasan Keuangan Kas</span>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                
                <!-- Card Total Saldo -->
                <a href="#" class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100 hover:shadow-md hover:border-rose-300 transition-all block group">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Saldo Kas</span>
                        <span class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center font-bold">💰</span>
                    </div>
                    <h3 class="text-2xl font-black text-rose-500">Rp 0</h3>
                    <p class="text-[11px] text-rose-600 font-medium mt-2 flex items-center justify-between">
                        <span>Saldo kas aktif saat ini</span>
                        <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </p>
                </a>

                <!-- Card Total Pemasukan -->
                <a href="#" class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100 hover:shadow-md hover:border-rose-300 transition-all block group">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pemasukan</span>
                        <span class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-500 flex items-center justify-center font-bold">📥</span>
                    </div>
                    <h3 class="text-2xl font-black text-emerald-500">+ Rp 0</h3>
                    <p class="text-[11px] text-emerald-600 font-medium mt-2 flex items-center justify-between">
                        <span>Akumulasi iuran kas masuk</span>
                        <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </p>
                </a>

                <!-- Card Total Pengeluaran -->
                <a href="#" class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100 hover:shadow-md hover:border-amber-300 transition-all block group">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pengeluaran</span>
                        <span class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center font-bold">📤</span>
                    </div>
                    <h3 class="text-2xl font-black text-amber-500">Rp 0</h3>
                    <p class="text-[11px] text-amber-600 font-medium mt-2 flex items-center justify-between">
                        <span>Penggunaan dana kas kelas</span>
                        <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                    </p>
                </a>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-12 text-center py-6 text-gray-400 text-xs border-t border-rose-100">
        <p>Sistem Kas Digital KALUNA — Dibuat dengan 🌸 oleh <span class="font-bold text-rose-500">Anindia & Dita</span></p>
    </footer>

</body>
</html>