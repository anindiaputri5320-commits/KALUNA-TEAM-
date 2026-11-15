<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - KALUNA</title>
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
                <span class="text-xs bg-pink-100 text-pink-600 px-3 py-0.5 rounded-full font-semibold ml-2">Portal Siswa</span>
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            <span class="text-xs font-semibold text-gray-700 hidden sm:inline">Hai, {{ Auth::user()->name }} 🎒</span>
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
        <div class="pink-gradient text-white p-6 sm:p-8 rounded-3xl shadow-lg shadow-rose-200 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center sm:text-left z-10">
                <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full font-medium backdrop-blur-sm">Status Pembayaran Kas 💖</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold mt-2">Halo, {{ Auth::user()->name }}!</h1>
                <p class="text-rose-100 text-xs sm:text-sm max-w-md">Pantau keteraturan dan riwayat pembayaran iuran kas harian atau mingguanmu di sini.</p>
            </div>
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-2xl text-center min-w-[200px] z-10">
                <span class="text-xs text-rose-100 uppercase tracking-wider font-semibold">Status Kas</span>
                <h3 class="text-lg font-bold text-white mt-1">✨ AKTIF</h3>
            </div>
        </div>

        <!-- Cards Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Total Kas Kelas -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                <p class="text-xs font-bold text-gray-400 uppercase">Total Kas Terkumpul (Kelas)</p>
                <h3 class="text-3xl font-black text-rose-500 mt-2">
                    Rp {{ number_format($totalKasKelas ?? 0, 0, ',', '.') }}
                </h3>
                <p class="text-xs text-gray-400 mt-2">Transparan untuk seluruh warga kelas</p>
            </div>

            <!-- Total Setoran Siswa Yang Login -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                <p class="text-xs font-bold text-gray-400 uppercase">Total Setoran Kamu</p>
                <h3 class="text-3xl font-black text-emerald-500 mt-2">
                    Rp {{ number_format($totalSetoranKamu ?? 0, 0, ',', '.') }}
                </h3>
                <p class="text-xs text-gray-400 mt-2">Terima kasih sudah tertib membayar kas! ✨</p>
            </div>
        </div>

        <!-- Tabel Riwayat Setoran Pribadi Siswa -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-pink-100 shadow-sm space-y-4">
            <h3 class="text-sm font-extrabold text-slate-800 flex items-center gap-2">
                <span>📑</span> Riwayat Pembayaran Setoran Kamu
            </h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-pink-100 text-[11px] uppercase tracking-wider text-slate-400 font-bold">
                            <th class="py-3 px-3">No</th>
                            <th class="py-3 px-3">Tanggal</th>
                            <th class="py-3 px-3">Keterangan / Iuran</th>
                            <th class="py-3 px-3">Periode</th>
                            <th class="py-3 px-3">Jumlah Bayar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-50 text-xs font-medium text-slate-700">
                        @forelse($riwayatSetoran ?? [] as $index => $item)
                            <tr class="hover:bg-rose-50/30 transition-colors">
                                <td class="py-3 px-3 text-slate-400 font-bold">{{ $index + 1 }}</td>
                                <td class="py-3 px-3 text-slate-500">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                                <td class="py-3 px-3 font-bold text-slate-800">{{ $item->nama_iuran }}</td>
                                <td class="py-3 px-3 text-slate-500">{{ $item->periode }}</td>
                                <td class="py-3 px-3 font-black text-emerald-600">+ Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 font-medium">Belum ada catatan setoran kas atas nama kamu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <footer class="text-center py-6 text-xs text-gray-400 border-t border-rose-100 bg-white mt-auto">
        KALUNA Kas Digital 🌸
    </footer>

</body>
</html>