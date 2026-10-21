<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MasterDataController;

// Redirect Halaman Utama ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Dashboard Sesuai Role
Route::get('/dashboard/bendahara', function () {
    return view('dashboard.bendahara'); // Atau view dashboard kalian
})->name('dashboard.bendahara');

Route::get('/dashboard/user', function () {
    return view('dashboard.user');
})->name('dashboard.user');

Route::get('/dashboard/walikelas', function () {
    return view('dashboard.walikelas');
})->name('dashboard.walikelas');

Route::get('/dashboard/siswa', function () {
    return view('dashboard.siswa');
})->name('dashboard.siswa');

// Route Kelola Siswa (Master Data)
Route::get('/dashboard/kelola-siswa', [MasterDataController::class, 'indexSiswa'])->name('kelola.siswa');
Route::post('/dashboard/kelola-siswa', [MasterDataController::class, 'storeSiswa'])->name('kelola.siswa.store');
Route::put('/dashboard/kelola-siswa/{id}', [MasterDataController::class, 'updateSiswa'])->name('kelola.siswa.update');
Route::delete('/dashboard/kelola-siswa/{id}', [MasterDataController::class, 'destroySiswa'])->name('kelola.siswa.destroy');

// Route Kelola Iuran
Route::get('/dashboard/kelola-iuran', [MasterDataController::class, 'indexIuran'])->name('kelola.iuran');
Route::post('/dashboard/kelola-iuran', [MasterDataController::class, 'storeIuran'])->name('kelola.iuran.store');
Route::delete('/dashboard/kelola-iuran/{id}', [MasterDataController::class, 'destroyIuran'])->name('kelola.iuran.destroy');

// Route Kelola Wali Kelas
Route::get('/dashboard/kelola-walikelas', [MasterDataController::class, 'indexWaliKelas'])->name('kelola.walikelas');
Route::post('/dashboard/kelola-walikelas', [MasterDataController::class, 'storeWaliKelas'])->name('kelola.walikelas.store');
Route::delete('/dashboard/kelola-walikelas/{id}', [MasterDataController::class, 'destroyWaliKelas'])->name('kelola.walikelas.destroy');

// Route Kelola User
Route::get('/dashboard/kelola-user', [MasterDataController::class, 'indexUser'])->name('kelola.user');
Route::post('/dashboard/kelola-user', [MasterDataController::class, 'storeUser'])->name('kelola.user.store');
Route::delete('/dashboard/kelola-user/{id}', [MasterDataController::class, 'destroyUser'])->name('kelola.user.destroy');