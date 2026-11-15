<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Iuran & Transaksi - KALUNA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fff5f7; }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased">

    <!-- Top Navbar -->
    <nav class="bg-white/90 backdrop-blur-md shadow-sm border-b border-rose-100 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-2xl bg-rose-100 flex items-center justify-center text-rose-500 font-bold text-xl shadow-inner">🌸</div>
            <div>
                <span class="font-bold text-gray-800 text-lg tracking-wide">KALUNA</span>
                <span class="text-xs bg-rose-100 text-rose-600 px-3 py-0.5 rounded-full font-semibold ml-2">Kelola Iuran</span>
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            @php
                $userRole = Auth::user()->role ?? 'user';
                $backRoute = match($userRole) {
                    'bendahara' => route('dashboard.bendahara'),
                    'walikelas' => route('dashboard.walikelas'),
                    'siswa'     => route('dashboard.siswa'),
                    default     => route('dashboard.user'),
                };
            @endphp
            <a href="{{ $backRoute }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold rounded-xl transition-all shadow-sm">
                <span>←</span> Kembali
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-all shadow-md active:scale-95">
                    Keluar 🚪
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 p-4 sm:p-8 max-w-7xl mx-auto w-full space-y-8">

        @if(session('success'))
            <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-2xl text-xs font-bold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Form Input Transaksi & Pilih Siswa -->
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-rose-100 h-fit">
                <h2 class="text-lg font-bold text-gray-800 mb-1">Tambah Transaksi Kas ✨</h2>
                <p class="text-xs text-gray-400 mb-6">Catat setoran siswa atau pengeluaran dana kelas.</p>

                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    
                    <!-- Pilih Nama Siswa -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Nama Siswa (Penyetor)</label>
                        <select name="siswa_id" class="w-full px-4 py-3 rounded-xl border border-rose-100 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400 bg-white">
                            <option value="">-- Pilih Siswa (Opsional / Kas Umum) --</option>
                            @foreach($siswa ?? [] as $s)
                                <option value="{{ $s->id }}">{{ $s->nama }} (NIS: {{ $s->nis }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Keterangan / Nama Iuran -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Keterangan / Nama Iuran</label>
                        <input type="text" name="nama_iuran" required class="w-full px-4 py-3 rounded-xl border border-rose-100 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400" placeholder="Contoh: Kas Minggu ke-1 / Beli Spidol">
                    </div>

                    <!-- Jenis Transaksi -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Jenis Transaksi</label>
                        <select name="jenis" required class="w-full px-4 py-3 rounded-xl border border-rose-100 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400 bg-white">
                            <option value="pemasukan">💰 Pemasukan (Setor Kas)</option>
                            <option value="pengeluaran">💸 Pengeluaran (Kas Keluar)</option>
                        </select>
                    </div>

                    <!-- Jumlah Nominal -->
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Jumlah Nominal (Rp)</label>
                        <input type="number" name="jumlah" required class="w-full px-4 py-3 rounded-xl border border-rose-100 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400" placeholder="Contoh: 10000">
                    </div>

                    <!-- Periode -->
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Periode</label>
                        <input type="text" name="periode" required class="w-full px-4 py-3 rounded-xl border border-rose-100 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400" placeholder="Contoh: November 2026">
                    </div>

                    <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-3.5 rounded-2xl shadow-md transition-all active:scale-95 text-xs uppercase">
                        Simpan Transaksi 🌸
                    </button>
                </form>
            </div>

            <!-- Tabel Daftar Transaksi dengan Nama Siswa -->
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-rose-100 p-6 sm:p-8">
                <h2 class="text-lg font-bold text-gray-800 mb-1">Daftar Transaksi Kas 📑</h2>
                <p class="text-xs text-gray-400 mb-6">Riwayat lengkap dengan nama penyetor.</p>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-rose-100 text-xs text-gray-400 uppercase tracking-wider">
                                <th class="pb-3 px-3">Tanggal</th>
                                <th class="pb-3 px-3">Nama Siswa / Penyetor</th>
                                <th class="pb-3 px-3">Keterangan</th>
                                <th class="pb-3 px-3">Jenis</th>
                                <th class="pb-3 px-3">Jumlah</th>
                                <th class="pb-3 px-3 text-center">Aksi</th>
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
                                    <td class="py-4 px-3 text-center">
                                        <form action="{{ route('transaksi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-rose-100 hover:bg-rose-200 text-rose-600 text-xs px-3 py-1.5 rounded-xl font-bold transition-all">
                                                Hapus 🗑️
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="py-8 text-center text-xs text-gray-400" colspan="6">
                                        Belum ada data transaksi kas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <footer class="text-center py-6 text-xs text-gray-400 border-t border-rose-100 bg-white mt-auto">
        KALUNA Kas Digital 🌸
    </footer>
</body>
</html>