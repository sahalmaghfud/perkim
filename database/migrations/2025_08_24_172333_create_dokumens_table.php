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
            $table->string('judul');
            $table->string('kategori');
            $table->enum('tipe_dokumen', ['dokumen', 'surat']);
            $table->foreignId('bidang_id')->constrained('bidang')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('file_path');
            $table->text('deskripsi')->nullable();

            $table->string('nomor_surat')->nullable();
            $table->string('pengirim')->nullable();   // pengirim surat
            $table->string('penerima')->nullable();   // penerima surat
            $table->string('perihal')->nullable();    // isi pokok surat
            $table->integer('lampiran')->nullable();  // jumlah lampiran, jika ada
            $table->date('tanggal_surat')->nullable(); // tanggal surat dibuat/diterima
            $table->timestamps();
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
