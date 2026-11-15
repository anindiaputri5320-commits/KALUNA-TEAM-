<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola walikelas - KALUNA Digital Cash</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; background-color: #fff5f7; } </style>
</head>
<body class="min-h-screen text-gray-800 p-4 sm:p-6">
    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-white rounded-3xl border border-rose-100 shadow-sm p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="bg-rose-50 text-rose-600 px-3 py-1 rounded-full text-xs font-bold">🌸 Master Data</span>
                <h1 class="text-2xl font-black text-gray-800 mt-2">Kelola Data wali kelas</h1>
            </div>
            <!-- Tombol Kembali menggunakan history.back() -->
            <button onclick="history.back()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold rounded-xl transition-all duration-200 shadow-sm">
                <span>←</span> Kembali
            </button>
        </div>

        <!-- Pesan Sukses -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-2xl text-xs font-bold shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Pesan Error Validasi -->
        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-2xl text-xs font-bold shadow-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Tambah walikelas -->
        <div class="bg-white rounded-3xl border border-rose-100 shadow-sm p-6 sm:p-8">
            <h3 class="font-bold text-gray-800 text-sm mb-4">➕ Tambah walikelas Baru</h3>
            <form action="{{ route('kelola_walikelas.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @csrf
                
                <!-- Input untuk NIP -->
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">NIP Guru</label>
                    <input type="text" name="nip" value="{{ old('nip') }}" required placeholder="Contoh: 19850101..." class="w-full bg-rose-50/50 border border-rose-100 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-rose-400">
                </div>

                <!-- Input untuk Nama -->
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Nama wali kelas</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Nama lengkap & gelar..." class="w-full bg-rose-50/50 border border-rose-100 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-rose-400">
                </div>

                <!-- Input untuk Kelas -->
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Kelas</label>
                    <input type="text" name="kelas" value="{{ old('kelas') }}" required placeholder="Contoh: XII RPL 1..." class="w-full bg-rose-50/50 border border-rose-100 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-rose-400">
                </div>

                <div class="sm:col-span-3">
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all shadow-md shadow-rose-200">
                        Simpan Data ✨
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Daftar walikelas -->
        <div class="bg-white rounded-3xl border border-rose-100 shadow-sm p-6 sm:p-8">
            <h3 class="font-bold text-gray-800 text-sm mb-4">📋 Daftar wali kelas</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-rose-100 text-gray-400 font-bold uppercase text-xs">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">NIP</th>
                            <th class="py-3 px-4">Nama wali kelas</th>
                            <th class="py-3 px-4">Kelas</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rose-50 text-gray-600">
                        @forelse($walikelas as $index => $w)
                        <tr>
                            <td class="py-3.5 px-4">{{ $index + 1 }}</td>
                            <td class="py-3.5 px-4 font-bold text-gray-800">{{ $w->nip }}</td>
                            <td class="py-3.5 px-4">{{ $w->nama }}</td>
                            <td class="py-3.5 px-4">
                                <span class="bg-rose-50 text-rose-600 px-2.5 py-1 rounded-lg text-xs font-bold">
                                    {{ $w->kelas }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('kelola.walikelas.destroy', $w->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus data wali kelas ini?')" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs font-bold transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-400 text-xs font-medium">Belum ada data wali kelas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>