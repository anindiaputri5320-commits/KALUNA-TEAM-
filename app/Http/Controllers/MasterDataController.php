<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Iuran;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MasterDataController extends Controller
{
    // --- KELOLA SISWA ---
    public function indexSiswa()
    {
        $siswa = Siswa::with('kelas')->get();
        $kelas = Kelas::all();
        return view('dashboard.kelola_siswa', compact('siswa', 'kelas'));
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'nisd' => 'required|unique:siswa,nisd',
            'nama_siswa' => 'required',
            'kelas_id' => 'required',
        ], [
            'nisd.unique' => 'NISD ini sudah terdaftar! Gunakan NISD lain. ⚠️'
        ]);

        Siswa::create($request->all());

        return back()->with('success', 'Data siswa berhasil disimpan! 🌸');
    }

    public function updateSiswa(Request $request, $id)
    {
        $request->validate([
            'nisd' => 'required',
            'nama_siswa' => 'required',
            'kelas_id' => 'required',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->all());

        return back()->with('success', 'Data siswa berhasil diperbarui! ✨');
    }

    public function destroySiswa($id)
    {
        Siswa::destroy($id);
        return back()->with('success', 'Data siswa berhasil dihapus! 🗑️');
    }

    // --- KELOLA IURAN ---
    public function indexIuran()
    {
        $iuran = Iuran::all();
        return view('dashboard.kelola_iuran', compact('iuran'));
    }

    public function storeIuran(Request $request)
    {
        $request->validate([
            'nama_iuran' => 'required',
            'nominal' => 'required|numeric',
            'periode' => 'required'
        ]);

        Iuran::create($request->all());

        return back()->with('success', 'Data iuran berhasil disimpan! 🌸');
    }

    public function destroyIuran($id)
    {
        Iuran::destroy($id);
        return back()->with('success', 'Data iuran berhasil dihapus! 🗑️');
    }

    // --- KELOLA WALI KELAS ---
    public function indexWaliKelas()
    {
        $walikelas = User::where('role', 'walikelas')->get();
        return view('dashboard.kelola_walikelas', compact('walikelas'));
    }

    public function storeWaliKelas(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:users,username',
            'name' => 'required',
            'password' => 'required'
        ], [
            'nip.unique' => 'NIP/Username ini sudah terdaftar di sistem! Silakan gunakan NIP lain. ⚠️'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->nip,
            'nip' => $request->nip,
            'password' => Hash::make($request->password),
            'role' => 'walikelas'
        ]);

        return back()->with('success', 'Wali kelas berhasil disimpan! 🌸');
    }

    public function destroyWaliKelas($id)
    {
        User::destroy($id);
        return back()->with('success', 'Wali kelas berhasil dihapus! 🗑️');
    }

    // --- KELOLA USER ---
    public function indexUser()
    {
        $users = User::all();
        return view('dashboard.kelola_user', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'password' => 'required',
            'role' => 'required'
        ], [
            'username.unique' => 'Username ini sudah digunakan! Silakan pilih username lain. ⚠️'
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return back()->with('success', 'User berhasil disimpan! 🌸');
    }

    public function destroyUser($id)
    {
        User::destroy($id);
        return back()->with('success', 'User berhasil dihapus! 🗑️');
    }
}