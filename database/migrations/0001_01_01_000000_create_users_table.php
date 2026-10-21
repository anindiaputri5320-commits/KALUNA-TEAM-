<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // Kolom umum / identitas
            $table->string('name'); // Digunakan untuk nama user/bendahara/siswa/walikelas
            $table->string('username')->unique()->nullable(); // Untuk role User
            $table->string('nip')->unique()->nullable();      // Khusus Wali Kelas
            $table->string('nipd')->unique()->nullable();     // Khusus Siswa
            $table->string('kelas')->nullable();              // Khusus Siswa
            $table->string('password');                       // Password (untuk User, Wali Kelas, Bendahara)
            $table->enum('role', ['user', 'bendahara', 'siswa', 'walikelas']); // Pembeda hak akses
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

    /**
     * Reverse the migrations.
     */
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }

