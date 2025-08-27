<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_dokumens_table.php
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('kode_dokumen')->unique()->nullable();
            $table->string('judul');
            $table->string('kategori'); // Contoh: Keuangan, HRD, Teknis
            $table->string('tipe_dokumen'); // Contoh: SOP, Laporan Bulanan, Kontrak
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_terbit');
            $table->string('file_path'); // Path ke file dokumen
            $table->timestamps();
            $table->foreignId('divisi_id')->constrained('divisis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};
