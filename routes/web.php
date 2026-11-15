<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\walikelascontroller;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\SiswaController;
use App\Models\Transaksi;
use App\Models\Siswa;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect Halaman Utama ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Dashboard Berdasarkan Role
Route::get('/dashboard/bendahara', [TransaksiController::class, 'dashboardBendahara'])->name('dashboard.bendahara')->middleware(['auth']);

Route::get('/dashboard/walikelas', function () {
    $totalPemasukan = class_exists('\App\Models\Transaksi') ? \App\Models\Transaksi::where('jenis', 'pemasukan')->sum('jumlah') : 0;
    $totalPengeluaran = class_exists('\App\Models\Transaksi') ? \App\Models\Transaksi::where('jenis', 'pengeluaran')->sum('jumlah') : 0;
    $totalSaldo = $totalPemasukan - $totalPengeluaran; // Diperbaiki dari baris terpotong sebelumnya
    $totalSiswa = class_exists('\App\Models\Siswa') ? \App\Models\Siswa::count() : 0;

    return view('dashboard.walikelas', compact('totalSaldo', 'totalPemasukan', 'totalPengeluaran', 'totalSiswa'));
})->name('dashboard.walikelas')->middleware(['auth']);

Route::get('/dashboard/siswa', function () {
    // 1. Total kas keseluruhan kelas
    $totalPemasukan = \App\Models\Transaksi::where('jenis', 'pemasukan')->sum('jumlah');
    $totalPengeluaran = \App\Models\Transaksi::where('jenis', 'pengeluaran')->sum('jumlah');
    $totalKasKelas = $totalPemasukan - $totalPengeluaran; // Diperbaiki dari baris terpotong sebelumnya

    // 2. Total setoran khusus siswa yang sedang login (mencocokkan nis / relasi / nama)
    $siswaLogin = Auth::user();
    $siswaRecord = \App\Models\Siswa::where('nama', 'LIKE', '%' . $siswaLogin->name . '%')->first();
    
    $totalSetoranKamu = $siswaRecord 
        ? \App\Models\Transaksi::where('siswa_id', $siswaRecord->id)->where('jenis', 'pemasukan')->sum('jumlah')
        : \App\Models\Transaksi::where('nama_iuran', 'LIKE', '%' . $siswaLogin->name . '%')->where('jenis', 'pemasukan')->sum('jumlah');

    $riwayatSetoran = $siswaRecord 
        ? \App\Models\Transaksi::where('siswa_id', $siswaRecord->id)->latest()->get() 
        : collect();

    return view('dashboard.siswa', compact('totalKasKelas', 'totalSetoranKamu', 'riwayatSetoran'));
})->name('dashboard.siswa')->middleware(['auth']);

Route::get('/dashboard/user', function () {
    $totalPemasukan = class_exists('\App\Models\Transaksi') ? \App\Models\Transaksi::where('jenis', 'pemasukan')->sum('jumlah') : 0;
    $totalPengeluaran = class_exists('\App\Models\Transaksi') ? \App\Models\Transaksi::where('jenis', 'pengeluaran')->sum('jumlah') : 0;
    $totalSaldo = $totalPemasukan - $totalPengeluaran; // Diperbaiki dari baris terpotong sebelumnya
    $totalSiswa = class_exists('\App\Models\Siswa') ? \App\Models\Siswa::count() : 0;

    return view('dashboard.user', compact('totalSaldo', 'totalSiswa', 'totalPemasukan', 'totalPengeluaran'));
})->name('dashboard.user')->middleware(['auth']);

// Route Kelola Master Data & Transaksi (Dilindungi Auth)
Route::middleware(['auth'])->group(function () {
    
    // Transaksi / Iuran Kas
    Route::get('/dashboard/kelola_iuran', [TransaksiController::class, 'index'])->name('kelola.iuran');
    Route::post('/dashboard/kelola_iuran/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::put('/dashboard/kelola_iuran/update/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/dashboard/kelola_iuran/delete/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    
    // ==========================================
    // TAMBAHAN RUTE LAPORAN KEUANGAN
    // ==========================================
    Route::get('/dashboard/laporan-keuangan', [TransaksiController::class, 'laporanKeuangan'])->name('laporan.keuangan');

    // Kelola Data Siswa
    Route::get('/dashboard/kelola_siswa', [SiswaController::class, 'index'])->name('kelola.siswa');
    Route::post('/dashboard/kelola_siswa/store', [SiswaController::class, 'store'])->name('kelola.siswa.store');
    Route::put('/dashboard/kelola_siswa/update/{id}', [SiswaController::class, 'update'])->name('kelola.siswa.update');
    Route::delete('/dashboard/kelola_siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('kelola.siswa.destroy');

    // Kelola User Lainnya
    Route::get('/dashboard/kelola_user', function () { 
        $users = \App\Models\User::all();
        return view('dashboard.kelola_user', compact('users')); 
    })->name('kelola.user');

    Route::post('/dashboard/kelola-user/store', function (\Illuminate\Http\Request $request) {
        \App\Models\User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role ?? 'user',
        ]);
        return back()->with('success', 'User berhasil ditambahkan!');
    })->name('kelola.user.store');

    Route::delete('/dashboard/kelola_user/delete/{id}', function ($id) {
        \App\Models\User::findOrFail($id)->delete();
        return back()->with('success', 'User berhasil dihapus!');
    })->name('kelola.user.destroy');

    // ==========================================
    // RUTE KELOLA WALI KELAS (DUAL NAMING)
    // ==========================================
    Route::get('/dashboard/kelola_walikelas', [walikelascontroller::class, 'index'])->name('dashboard.kelola_walikelas');
    
    // Rute Store (Mendukung titik & underscore)
    Route::post('/dashboard/kelola_walikelas/store', [walikelascontroller::class, 'store'])->name('kelola.walikelas.store');
    Route::post('/dashboard/kelola_walikelas/store-alt', [walikelascontroller::class, 'store'])->name('kelola_walikelas.store');

    // Rute Destroy (Mendukung titik & underscore)
    Route::delete('/dashboard/kelola_walikelas/delete/{id}', [walikelascontroller::class, 'destroy'])->name('kelola.walikelas.destroy');
    Route::delete('/dashboard/kelola_walikelas/delete-alt/{id}', [walikelascontroller::class, 'destroy'])->name('kelola_walikelas.destroy');

});