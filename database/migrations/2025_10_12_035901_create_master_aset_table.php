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
        Schema::create('master_aset', function (Blueprint $table) {
            // Kolom Umum
            $table->id();
            $table->string('jenis_kib')->comment('A, B, C, D, F, G, H');
            $table->string('kode_barang')->nullable();
            $table->string('nama_barang')->nullable();
            $table->text('spesifikasi_barang')->nullable();
            $table->decimal('nilai_perolehan_rp', 20, 2)->nullable();
            $table->year('tahun_perolehan')->nullable();
            $table->text('keterangan')->nullable();

            // Kolom Spesifik (dibuat nullable)
            $table->string('nomor_induk_barang')->nullable(); // KIB A, F
            $table->string('nomor_register')->nullable(); // KIB A, F
            $table->text('spesifikasi_lainnya')->nullable(); // KIB A, F
            $table->decimal('luas', 15, 2)->nullable(); // KIB A
            $table->string('satuan')->nullable(); // KIB A, F
            $table->text('lokasi_alamat')->nullable(); // KIB A, F
            $table->string('hak')->nullable(); // KIB A
            $table->string('nomor_sertifikat')->nullable(); // KIB A
            $table->date('tanggal_sertifikat')->nullable(); // KIB A
            $table->string('nama_kepemilikan')->nullable(); // KIB A
            $table->string('cara_perolehan')->nullable(); // KIB A, F
            $table->string('status_pengguna')->nullable(); // KIB A, F
            $table->integer('umur_ekonomis_tahun')->nullable(); // KIB C, D
            $table->decimal('akumulasi_penyusutan_awal', 20, 2)->nullable(); // KIB B, C, D
            $table->decimal('beban_penyusutan_tahunan', 20, 2)->nullable(); // KIB B, C, D
            $table->decimal('akumulasi_penyusutan_akhir', 20, 2)->nullable(); // KIB B, C, D
            $table->decimal('nilai_buku', 20, 2)->nullable(); // KIB B, C, D, G, H

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_aset');
    }
};
