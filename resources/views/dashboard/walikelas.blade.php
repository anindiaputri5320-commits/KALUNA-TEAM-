<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wali Kelas - KALUNA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fff5f7; }
        .pink-gradient { background: linear-gradient(135deg, #fb7185 0%, #e11d48 100%); }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased">

    <!-- Top Navbar -->
    <nav class="bg-white/90 backdrop-blur-md shadow-sm border-b border-rose-100 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-2xl bg-rose-100 flex items-center justify-center text-rose-500 font-bold text-xl shadow-inner">🌸</div>
            <div>
                <span class="font-bold text-gray-800 text-lg tracking-wide">KALUNA</span>
                <span class="text-xs bg-purple-100 text-purple-600 px-3 py-0.5 rounded-full font-semibold ml-2">Wali Kelas</span>
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            <span class="text-xs font-semibold text-gray-700 hidden sm:inline">Bapak/Ibu {{ Auth::user()->name }} 📋</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-all shadow-md shadow-rose-200 active:scale-95">
                    Keluar 🚪
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 p-4 sm:p-8 max-w-7xl mx-auto w-full space-y-8">
        
        <!-- Welcome Banner -->
        <div class="pink-gradient text-white p-6 sm:p-8 rounded-3xl shadow-lg shadow-rose-200 space-y-2">
            <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full font-medium backdrop-blur-sm">Pengawasan Keuangan Kelas 📊</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold mt-2">Laporan Pengawasan Kas Kelas</h1>
            <p class="text-rose-100 text-xs sm:text-sm">Pantau secara langsung rekapitulasi keuangan, ketaatan siswa, dan transparansi dana kas kelas yang diampu.</p>
        </div>

        <!-- Cards Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                <p class="text-xs font-bold text-gray-400 uppercase">Total Saldo Kas</p>
                <h3 class="text-3xl font-black text-rose-500 mt-2">Rp 0</h3>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                <p class="text-xs font-bold text-gray-400 uppercase">Siswa Lunas</p>
                <h3 class="text-3xl font-black text-emerald-500 mt-2">0 Siswa</h3>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                <p class="text-xs font-bold text-gray-400 uppercase">Siswa Menunggak</p>
                <h3 class="text-3xl font-black text-amber-500 mt-2">0 Siswa</h3>
            </div>
        </div>

    </main>

    <footer class="text-center py-6 text-xs text-gray-400 border-t border-rose-100 bg-white">
        KALUNA Kas Digital — Dibuat dengan ❤️ oleh Anindia & Dita
    </footer>

</body>
</html>