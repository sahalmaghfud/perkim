<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cv', function (Blueprint $table) {
            $table->id();
            $table->string('nama_cv'); // Untuk menyimpan NAMA CV
            $table->string('npwp')->unique()->nullable(); // Untuk menyimpan NPWP
            $table->string('nomor_rekening')->nullable(); // Untuk menyimpan REK. BANK JAMBI
            $table->string('nama_direktur')->nullable(); // Untuk menyimpan NAMA DIREKTUR
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv');
    }
};
