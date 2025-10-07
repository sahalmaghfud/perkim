<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rumah_tidak_layak_huni', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kepala_ruta');
            $table->string('nik')->unique();
            $table->integer('umur');
            $table->string('kode_wilayah');
            $table->string('kecamatan');
            $table->string('desa_kelurahan');
            $table->text('alamat');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('kategori_rumah');
            $table->decimal('luas_rumah', );
            $table->string('kepemilikan_rumah');
            $table->string('kepemilikan_tanah');
            $table->string('foto_sebelum_perbaikan')->nullable();
            $table->string('koordinat')->nullable();
            $table->string('status')->default('belum diperbaiki');

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
        Schema::dropIfExists('rumah_tidak_layak_huni');
    }
};
