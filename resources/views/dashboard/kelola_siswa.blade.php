<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Siswa - KALUNA</title>
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
                <h1 class="text-2xl font-black text-gray-800 mt-2">Kelola Data Siswa</h1>
            </div>
        <a href="{{ url('/dashboard/user') }}" class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-4 py-2 rounded-xl text-xs font-bold transition-all">
    &larr; Kembali ke Dashboard
</a>
        </div>

        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-2xl text-xs font-bold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Tambah / Edit Siswa -->
        <div class="bg-white rounded-3xl border border-rose-100 shadow-sm p-6 sm:p-8">
            <h3 id="form-title" class="font-bold text-gray-800 text-sm mb-4">➕ Tambah Siswa Baru</h3>
            <form id="siswa-form" action="{{ route('kelola.siswa.store') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">NISD Siswa</label>
                    <input type="text" id="nisd" name="nisd" required placeholder="Contoh: 22231001" class="w-full bg-rose-50/50 border border-rose-100 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-rose-400">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" id="nama_siswa" name="nama_siswa" required placeholder="Nama siswa..." class="w-full bg-rose-50/50 border border-rose-100 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-rose-400">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Pilih Kelas</label>
                    <select id="kelas_id" name="kelas_id" required class="w-full bg-rose-50/50 border border-rose-100 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-rose-400">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-3 flex gap-2">
                    <button type="submit" id="btn-submit" class="bg-rose-500 hover:bg-rose-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all shadow-md shadow-rose-200">
                        Simpan Data Siswa ✨
                    </button>
                    <button type="button" onclick="resetForm()" id="btn-cancel" class="hidden bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold px-4 py-2.5 rounded-xl text-xs transition-all">
                        Batal Edit
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Daftar Siswa -->
        <div class="bg-white rounded-3xl border border-rose-100 shadow-sm p-6 sm:p-8">
            <h3 class="font-bold text-gray-800 text-sm mb-4">📋 Daftar Siswa Terdaftar</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-rose-100 text-gray-400 font-bold uppercase text-xs">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">NISD</th>
                            <th class="py-3 px-4">Nama Siswa</th>
                            <th class="py-3 px-4">Kelas</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rose-50 text-gray-600">
                        @forelse($siswa as $index => $s)
                        <tr>
                            <td class="py-3.5 px-4">{{ $index + 1 }}</td>
                            <td class="py-3.5 px-4 font-bold text-gray-800">{{ $s->nisd }}</td>
                            <td class="py-3.5 px-4">{{ $s->nama_siswa }}</td>
                            <td class="py-3.5 px-4">
                                <span class="bg-rose-50 text-rose-600 px-2.5 py-1 rounded-lg font-bold text-[11px] border border-rose-100">
                                    {{ $s->kelas->nama_kelas ?? 'Belum ada kelas' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center space-x-2">
                                <!-- Tombol Edit -->
                                <button type="button" onclick="editSiswa('{{ $s->id }}', '{{ $s->nisd }}', '{{ $s->nama_siswa }}', '{{ $s->kelas_id }}')" class="bg-amber-50 hover:bg-amber-100 text-amber-600 px-3 py-1 rounded-lg text-xs font-bold transition-all">
                                    Edit
                                </button>
                                <!-- Tombol Hapus -->
                                <form action="{{ route('kelola.siswa.destroy', $s->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs font-bold transition-all">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-400 text-xs font-medium">Belum ada data siswa yang tersimpan di database.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Script JavaScript untuk Handle Mode Edit -->
    <script>
        function editSiswa(id, nisd, nama, kelasId) {
            const form = document.getElementById('siswa-form');
            form.action = "/dashboard/kelola-siswa/" + id;
            document.getElementById('form-method').value = "PUT";
            document.getElementById('form-title').innerText = "✏️ Edit Data Siswa";
            document.getElementById('nisd').value = nisd;
            document.getElementById('nama_siswa').value = nama;
            document.getElementById('kelas_id').value = kelasId;
            document.getElementById('btn-submit').innerText = "Perbarui Data Siswa ✨";
            document.getElementById('btn-cancel').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function resetForm() {
            const form = document.getElementById('siswa-form');
            form.action = "{{ route('kelola.siswa.store') }}";
            document.getElementById('form-method').value = "POST";
            document.getElementById('form-title').innerText = "➕ Tambah Siswa Baru";
            document.getElementById('nisd').value = "";
            document.getElementById('nama_siswa').value = "";
            document.getElementById('kelas_id').value = "";
            document.getElementById('btn-submit').innerText = "Simpan Data Siswa ✨";
            document.getElementById('btn-cancel').classList.add('hidden');
        }
    </script>
</body>
</html>