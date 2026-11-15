<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wali Kelas - KALUNA Kas Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fff5f7; }
        .pink-gradient { background: linear-gradient(135deg, #fb7185 0%, #e11d48 100%); }
    </style>
</head>
<body class="min-h-screen flex antialiased">

    <!-- Sidebar Navigation di Kiri -->
    @include('components.sidebar')

    <!-- Konten Utama di Kanan -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Top Navbar -->
        <nav class="bg-white/90 backdrop-blur-md shadow-sm border-b border-rose-100 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
            <div class="flex items-center space-x-3">
                <span class="font-bold text-gray-800 text-base tracking-wide">KALUNA Kas Digital 🌸</span>
                <span class="text-xs bg-rose-100 text-rose-600 px-3 py-0.5 rounded-full font-semibold">Dashboard Wali Kelas</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-xs font-semibold text-gray-700 hidden sm:inline">
                    Halo, {{ Auth::user()->name ?? 'Wali Kelas' }} 👑
                    <span class="text-[10px] bg-rose-100 text-rose-600 px-2.5 py-0.5 rounded-full uppercase font-bold ml-1">Wali Kelas</span>
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-all shadow-md shadow-rose-200 active:scale-95 cursor-pointer">
                        Keluar 🚪
                    </button>
                </form>
            </div>
        </nav>

        <!-- Main Content Area -->
        <main class="flex-1 p-4 sm:p-8 max-w-7xl mx-auto w-full space-y-8 overflow-y-auto">
            
            <!-- Welcome Banner -->
            <div class="pink-gradient text-white p-6 sm:p-8 rounded-3xl shadow-lg shadow-rose-200 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center sm:text-left z-10">
                    <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full font-medium backdrop-blur-sm">Pengawasan Keuangan Kelas 📊</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold mt-2">Laporan Pengawasan Kas Kelas</h1>
                    <p class="text-rose-100 text-xs sm:text-sm max-w-md">Pantau secara langsung rekapitulasi keuangan, ketaatan siswa, dan transparansi dana kas kelas yang diampu.</p>
                </div>
            </div>

           <!-- Cards Statistik (Sekarang Bisa Diklik!) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                
                <!-- Kartu 1: Total Saldo Kas (Mengarah ke Laporan Keuangan) -->
                <a href="{{ route('laporan.keuangan') }}" class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100 hover:border-rose-400 hover:shadow-md transition-all group block cursor-pointer">
                    <div class="flex justify-between items-center">
                        <p class="text-xs font-bold text-gray-400 uppercase group-hover:text-rose-500 transition-colors">Total Saldo Kas</p>
                        <span class="text-rose-400 text-sm opacity-0 group-hover:opacity-100 transition-opacity">Lihat Detail →</span>
                    </div>
                    <h3 class="text-3xl font-black text-rose-500 mt-2">
                        Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}
                    </h3>
                </a>

                <!-- Kartu 2: Total Siswa Binaan (Mengarah ke Laporan Keuangan / Detail) -->
                <a href="{{ route('laporan.keuangan') }}" class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100 hover:border-emerald-400 hover:shadow-md transition-all group block cursor-pointer">
                    <div class="flex justify-between items-center">
                        <p class="text-xs font-bold text-gray-400 uppercase group-hover:text-emerald-500 transition-colors">Total Siswa Binaan</p>
                        <span class="text-emerald-400 text-sm opacity-0 group-hover:opacity-100 transition-opacity">Cek Data →</span>
                    </div>
                    <h3 class="text-3xl font-black text-emerald-500 mt-2">
                        {{ $totalSiswa ?? 0 }} Siswa
                    </h3>
                </a>

                <!-- Kartu 3: Status Keuangan (Mengarah ke Laporan Keuangan) -->
                <a href="{{ route('laporan.keuangan') }}" class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100 hover:border-amber-400 hover:shadow-md transition-all group block cursor-pointer">
                    <div class="flex justify-between items-center">
                        <p class="text-xs font-bold text-gray-400 uppercase group-hover:text-amber-500 transition-colors">Status Keuangan</p>
                        <span class="text-amber-400 text-sm opacity-0 group-hover:opacity-100 transition-opacity">Buka Laporan →</span>
                    </div>
                    <h3 class="text-xl font-black text-amber-500 mt-3">
                        Transparan & Aktif ✨
                    </h3>
                </a>

            </div>

        </main>

        <!-- Footer -->
        <footer class="text-center py-6 text-xs text-gray-400 border-t border-rose-100 bg-white">
            KALUNA Kas Digital 🌸
        </footer>

    </div>

</body>
</html>