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
        Schema::table('jalan_lingkungan', function (Blueprint $table) {
            // Menambahkan kolom baru setelah kolom 'uraian'
            $table->string('kecamatan')->nullable()->after('uraian');
            $table->string('desa')->nullable()->after('kecamatan');
            $table->text('alamat')->nullable()->after('desa');
            $table->string('foto_sebelum')->nullable()->comment('Path file foto sebelum pengerjaan')->after('keterangan');
            $table->string('foto_sesudah')->nullable()->comment('Path file foto sesudah pengerjaan')->after('foto_sebelum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jalan_lingkungan', function (Blueprint $table) {
            // Menghapus kolom jika migrasi di-rollback
            $table->dropColumn([
                'kecamatan',
                'desa',
                'alamat',
                'foto_sebelum',
                'foto_sesudah'
            ]);
        });
    }
};
