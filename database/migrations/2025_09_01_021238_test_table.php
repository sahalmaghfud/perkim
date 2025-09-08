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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('nama_lengkap');

            // Menambahkan foreign key ke tabel divisis
            $table->foreignId('bidang_id')
                ->constrained('bidang') // merujuk ke tabel 'divisis'
                ->onUpdate('cascade') // jika id di tabel divisis berubah, di sini juga berubah
                ->onDelete('restrict'); // tidak bisa hapus divisi jika masih ada pegawai

            $table->string('jabatan'); // jabatan seperti 'Staff' atau 'Ketua'
            $table->string('email')->unique();
            $table->string('nomor_telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->date('tanggal_masuk');
            $table->enum('status', ['aktif', 'permanen', 'kontrak', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
