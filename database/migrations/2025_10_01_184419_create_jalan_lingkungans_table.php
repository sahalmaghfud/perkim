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
        Schema::create('jalan_lingkungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_id')->constrained('cv')->onDelete('cascade');

            // --- Data Utama Proyek ---
            $table->text('uraian');
            // ... (semua kolom lainnya tetap sama) ...
            $table->decimal('volume', 15, 2)->nullable();
            $table->string('satuan')->nullable();
            $table->decimal('harga_satuan', 19, 2)->nullable();
            $table->decimal('jumlah_harga', 19, 2)->nullable();
            $table->string('nomor_kontrak')->nullable();
            $table->date('tanggal_kontrak')->nullable();
            $table->date('tanggal_awal_pekerjaan')->nullable();
            $table->date('tanggal_akhir_pekerjaan')->nullable();
            $table->decimal('nilai_kontrak', 19, 2)->nullable();

            // --- Realisasi Pencairan 30% ---
            $table->string('no_spm_30')->nullable();
            $table->string('no_sp2d_30')->nullable();
            $table->date('tanggal_30')->nullable();
            $table->decimal('nilai_30', 19, 2)->nullable();
            $table->decimal('ppn_30', 19, 2)->nullable();
            $table->decimal('pph_30', 19, 2)->nullable();
            $table->decimal('total_30', 19, 2)->nullable();

            // --- Realisasi Pencairan 95% ---
            $table->string('no_spm_95')->nullable();
            // ... (semua kolom pencairan 95% dan 100% tetap sama) ...
            $table->string('no_sp2d_95')->nullable();
            $table->date('tanggal_95')->nullable();
            $table->decimal('nilai_95', 19, 2)->nullable();
            $table->decimal('ppn_95', 19, 2)->nullable();
            $table->decimal('pph_95', 19, 2)->nullable();
            $table->decimal('total_95', 19, 2)->nullable();

            $table->string('no_spm_100')->nullable();
            $table->string('no_sp2d_100')->nullable();
            $table->date('tanggal_100')->nullable();
            $table->decimal('nilai_100', 19, 2)->nullable();
            $table->decimal('ppn_100', 19, 2)->nullable();
            $table->decimal('pph_100', 19, 2)->nullable();
            $table->decimal('total_100', 19, 2)->nullable();

            // --- Data BAPHP & BAST ---
            $table->string('baphp_nomor')->nullable();
            $table->date('baphp_tanggal')->nullable();
            $table->string('bast_nomor')->nullable();
            $table->date('bast_tanggal')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jalan_lingkungan');
    }
};
