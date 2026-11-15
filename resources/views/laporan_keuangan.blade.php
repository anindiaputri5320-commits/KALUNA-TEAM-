<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - KALUNA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fff5f7; }
        .pink-gradient { background: linear-gradient(135deg, #fb7185 0%, #e11d48 100%); }
    </style>
</head>
<body class="min-h-screen flex antialiased">

    <!-- Sidebar Navigation -->
    @include('components.sidebar')

    <!-- Konten Utama -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Top Navbar -->
        <nav class="bg-white/90 backdrop-blur-md shadow-sm border-b border-rose-100 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
            <div class="flex items-center space-x-3">
                <span class="font-bold text-gray-800 text-base tracking-wide">KALUNA Kas Digital 🌸</span>
                <span class="text-xs bg-rose-100 text-rose-600 px-3 py-0.5 rounded-full font-semibold">Laporan Keuangan</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-xs font-semibold text-gray-700 hidden sm:inline">Halo, {{ Auth::user()->name ?? 'Bendahara' }} 👑</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-all shadow-md active:scale-95 cursor-pointer">
                        Keluar 🚪
                    </button>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-4 sm:p-8 max-w-7xl mx-auto w-full space-y-8 overflow-y-auto">
            
            <!-- Banner Header -->
            <div class="pink-gradient text-white p-6 sm:p-8 rounded-3xl shadow-lg shadow-rose-200 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center sm:text-left z-10">
                    <span class="bg-white/20 text-white text-xs px-3 py-1 rounded-full font-medium backdrop-blur-sm">Rekapitulasi Transaksi 📊</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold mt-2">Laporan Keuangan Kelas</h1>
                    <p class="text-rose-100 text-xs sm:text-sm max-w-md">Laporan transparan seluruh pemasukan, pengeluaran, dan saldo akhir kas kelas.</p>
                </div>
            </div>

            <!-- Cards Ringkasan -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Saldo Akhir</p>
                    <h3 class="text-3xl font-black text-rose-500 mt-2">
                        Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Pemasukan</p>
                    <h3 class="text-3xl font-black text-emerald-500 mt-2">
                        + Rp {{ number_format($totalPemasukan ?? 0, 0, ',', '.') }}
                    </h3>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-rose-100">
                    <p class="text-xs font-bold text-gray-400 uppercase">Total Pengeluaran</p>
                    <h3 class="text-3xl font-black text-amber-500 mt-2">
                        - Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}
                    </h3>
                </div>
            </div>

            <!-- TABEL DETAIL LAPORAN & FILTER TANGGAL -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-rose-100 space-y-6">
                
                <!-- Header Tabel & Form Filter Tanggal / Cetak -->
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 border-b border-rose-100 pb-6">
                    <h3 class="text-sm font-extrabold text-slate-800 flex items-center gap-2">
                        <span>📄</span> Detail Riwayat Arus Kas
                    </h3>

                    <!-- Form Filter & Tombol Print -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full lg:w-auto">
                        <form action="{{ route('laporan.keuangan') }}" method="GET" class="flex flex-wrap items-center gap-2">
                            <div class="flex items-center gap-1.5">
                                <span class="text-[11px] font-bold text-gray-400">Dari:</span>
                                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="px-3 py-2 rounded-xl border border-rose-200 text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-rose-400 bg-rose-50/20">
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="text-[11px] font-bold text-gray-400">Sampai:</span>
                                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="px-3 py-2 rounded-xl border border-rose-200 text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-rose-400 bg-rose-50/20">
                            </div>
                            <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold px-4 py-2 rounded-xl text-xs shadow-md shadow-rose-200 transition-all cursor-pointer">
                                🔍 Filter
                            </button>
                            @if(request('tanggal_mulai') || request('tanggal_selesai'))
                                <a href="{{ route('laporan.keuangan') }}" class="text-xs text-gray-400 hover:text-rose-500 underline px-1">Reset</a>
                            @endif
                        </form>

                        <!-- Tombol Cetak / Print -->
                        <a href="{{ route('laporan.keuangan', array_merge(request()->all(), ['print' => true])) }}" target="_blank" class="bg-slate-800 hover:bg-slate-900 text-white font-bold px-4 py-2 rounded-xl text-xs shadow-md transition-all flex items-center justify-center gap-2">
                            <span>🖨️ Cetak / Print</span>
                        </a>
                    </div>
                </div>

                <!-- Tabel Data Transaksi -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-rose-100 text-xs text-gray-400 uppercase tracking-wider">
                                <th class="pb-3 px-3">No</th>
                                <th class="pb-3 px-3">Tanggal</th>
                                <th class="pb-3 px-3">Nama Siswa </th>
                                <th class="pb-3 px-3">Keterangan</th>
                                <th class="pb-3 px-3">Jenis</th>
                                <th class="pb-3 px-3">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-600 divide-y divide-rose-50">
                            @forelse($transaksi ?? [] as $index => $item)
                                <tr class="hover:bg-rose-50/30 transition-colors">
                                    <td class="py-4 px-3 text-xs font-medium text-gray-500">{{ $index + 1 }}</td>
                                    <td class="py-4 px-3 text-xs font-medium text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                    </td>
                                    <td class="py-4 px-3 font-bold text-rose-600">
                                     <!-- Ubah menjadi seperti ini: -->
{{ $item->siswa->nama ?? '-' }}
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
                                    <td class="py-8 text-center text-xs text-gray-400" colspan="6">
                                        Belum ada data transaksi keuangan tercatat pada periode ini.
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