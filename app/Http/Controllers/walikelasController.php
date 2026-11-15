<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\walikelas;  

class walikelasController extends Controller
{
    // Menampilkan halaman kelola wali kelas beserta data yang sudah ada di database
    public function index()
    {
        // Mengambil seluruh data wali kelas dari database
        $walikelas = walikelas::all();

        // Mengirim data ke view dashboard.kelola-walikelas
        return view('dashboard.kelola_walikelas', compact('walikelas'));
    }

    // Menyimpan data wali kelas baru dari form
    public function store(Request $request)
    {
        // Validasi input data dari form secara lengkap
        $request->validate([
            'nip' => 'required|string|unique:walikelas,nip',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:100',
        ]);

        // Menyimpan data ke database
        walikelas::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
        ]);

        return redirect()->route('dashboard.kelola_walikelas')->with('success', 'Data wali kelas berhasil ditambahkan!');
    }
}