<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Bendahara - KALUNA Kas Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fff5f7; }
        .pink-gradient { background: linear-gradient(135deg, #fb7185 0%, #e11d48 100%); }
    </style>
</head>
<body class="min-h-screen flex antialiased">

    <!-- Sidebar Navigation (Kiri) -->
    @include('components.sidebar')

    <!-- Konten Utama (Kanan) -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Top Navbar -->
        <nav class="bg-white/90 backdrop-blur-md shadow-sm border-b border-rose-100 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
            <div class="flex items-center space-x-3">
                <span class="font-bold text-gray-800 text-base tracking-wide">KALUNA Kas Digital 🌸</span>
                <span class="text-xs bg-rose-100 text-rose-600 px-3 py-0.5 rounded-full font-semibold">Dashboard Bendahara</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-xs font-semibold text-gray-700 hidden sm:inline">
                    Halo, {{ Auth::user()->name ?? 'Bendahara' }} 
                    <span class="text-[10px] bg-rose-100 text-rose-600 px-2.5 py-0.5 rounded-full uppercase font-bold ml-1">{{ Auth::user()->role ?? 'bendahara' }}</span>
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-all shadow-md shadow-rose-200 active:scale-95">
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
                    <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full font-medium backdrop-blur-sm">Panel Kelola Kas ✨</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold mt-2">Dashboard Bendahara</h1>
                    <p class="text-rose-100 text-xs sm:text-sm max-w-md">Kelola pencatatan keuangan kelas dengan mudah, akurat, dan transparan.</p>
                </div>
                <div>
                    <!-- Tombol Kelola / Setor Kas di Banner Dashboard Bendahara -->
                    <a href="{{ route('kelola.iuran') }}" class="bg-white hover:bg-rose-50 text-rose-600 font-bold px-6 py-3.5 rounded-2xl shadow-md transition-all text-xs uppercase tracking-wider block text-center">
                        + Kelola / Setor Kas 🌸
                    </a>
                </div>
            </div>

            <!-- Cards Statistik (Total Saldo, Pemasukan, Pengeluaran) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Total Saldo Kas -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Saldo Kas</p>
                    <h3 class="text-3xl font-black text-rose-500 mt-2">
                        Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <!-- Total Pemasukan -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Pemasukan</p>
                    <h3 class="text-3xl font-black text-emerald-500 mt-2">
                        + Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <!-- Total Pengeluaran -->
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Pengeluaran</p>
                    <h3 class="text-3xl font-black text-amber-500 mt-2">
                        - Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <!-- Tabel Catatan Transaksi Kas -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-rose-100 space-y-4">
                <h3 class="text-sm font-extrabold text-slate-800 flex items-center gap-2">
                    <span>📄</span> Catatan Transaksi Kas
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-rose-100 text-xs text-gray-400 uppercase tracking-wider">
                                <th class="pb-3 px-3">Tanggal</th>
                                <th class="pb-3 px-3">Nama Siswa / Penyetor</th>
                                <th class="pb-3 px-3">Keterangan</th>
                                <th class="pb-3 px-3">Jenis</th>
                                <th class="pb-3 px-3">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-600 divide-y divide-rose-50">
                            @forelse($transaksi ?? [] as $item)
                                <tr class="hover:bg-rose-50/30 transition-colors">
                                    <td class="py-4 px-3 text-xs font-medium text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                    </td>
                                    <td class="py-4 px-3 font-bold text-rose-600">
                                        {{ $item->siswa->nama ?? 'Kas Umum / Pengeluaran' }}
                                    </td>
                                    <td class="py-4 px-3 text-gray-800">
                                        {{ $item->nama_iuran }}
                                        <div class="text-[11px] font-normal text-gray-400">Periode: {{ $item->periode }}</div>
                                    </td>
                                    <td class="py-4 px-3">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $item->jenis == 'pemasukan' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                                            {{ $item->jenis }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-3 font-black {{ $item->jenis == 'pemasukan' ? 'text-emerald-600' : 'text-amber-600' }}">
                                        {{ $item->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-8 text-center text-xs text-gray-400" colspan="5">
                                        Belum ada data transaksi. Silakan tambah melalui menu Kelola Iuran.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

        <!-- Footer -->
        <footer class="text-center py-6 text-xs text-gray-400 border-t border-rose-100 bg-white">
            KALUNA Kas Digital 🌸
        </footer>

    </div>

</body>
</html>