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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->date('tanggal_surat');
            $table->date('tanggal_diterima')->nullable();
            ;
            $table->enum('jenis_surat', ['Surat Masuk', 'Surat Keluar']);
            $table->string('pengirim')->nullable();
            $table->string('penerima')->nullable();
            ;
            $table->string('perihal');
            $table->enum('sifat', ['Sangat Rahasia', 'Rahasia', 'Penting', 'Biasa']);
            $table->string('file_path');
            $table->timestamps();
            $table->foreignId('divisi_id')->constrained('divisis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
