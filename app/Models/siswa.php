<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa'; // 👈 Tambahkan baris ini agar sesuai dengan nama tabel di database XAMPP kamu!
    
    protected $fillable = ['nis', 'nama', 'kelas', 'status']; // Sesuaikan dengan kolom tabelmu
}