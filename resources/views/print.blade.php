<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Keuangan - KALUNA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #ffffff; color: #1e293b; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="p-8 space-y-6">

    <!-- Tombol Print Otomatis saat dibuka -->
    <div class="no-print flex justify-end gap-3">
        <button onclick="window.print()" class="bg-rose-500 text-white px-6 py-2 rounded-xl font-bold text-xs shadow">🖨️ Print Sekarang</button>
        <button onclick="window.close()" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-xl font-bold text-xs">Tutup</button>
    </div>

    <!-- Kop Laporan -->
    <div class="text-center space-y-1 border-b pb-4 border-gray-200">
        <h1 class="text-xl font-black text-rose-600">KALUNA KAS DIGITAL 🌸</h1>
        <p class="text-xs font-semibold text-gray-500">Laporan Resmi Arus Kas Kelas</p>
        @if(request('tanggal_mulai') && request('tanggal_selesai'))
            <p class="text-[11px] text-gray-400">Periode Tanggal: {{ request('tanggal_mulai') }} s/d {{ request('tanggal_selesai') }}</p>
        @endif
    </div>

    <!-- Ringkasan Saldo -->
    <div class="grid grid-cols-3 gap-4 text-center py-2">
        <div class="p-3 border rounded-2xl bg-rose-50/50">
            <p class="text-[10px] text-gray-400 uppercase font-bold">Total Pemasukan</p>
            <p class="text-sm font-black text-emerald-600">+ Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        </div>
        <div class="p-3 border rounded-2xl bg-rose-50/50">
            <p class="text-[10px] text-gray-400 uppercase font-bold">Total Pengeluaran</p>
            <p class="text-sm font-black text-amber-600">- Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
        </div>
        <div class="p-3 border rounded-2xl bg-rose-50/50">
            <p class="text-[10px] text-gray-400 uppercase font-bold">Saldo Akhir</p>
            <p class="text-sm font-black text-rose-600">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Tabel Riwayat Transaksi -->
    <table class="w-full text-left border-collapse border border-gray-200 text-xs">
        <thead>
            <tr class="bg-gray-100 text-gray-600 uppercase">
                <th class="border border-gray-200 p-2 text-center">No</th>
                <th class="border border-gray-200 p-2">Tanggal</th>
                <th class="border border-gray-200 p-2">Penyetor / Siswa</th>
                <th class="border border-gray-200 p-2">Keterangan</th>
                <th class="border border-gray-200 p-2">Jenis</th>
                <th class="border border-gray-200 p-2 text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $index => $item)
                <tr>
                    <td class="border border-gray-200 p-2 text-center">{{ $index + 1 }}</td>
                    <td class="border border-gray-200 p-2">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                    <td class="border border-gray-200 p-2 font-bold">{{ $item->siswa->nama ?? 'Kas Umum' }}</td>
                    <td class="border border-gray-200 p-2">{{ $item->nama_iuran }} (Periode: {{ $item->periode }})</td>
                    <td class="border border-gray-200 p-2 uppercase font-bold text-[10px]">{{ $item->jenis }}</td>
                    <td class="border border-gray-200 p-2 text-right font-black {{ $item->jenis == 'pemasukan' ? 'text-emerald-600' : 'text-amber-600' }}">
                        {{ $item->jenis == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border border-gray-200 p-4 text-center text-gray-400">Tidak ada data transaksi pada rentang tanggal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>