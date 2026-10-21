<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bendahara - KALUNA</title>
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
                <span class="text-xs bg-rose-100 text-rose-600 px-3 py-0.5 rounded-full font-semibold ml-2">Bendahara</span>
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            <span class="text-xs font-semibold text-gray-700 hidden sm:inline">Bendahara: {{ Auth::user()->name }} 👑</span>
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
        
        <!-- Welcome Banner & Action Buttons (CRUD Create) -->
        <div class="pink-gradient text-white p-6 sm:p-8 rounded-3xl shadow-lg shadow-rose-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="z-10 space-y-2">
                <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full font-medium backdrop-blur-sm">Panel Kelola Kas ✨</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold mt-2">Halo, {{ Auth::user()->name }}!</h1>
                <p class="text-rose-100 text-xs sm:text-sm max-w-lg">Kelola pencatatan keuangan kelas dengan mudah, akurat, dan transparan.</p>
            </div>
            <div class="flex flex-wrap gap-3 z-10 w-full md:w-auto">
                <button class="flex-1 md:flex-none bg-white text-rose-600 hover:bg-rose-50 text-xs font-bold px-5 py-3.5 rounded-2xl shadow-md transition-all active:scale-95">
                    + Setor Kas
                </button>
                <button class="flex-1 md:flex-none bg-rose-900/40 hover:bg-rose-900/60 text-white text-xs font-bold px-5 py-3.5 rounded-2xl backdrop-blur-md border border-white/20 transition-all active:scale-95">
                    - Catat Pengeluaran
                </button>
            </div>
        </div>

        <!-- Ringkasan Kas Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                <p class="text-xs font-bold text-gray-400 uppercase">Total Saldo Kas</p>
                <h3 class="text-3xl font-black text-rose-500 mt-2">Rp 0</h3>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                <p class="text-xs font-bold text-gray-400 uppercase">Pemasukan Bulan Ini</p>
                <h3 class="text-3xl font-black text-emerald-500 mt-2">+ Rp 0</h3>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                <p class="text-xs font-bold text-gray-400 uppercase">Pengeluaran Bulan Ini</p>
                <h3 class="text-3xl font-black text-amber-500 mt-2">- Rp 0</h3>
            </div>
        </div>

        <!-- Tabel Transaksi Kas (Fitur CRUD Read, Update, Delete) -->
        <div class="bg-white rounded-3xl shadow-sm border border-rose-100 p-6 sm:p-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-lg font-bold text-gray-800">Catatan Transaksi Kas 📑</h2>
                    <p class="text-xs text-gray-400">Kelola arus masuk dan keluar dana kas digital.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-rose-100 text-xs text-gray-400 uppercase tracking-wider">
                            <th class="pb-3 px-4">Tanggal</th>
                            <th class="pb-3 px-4">Keterangan</th>
                            <th class="pb-3 px-4">Jenis</th>
                            <th class="pb-3 px-4">Jumlah</th>
                            <th class="pb-3 px-4 text-center">Aksi (Edit / Hapus)</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-600 divide-y divide-rose-50">
                        <tr>
                            <td class="py-8 text-center text-xs text-gray-400" colspan="5">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <span class="text-3xl">🌸</span>
                                    <span>Belum ada data transaksi. Klik tombol <b>+ Setor Kas</b> di atas untuk mulai mencatat.</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <footer class="text-center py-6 text-xs text-gray-400 border-t border-rose-100 bg-white">
        KALUNA Kas Digital — Dibuat dengan ❤️ oleh Anindia & Dita
    </footer>

</body>
</html>