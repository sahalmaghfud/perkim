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
        Schema::table('rumah_tidak_layak_huni', function (Blueprint $table) {
            // 1. Menghapus kolom yang tidak diperlukan lagi
            $table->dropColumn(['kepemilikan_rumah', 'status', 'kategori_rumah']);

            // 2. Menambahkan kolom-kolom baru
            $table->string('kondisi_lantai')->nullable()->after('kepemilikan_tanah');
            $table->string('kondisi_dinding')->nullable()->after('kondisi_lantai');
            $table->string('sumber_air')->nullable()->after('kondisi_dinding');
            $table->string('sanitasi_wc')->nullable()->after('sumber_air');
            $table->string('dapur')->nullable()->after('sanitasi_wc');
            $table->string('no_sertifikat')->nullable()->after('dapur');

            // 3. Mengubah kolom yang sudah ada menjadi nullable
            $table->string('nik')->nullable()->change();
            $table->integer('umur')->nullable()->change();
            $table->text('alamat')->nullable()->change();
            $table->decimal('luas_rumah', 8, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rumah_tidak_layak_huni', function (Blueprint $table) {
            // 1. Mengembalikan kolom menjadi not nullable
            // Perhatian: Ini akan gagal jika ada data NULL di kolom tersebut.
            $table->string('nik')->unique()->nullable(false)->change();
            $table->integer('umur')->nullable(false)->change();
            $table->text('alamat')->nullable(false)->change();
            $table->decimal('luas_rumah', 8, 2)->nullable(false)->change();

            // 2. Menghapus kolom yang baru ditambahkan
            $table->dropColumn(['kondisi_lantai', 'kondisi_dinding', 'sumber_air', 'sanitasi_wc', 'dapur', 'no_sertifikat']);

            // 3. Mengembalikan kolom yang dihapus
            $table->string('kepemilikan_rumah')->after('kepemilikan_tanah');
            $table->string('status')->default('belum diperbaiki')->after('koordinat');
            $table->string('kategori_rumah')->after('jenis_kelamin');
        });
    }
};
