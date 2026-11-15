<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Siswa - KALUNA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fff5f7; }
        .pink-gradient { background: linear-gradient(135deg, #fb7185 0%, #e11d48 100%); }
    </style>
</head>
<body class="min-h-screen flex antialiased">

    @php
        $userRole = auth()->user()->role ?? 'user';
        // Tentukan rute dashboard tujuan tombol kembali secara dinamis berdasarkan role yang login
        $dashboardRoute = match($userRole) {
            'admin'     => route('dashboard.user'),
            'bendahara' => route('dashboard.bendahara'),
            'walikelas' => route('dashboard.walikelas'),
            'siswa'     => route('dashboard.siswa'),
            default     => route('dashboard.user'), 
        };
    @endphp

    <!-- Sidebar Navigation -->
    @include('components.sidebar')

    <!-- Konten Utama -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Top Navbar -->
        <nav class="bg-white/90 backdrop-blur-md shadow-sm border-b border-rose-100 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
            <div class="flex items-center space-x-3">
                <a href="{{ $dashboardRoute }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold rounded-xl transition-all">
                    <span>←</span> Dashboard
                </a>
                <span class="font-bold text-gray-800 text-base tracking-wide">KALUNA Kas Digital 🌸</span>
                <span class="text-xs bg-rose-100 text-rose-600 px-3 py-0.5 rounded-full font-semibold">Kelola Siswa</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <span class="text-xs font-semibold text-gray-700 hidden sm:inline">
                    Halo, {{ Auth::user()->name ?? 'User' }} 
                    <span class="text-[10px] bg-rose-100 text-rose-600 px-2.5 py-0.5 rounded-full uppercase font-bold ml-1">{{ $userRole }}</span>
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

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-2xl text-xs font-bold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Notifikasi Error Validasi -->
            @if($errors->any())
                <div class="bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-2xl text-xs font-bold shadow-sm">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Form Tambah Siswa (Kiri) -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-rose-100 h-fit">
                    <h2 class="text-lg font-bold text-gray-800 mb-1">Tambah Data Siswa 🎓</h2>
                    <p class="text-xs text-gray-400 mb-6">Daftarkan siswa baru ke dalam sistem kas kelas.</p>

                    <form action="{{ route('kelola.siswa.store') }}" method="POST">
                        @csrf
                        
                        <!-- Input Nama Lengkap -->
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Nama Lengkap Siswa</label>
                            <input type="text" name="nama" required class="w-full px-4 py-3 rounded-xl border border-rose-100 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400" placeholder="Contoh: Anindia Putri">
                        </div>

                        <!-- Input NIS -->
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">NIS / Nomor Induk</label>
                            <input type="text" name="nis" required class="w-full px-4 py-3 rounded-xl border border-rose-100 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400" placeholder="Contoh: 222310025">
                        </div>

                        <!-- Pilihan Kelas -->
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Kelas</label>
                            <select name="kelas" required class="w-full px-4 py-3 rounded-xl border border-rose-100 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400 bg-white">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelas ?? [] as $k)
                                    <option value="{{ $k->nama_kelas }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Pembayaran -->
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Status Pembayaran</label>
                            <select name="status" required class="w-full px-4 py-3 rounded-xl border border-rose-100 text-sm focus:outline-none focus:ring-2 focus:ring-rose-400 bg-white">
                                <option value="Aktif">Aktif 🟢</option>
                                <option value="Lunas">Lunas ✨</option>
                                <option value="Menunggak">Menunggak ⚠️</option>
                            </select>
                        </div>

                        <!-- Input Nominal Setoran Awal Kas -->
<div class="space-y-1.5">
    <label class="text-xs font-bold text-gray-600">NOMINAL SETORAN AWAL (OPSIONAL)</label>
    <div class="relative flex items-center">
        <span class="absolute left-4 text-xs font-bold text-gray-400">Rp</span>
        <input type="number" name="setoran_awal" placeholder="Contoh: 10000" class="w-full pl-10 pr-4 py-3 rounded-2xl border border-rose-100 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-rose-400 bg-rose-50/20">
    </div>
</div>

                        <!-- Tombol Simpan -->
                        <button type="submit" class="w-full bg-rose-500 hover:bg-rose-600 text-white font-bold py-3.5 rounded-2xl shadow-md shadow-rose-200 transition-all active:scale-95 text-xs tracking-wider uppercase">
                            Simpan Data Siswa 🌸
                        </button>
                    </form>
                </div>

                <!-- Tabel Data Siswa (Kanan) dengan Kolom Total Setoran -->
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-rose-100 p-6 sm:p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Daftar Siswa Binaan 📚</h2>
                            <p class="text-xs text-gray-400">Kelola dan pantau daftar seluruh siswa beserta total setoran kas.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-rose-100 text-xs text-gray-400 uppercase tracking-wider">
                                    <th class="pb-3 px-3">No</th>
                                    <th class="pb-3 px-3">Nama Siswa</th>
                                    <th class="pb-3 px-3">NIS</th>
                                    <th class="pb-3 px-3">Kelas</th>
                                    <th class="pb-3 px-3">Total Setoran</th>
                                    <th class="pb-3 px-3">Status</th>
                                    <th class="pb-3 px-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-rose-50 text-sm text-gray-600">
                                @forelse($siswa ?? [] as $index => $s)
                                    @php
                                        // Menghitung total setoran pemasukan berdasarkan ID siswa
                                        $totalSetoran = \App\Models\Transaksi::where('siswa_id', $s->id)
                                                            ->where('jenis', 'pemasukan')
                                                            ->sum('jumlah');
                                    @endphp
                                    <tr class="hover:bg-rose-50/30 transition-colors">
                                        <td class="py-4 px-3 text-xs font-medium text-gray-500">{{ $index + 1 }}</td>
                                        <td class="py-4 px-3 font-bold text-gray-800">{{ $s->nama }}</td>
                                        <td class="py-4 px-3 text-xs text-gray-600">{{ $s->nis }}</td>
                                        <td class="py-4 px-3 text-xs font-semibold text-gray-600">{{ $s->kelas }}</td>
                                        <td class="py-4 px-3 font-black text-emerald-600">
                                            Rp {{ number_format($totalSetoran, 0, ',', '.') }}
                                        </td>
                                        <td class="py-4 px-3">
                                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                                                {{ $s->status == 'Lunas' ? 'bg-emerald-50 text-emerald-600' : ($s->status == 'Menunggak' ? 'bg-amber-50 text-amber-600' : 'bg-blue-50 text-blue-600') }}">
                                                {{ $s->status }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-3 text-center">
                                            <form action="{{ route('kelola.siswa.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
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
                                        <td class="py-8 text-center text-xs text-gray-400" colspan="7">
                                            <div class="flex flex-col items-center justify-center space-y-2">
                                                <span class="text-3xl">🌸</span>
                                                <span>Belum ada data siswa yang ditambahkan. Silakan input melalui form di samping.</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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