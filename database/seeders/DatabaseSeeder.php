<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

use App\Models\Divisi;
use App\Models\Dokumen;
use App\Models\Surat;
use App\Models\User;
use App\Models\Pegawai;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =================================================================
        // BAGIAN 1: SEEDING DATA DIVISI
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

        $divisis = Divisi::all()->keyBy('slug');
        $divisiIds = Divisi::pluck('id')->toArray();

        // =================================================================
        // BAGIAN 2: SEEDING DATA USERS
        // =================================================================
        $this->command->info('Membuat data Users...');

        $usersData = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'divisi_slug' => 'tu',
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
                    'divisi_id' => $divisis[$user['divisi_slug']]->id,
                ]
            );
        }

        // =================================================================
        // BAGIAN 3: SEEDING DATA SURAT (DUMMY)
        // =================================================================
        $this->command->info('Membuat data Surat (dummy)...');

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
                'file_path' => 'surat-files/form.pdf',
                'divisi_id' => $divisiIds[array_rand($divisiIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Surat::truncate();
        Surat::insert($surats);

        // =================================================================
        // BAGIAN 4: SEEDING DATA DOKUMEN (DUMMY)
        // =================================================================
        $this->command->info('Membuat data Dokumen (dummy)...');

        $dokumens = [];
        $kategoriOptions = ['Keuangan', 'HRD', 'Teknis', 'Umum', 'Pemasaran'];
        $tipeDokumenOptions = ['SOP', 'Laporan Bulanan', 'Kontrak', 'Memo Internal', 'Presentasi'];

        for ($i = 1; $i <= 25; $i++) {
            $tanggalTerbit = now()->subDays(rand(1, 730));
            $kategori = $kategoriOptions[array_rand($kategoriOptions)];

            $dokumens[] = [
                'kode_dokumen' => 'DOC-' . $tanggalTerbit->format('Y') . '-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'judul' => 'Judul Dokumen ' . Str::title(str_replace('_', ' ', $kategori)) . ' ' . $i,
                'kategori' => $kategori,
                'tipe_dokumen' => $tipeDokumenOptions[array_rand($tipeDokumenOptions)],
                'deskripsi' => 'Ini adalah deskripsi untuk dokumen ' . $i . '. Dokumen ini berisi informasi penting terkait kategori ' . $kategori . '.',
                'tanggal_terbit' => $tanggalTerbit,
                'file_path' => 'dokumen-files/form.pdf',
                'divisi_id' => $divisiIds[array_rand($divisiIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Dokumen::truncate();
        Dokumen::insert($dokumens);

        // =================================================================
        // BAGIAN 5: SEEDING DATA PEGAWAI (DUMMY)
        // =================================================================
        $this->command->info('Membuat data Pegawai (dummy)...');

        if (empty($divisiIds)) {
            $this->command->info('Tidak ada data di tabel divisis. Silakan jalankan DivisiSeeder terlebih dahulu.');
            return;
        }

        Pegawai::truncate();

        $faker = Faker::create('id_ID');
        $jabatan = ['Staff', 'Ketua'];
        $statusOptions = ['aktif', 'permanen', 'kontrak'];

        foreach (range(1, 20) as $index) {
            Pegawai::create([
                'nip' => $faker->unique()->numerify('199#######' . $index),
                'nama_lengkap' => $faker->name(),
                'divisi_id' => $faker->randomElement($divisiIds),
                'jabatan' => $faker->randomElement($jabatan),
                'email' => $faker->unique()->safeEmail(),
                'nomor_telepon' => $faker->phoneNumber(),
                'alamat' => $faker->address(),
                'tanggal_lahir' => $faker->dateTimeBetween('-30 years', '-20 years')->format('Y-m-d'),
                'tanggal_masuk' => $faker->dateTimeBetween('-5 years', 'now'),
                'status' => $faker->randomElement($statusOptions),
            ]);
        }

        // =================================================================
        // SELESAI
        // =================================================================
        $this->command->info('Database seeding selesai!');
    }
}
