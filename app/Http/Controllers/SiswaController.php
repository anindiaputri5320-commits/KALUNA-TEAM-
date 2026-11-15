<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Transaksi; // 👈 Pastikan model Transaksi di-import

class SiswaController extends Controller
{
    // Menampilkan halaman kelola siswa beserta daftar data siswa & kelas
    public function index()
    {
        $siswa = Siswa::latest()->get();

        // Daftar kelas untuk pilihan dropdown
        $kelas = collect([
            (object)['id' => 'XII RPL 1', 'nama_kelas' => 'XII RPL 1'],
            (object)['id' => 'XII RPL 2', 'nama_kelas' => 'XII RPL 2'],
            (object)['id' => 'XII RPL 3', 'nama_kelas' => 'XII RPL 3'],
            (object)['id' => 'XII RPL 4', 'nama_kelas' => 'XII RPL 4'],
        ]);

        return view('dashboard.kelola_siswa', compact('siswa', 'kelas'));
    }

    // Menyimpan data siswa baru beserta setoran awal kas
    public function store(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'nis'          => 'required|string|max:50|unique:siswa,nis',
            'kelas'        => 'required|string|max:50',
            'status'       => 'required|string',
            'setoran_awal' => 'nullable|numeric', // Validasi input setoran opsional
        ]);

        // Simpan data siswa baru
        $siswa = Siswa::create([
            'nama'   => $request->nama,
            'nis'    => $request->nis,
            'kelas'  => $request->kelas,
            'status' => $request->status,
        ]);

     // Jika bendahara mengisi nominal setoran awal, catat otomatis ke tabel transaksi/iuran
        if ($request->filled('setoran_awal') && $request->setoran_awal > 0) {
            Transaksi::create([
                'siswa_id'   => $siswa->id,
                'nama_iuran' => 'Setoran',       // 👈 Diubah jadi lebih singkat supaya tidak kepanjangan
                'jenis'      => 'pemasukan',
                'jumlah'     => $request->setoran_awal,
                'periode'    => date('F Y'),
                'gambar'     => '',
            ]);
        }

        return redirect()->back()->with('success', 'Data siswa berhasil ditambahkan beserta setoran kasnya! 🌸');
    }

    // Mengubah data siswa
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'nis'    => 'required|string|unique:siswa,nis,' . $id,
            'kelas'  => 'required|string',
            'status' => 'required|string',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update([
            'nama'   => $request->nama,
            'nis'    => $request->nis,
            'kelas'  => $request->kelas,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Data siswa berhasil diperbarui! 🌸');
    }

    // Menghapus data siswa
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus! 🌸');
    }
}