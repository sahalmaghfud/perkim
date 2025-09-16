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

        Schema::create('pangkat', function (Blueprint $table) {
            $table->id();
            $table->string('pangkat');
            $table->string('golongan');
            $table->string('ruang');
        });

        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();


            $table->foreignId('bidang_id')
                ->constrained('bidang')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreignId('pangkat_id')
                ->constrained('pangkat')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->string('nama', 255);
            $table->string('nip', 25)->unique();
            $table->string('foto', )->nullable();
            $table->date('tmt_cpns');
            $table->date('tmt_pangkat');

            $table->string('nama_jabatan', 255)->nullable();
            $table->string('eselon', 5)->nullable();
            $table->date('tmt_jabatan')->nullable();


            $table->string('nama_diklat')->nullable();
            $table->year('tahun_diklat')->nullable();
            $table->integer('jumlah_jam_diklat')->nullable();

            $table->string('pendidikan_terakhir', 100);
            $table->string('jurusan', 150);
            $table->year('tahun_lulus');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 255)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('catatan_mutasi')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });


        Schema::create('dokumen_pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->onDelete('cascade');
            $table->string('jenis_dokumen');
            $table->string('judul');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pegawai');
        Schema::dropIfExists('pegawai');
        Schema::dropIfExists('pangkat');

    }
};
