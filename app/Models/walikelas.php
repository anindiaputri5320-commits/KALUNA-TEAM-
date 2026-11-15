<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class walikelas extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database phpMyAdmin/XAMPP
    protected $table = 'walikelas';

    // Kolom yang dapat diisi
    protected $fillable = [
        'nama',
        'nip',
        'kelas',
        'nomor_telepon'
    ];
}