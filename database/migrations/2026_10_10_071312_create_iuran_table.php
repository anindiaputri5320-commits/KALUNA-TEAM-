<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('iuran', function (Blueprint $table) {
        $table->id();
        $table->string('nama_iuran'); // Kolom nama iuran
        $table->decimal('nominal', 10, 2); // Kolom nominal uang
        $table->string('periode'); // Kolom periode (contoh: Oktober 2026)
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iuran');
    }
};
