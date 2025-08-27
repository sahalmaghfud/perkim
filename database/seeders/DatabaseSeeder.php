<?php

namespace Database\Seeders;

// Pastikan semua model dan class yang dibutuhkan di-import di sini
use App\Models\Divisi;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =================================================================
        // BAGIAN 1: SEEDING DATA DIVISI
        // Kita buat data divisi terlebih dahulu karena data lain bergantung padanya.
        // =================================================================
        $this->command->info('Membuat data Divisi...');

        $divisiData = [
            ['nama_divisi' => 'perumahan'],
            ['nama_divisi' => 'permukiman'],
            ['nama_divisi' => 'psu'], // Prasarana, Sarana, dan Utilitas Umum
            ['nama_divisi' => 'tu'],  // Tata Usaha
        ];

        foreach ($divisiData as $data) {
            Divisi::updateOrCreate(
                ['nama_divisi' => $data['nama_divisi']],
                ['slug' => Str::slug($data['nama_divisi'])]
            );
        }

        // =================================================================
        // BAGIAN 2: SEEDING DATA USERS
        // Ambil data divisi yang baru saja dibuat untuk mengisi foreign key 'divisi_id'.
        // =================================================================
        $this->command->info('Membuat data Users...');

        // Ambil semua divisi dan jadikan slug sebagai key agar mudah dicari
        $divisis = Divisi::all()->keyBy('slug');

        $usersData = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'divisi_slug' => 'tu', // Admin ditempatkan di divisi Tata Usaha
            ],
            [
                'name' => 'User Perumahan',
                'email' => 'perumahan@example.com',
                'password' => Hash::make('perumahan123'),
                'role' => 'user',
                'divisi_slug' => 'perumahan',
            ],
            [
                'name' => 'User Permukiman',
                'email' => 'permukiman@example.com',
                'password' => Hash::make('permukiman123'),
                'role' => 'user',
                'divisi_slug' => 'permukiman',
            ],
            [
                'name' => 'User PSU',
                'email' => 'psu@example.com',
                'password' => Hash::make('psu123'),
                'role' => 'user',
                'divisi_slug' => 'psu',
            ],
        ];

        foreach ($usersData as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'role' => $user['role'],
                    'divisi_id' => $divisis[$user['divisi_slug']]->id, // Ambil ID divisi berdasarkan slug
                ]
            );
        }

        // =================================================================
        // BAGIAN 3: SEEDING DATA SURAT (DUMMY)
        // =================================================================
        $this->command->info('Membuat data Surat (dummy)...');

        $divisiIds = Divisi::pluck('id')->toArray();

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

        // Hapus data surat lama agar tidak menumpuk jika seeder dijalankan ulang
        Surat::truncate();
        // Masukkan semua data sekaligus untuk performa yang lebih baik
        Surat::insert($surats);

        $this->command->info('Database seeding selesai!');
    }
}
