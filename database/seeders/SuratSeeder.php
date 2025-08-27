<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Surat; // Pastikan model Surat di-import
use App\Models\Divisi; // Import model Divisi untuk mengambil ID
use Illuminate\Support\Facades\DB; // Jika perlu

class SuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama untuk menghindari duplikasi jika seeder dijalankan ulang
        // Surat::truncate(); // Opsional, gunakan jika Anda ingin tabel bersih setiap kali seeding

        // Ambil semua ID dari tabel divisi.
        // Ini memastikan seeder tidak akan gagal jika ID divisi berubah.
        $divisiIds = Divisi::pluck('id')->toArray();

        // Jika tidak ada divisi, hentikan seeder dan beri pesan.
        if (empty($divisiIds)) {
            $this->command->info('Tidak ada data di tabel Divisi. Silakan jalankan DivisiSeeder terlebih dahulu.');
            return;
        }

        $surats = [];
        $jenisSuratOptions = ['Surat Masuk', 'Surat Keluar'];
        $sifatOptions = ['Sangat Rahasia', 'Rahasia', 'Penting', 'Biasa'];

        for ($i = 1; $i <= 20; $i++) {
            $tanggalSurat = now()->subDays(rand(1, 365));
            $jenisSurat = $jenisSuratOptions[array_rand($jenisSuratOptions)];

            $surats[] = [
                'nomor_surat' => 'SRT/' . date('Y') . '/' . date('m') . '/' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'tanggal_surat' => $tanggalSurat,
                'tanggal_diterima' => $tanggalSurat->copy()->addDays(rand(1, 5)),
                'jenis_surat' => $jenisSurat,
                'pengirim' => ($jenisSurat == 'Surat Masuk') ? 'PT. Klien Eksternal ' . $i : 'Internal Perusahaan',
                'penerima' => ($jenisSurat == 'Surat Keluar') ? 'PT. Mitra Bisnis ' . $i : 'Internal Perusahaan',
                'perihal' => 'Perihal Dokumen Penting Nomor ' . $i,
                'sifat' => $sifatOptions[array_rand($sifatOptions)],
                'file_path' => 'public/files/dummy_surat_' . $i . '.pdf',
                'divisi_id' => $divisiIds[array_rand($divisiIds)], // Pilih ID divisi secara acak
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Masukkan semua data sekaligus untuk performa yang lebih baik
        Surat::insert($surats);
    }
}
