<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('siswa')->latest()->get();
        $siswa = \App\Models\Siswa::all(); 

        return view('dashboard.kelola_iuran', compact('transaksi', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_iuran' => 'required|string|max:255',
            'jenis'      => 'required|in:pemasukan,pengeluaran',
            'jumlah'     => 'required|numeric',
            'periode'    => 'required|string|max:50',
            'siswa_id'   => 'nullable|exists:siswa,id', 
        ]);

        Transaksi::create([
            'siswa_id'   => $request->siswa_id,
            'nama_iuran' => $request->nama_iuran,
            'jenis'      => $request->jenis,
            'jumlah'     => $request->jumlah,
            'periode'    => $request->periode,
        ]);

        return back()->with('success', 'Setoran siswa berhasil dicatat! 🌸');
    }

    // Fungsi untuk menampilkan Dashboard Bendahara
    public function dashboardBendahara()
    {
        $totalPemasukan = Transaksi::where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = Transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;
        $totalSiswa = class_exists('\App\Models\Siswa') ? \App\Models\Siswa::count() : 0;
        
        // Ambil daftar transaksi terbaru beserta relasi siswa untuk ditampilkan di tabel
        $transaksi = Transaksi::with('siswa')->latest()->get(); 

        return view('dashboard.bendahara', compact('totalSaldo', 'totalPemasukan', 'totalPengeluaran', 'totalSiswa', 'transaksi'));
    }

   // ==========================================
    // FUNGSI LAPORAN KEUANGAN
    // ==========================================
    public function laporanKeuangan(Request $request)
    {
        $query = Transaksi::with('siswa');

        // Filter berdasarkan rentang tanggal jika diisi
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('created_at', [$request->tanggal_mulai . ' 00:00:00', $request->tanggal_selesai . ' 23:59:59']);
        }

        $transaksi = $query->latest()->get();

        $totalPemasukan = $transaksi->where('jenis', 'pemasukan')->sum('jumlah');
        $totalPengeluaran = $transaksi->where('jenis', 'pengeluaran')->sum('jumlah');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        // Jika tombol cetak / print ditekan (langsung panggil print.blade.php di views)
        if ($request->has('print')) {
            return view('print', compact('transaksi', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo', 'request'));
        }

        // Tampilan utama laporan keuangan (langsung panggil laporan_keuangan.blade.php di views)
        return view('laporan_keuangan', compact('transaksi', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_iuran' => 'required|string|max:255',
            'jumlah'     => 'required|numeric',
            'periode'    => 'required|string',
        ]);

        $iuran = Transaksi::findOrFail($id);
        $iuran->update([
            'nama_iuran' => $request->nama_iuran,
            'jumlah'     => $request->jumlah,
            'periode'    => $request->periode,
        ]);

        return redirect()->back()->with('success', 'Data iuran berhasil diperbarui/diganti! 🌸');
    }

    public function destroy($id)
    {
        $iuran = Transaksi::findOrFail($id);
        $iuran->delete();

        return redirect()->back()->with('success', 'Data iuran berhasil dihapus! 🌸');
    }
}