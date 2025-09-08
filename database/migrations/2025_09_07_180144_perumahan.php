<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siteplans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tipe');
            $table->string('luas_lahan_per_unit')->nullable();
            $table->decimal('luas_lahan_perumahan', 15, 2)->nullable();
            $table->decimal('luas_psu', 15, 2)->nullable();
            $table->decimal('panjang_prasarana_jalan', 15, 2)->nullable();
            $table->decimal('lebar_prasarana_jalan', 15, 2)->nullable();
            $table->decimal('luas_prasarana_jalan', 15, 2)->nullable();
            $table->decimal('luas_prasarana_drainase', 15, 2)->nullable();
            $table->decimal('luas_prasarana_rth', 15, 2)->nullable();
            $table->decimal('luas_prasarana_tps', 15, 2)->nullable();
            $table->decimal('luas_sarana_pemakaman', 15, 2)->nullable();
            $table->decimal('luas_sarana_olahraga_dll', 15, 2)->nullable();
            $table->string('panjang_utilitas')->nullable();
            $table->string('sumber_air_bersih')->nullable();
            $table->string('jenis')->nullable();
            $table->string('nama_pt');
            $table->integer('jumlah_unit_rumah')->nullable();
            $table->year('tahun')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('desa')->nullable();
            $table->string('nomor_site_plan')->unique()->nullable();
            $table->date('tanggal_site_plan')->nullable();
            $table->string('nomor_bast_adm')->nullable();
            $table->date('tanggal_bast_adm')->nullable();
            $table->string('nomor_bast_fisik')->nullable();
            $table->date('tanggal_bast_fisik')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siteplans');
    }
};
