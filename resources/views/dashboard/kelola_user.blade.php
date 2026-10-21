<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - KALUNA Digital Cash</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; background-color: #fff5f7; } </style>
</head>
<body class="min-h-screen text-gray-800 p-4 sm:p-6">
    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-white rounded-3xl border border-rose-100 shadow-sm p-6 sm:p-8 flex justify-between items-center">
            <div>
                <span class="bg-rose-50 text-rose-600 px-3 py-1 rounded-full text-xs font-bold">🌸 Master Data</span>
                <h1 class="text-2xl font-black text-gray-800 mt-2">Kelola Akun User & Hak Akses</h1>
            </div>
            <a href="{{ route('dashboard.user') }}" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2 rounded-xl text-xs font-bold transition-all">
                &larr; Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-2xl text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Tambah User -->
        <div class="bg-white rounded-3xl border border-rose-100 shadow-sm p-6 sm:p-8">
            <h3 class="font-bold text-gray-800 text-sm mb-4">➕ Tambah Akun User Baru</h3>
            <form action="{{ route('kelola.user.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @csrf
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Nama user..." class="w-full bg-rose-50/50 border border-rose-100 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-rose-400">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Username</label>
                    <input type="text" name="username" required placeholder="Username..." class="w-full bg-rose-50/50 border border-rose-100 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-rose-400">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Role / Hak Akses</label>
                    <select name="role" required class="w-full bg-rose-50/50 border border-rose-100 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-rose-400">
                        <option value="user">User Biasa</option>
                        <option value="bendahara">Bendahara</option>
                        <option value="walikelas">Wali Kelas</option>
                        <option value="siswa">Siswa</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Password..." class="w-full bg-rose-50/50 border border-rose-100 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-rose-400">
                </div>
                <div class="sm:col-span-2 lg:col-span-4">
                    <button type="submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all shadow-md shadow-rose-200">
                        Simpan Akun User ✨
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel User -->
        <div class="bg-white rounded-3xl border border-rose-100 shadow-sm p-6 sm:p-8">
            <h3 class="font-bold text-gray-800 text-sm mb-4">📋 Daftar Akun Terdaftar</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-rose-100 text-gray-400 font-bold uppercase text-xs">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Nama Lengkap</th>
                            <th class="py-3 px-4">Username</th>
                            <th class="py-3 px-4">Role</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rose-50 text-gray-600">
                        @forelse($users as $index => $u)
                        <tr>
                            <td class="py-3.5 px-4">{{ $index + 1 }}</td>
                            <td class="py-3.5 px-4 font-bold text-gray-800">{{ $u->name }}</td>
                            <td class="py-3.5 px-4">{{ $u->username ?? $u->nip ?? '-' }}</td>
                            <td class="py-3.5 px-4">
                                <span class="bg-rose-50 text-rose-600 px-2.5 py-1 rounded-lg font-bold text-[11px] border border-rose-100 uppercase">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <form action="{{ route('kelola.user.destroy', $u->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus user ini?')" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs font-bold transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-400 text-xs font-medium">Belum ada akun user terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>