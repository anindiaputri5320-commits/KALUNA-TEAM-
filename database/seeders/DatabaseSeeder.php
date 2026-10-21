<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Kelas
        $kelas = [
            ['nama_kelas' => 'XII RPL 1', 'tahun_ajaran' => '2025/2026'],
            ['nama_kelas' => 'XII RPL 2', 'tahun_ajaran' => '2025/2026'],
            ['nama_kelas' => 'XII RPL 3', 'tahun_ajaran' => '2025/2026'],
            ['nama_kelas' => 'XII RPL 4', 'tahun_ajaran' => '2025/2026'],
        ];

        foreach ($kelas as $k) {
            Kelas::firstOrCreate(['nama_kelas' => $k['nama_kelas']], $k);
        }

        // 2. Akun User Biasa / Umum
        User::updateOrCreate(
            ['username' => 'user'],
            [
                'name' => 'User KALUNA',
                'password' => Hash::make('12345678'),
                'role' => 'user'
            ]
        );

        // 3. Akun Bendahara
        User::updateOrCreate(
            ['username' => 'bendahara'],
            [
                'name' => 'Bendahara KALUNA',
                'password' => Hash::make('12345678'),
                'role' => 'bendahara'
            ]
        );

        // 4. Akun Wali Kelas
        User::updateOrCreate(
            ['username' => 'walikelas'],
            [
                'name' => 'Wali Kelas XII RPL',
                'password' => Hash::make('12345678'),
                'role' => 'walikelas'
            ]
        );

        // 5. Akun Siswa
        User::updateOrCreate(
            ['username' => 'siswa'],
            [
                'name' => 'Siswa KALUNA',
                'password' => Hash::make('12345678'),
                'role' => 'siswa'
            ]
        );
    }
}