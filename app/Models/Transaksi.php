<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Menentukan tabel di database menggunakan nama tanpa 's'
    protected $table = 'transaksi';
protected $fillable = ['siswa_id', 'nama_iuran', 'jenis', 'jumlah', 'periode'];

    // Relasi ke Model Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}