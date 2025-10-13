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
            // Mengganti nama kolom
            $table->renameColumn('foto_sebelum_perbaikan', 'foto_rumah');

            // Menambahkan kolom kondisi atap dan kolom foto-foto baru
            $table->string('kondisi_atap')->nullable()->after('kondisi_dinding');
            $table->string('foto_kondisi_lantai')->nullable()->after('foto_rumah');
            $table->string('foto_kondisi_dinding')->nullable()->after('foto_kondisi_lantai');
            $table->string('foto_kondisi_atap')->nullable()->after('foto_kondisi_dinding');
            $table->string('foto_sanitasi_wc')->nullable()->after('foto_kondisi_atap');
            $table->string('foto_kondisi_dapur')->nullable()->after('foto_sanitasi_wc');
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
            // Mengembalikan nama kolom
            $table->renameColumn('foto_rumah', 'foto_sebelum_perbaikan');

            // Menghapus kolom yang ditambahkan
            $table->dropColumn([
                'kondisi_atap',
                'foto_kondisi_lantai',
                'foto_kondisi_dinding',
                'foto_kondisi_atap',
                'foto_sanitasi_wc',
                'foto_kondisi_dapur',
            ]);
        });
    }
};
