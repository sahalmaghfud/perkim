<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

use App\Models\bidang;
use App\Models\Dokumen;
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
        // BAGIAN 1: SEEDING DATA bidang
        // =================================================================
        $this->command->info('Membuat data bidang...');

        $bidangData = [
            ['nama_bidang' => 'perumahan'],
            ['nama_bidang' => 'permukiman'],
            ['nama_bidang' => 'psu'], // Prasarana, Sarana, dan Utilitas Umum
            ['nama_bidang' => 'tu'],  // Tata Usaha
        ];

        foreach ($bidangData as $data) {
            bidang::updateOrCreate(
                ['nama_bidang' => $data['nama_bidang']],
                ['slug' => Str::slug($data['nama_bidang'])]
            );
        }

        $bidangs = bidang::all()->keyBy('slug');
        $bidangIds = bidang::pluck('id')->toArray();

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
                'bidang_slug' => 'tu',
            ],
            [
                'name' => 'User Perumahan',
                'email' => 'perumahan@example.com',
                'password' => Hash::make('perumahan123'),
                'role' => 'user',
                'bidang_slug' => 'perumahan',
            ],
            [
                'name' => 'User Permukiman',
                'email' => 'permukiman@example.com',
                'password' => Hash::make('permukiman123'),
                'role' => 'user',
                'bidang_slug' => 'permukiman',
            ],
            [
                'name' => 'User PSU',
                'email' => 'psu@example.com',
                'password' => Hash::make('psu123'),
                'role' => 'user',
                'bidang_slug' => 'psu',
            ],
        ];

        foreach ($usersData as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $user['password'],
                    'role' => $user['role'],
                    'bidang_id' => $bidangs[$user['bidang_slug']]->id,
                ]
            );
        }



        // =================================================================
        // BAGIAN 3: SEEDING DATA DOKUMEN (DUMMY)
        // =================================================================
        $dokumens = [];
        $kategoriOptions = ['Keuangan', 'HRD', 'Teknis', 'Umum', 'Pemasaran'];
        $tipeDokumenOptions = ['dokumen', 'surat'];
        $pengirimOptions = [
            'PT. Karya Anak Bangsa',
            'PT. Sinar Jaya Abadi',
            'CV. Mitra Konstruksi',
            'Dinas Pekerjaan Umum dan Perumahan Rakyat',
            'Badan Perencanaan Pembangunan Daerah',
            'Dinas Perumahan Dan Kawasan Permukiman Muaro Jambi'
        ];
        $penerimaOptions = [
            'PT. Sejahtera Bersama',
            'Kantor Bupati Muaro Jambi',
            'Dinas Lingkungan Hidup',
            'PT. Adhi Karya (Persero) Tbk',
            'Divisi Internal',
            'Dinas Perumahan Dan Kawasan Permukiman Muaro Jambi'
        ];

        for ($i = 1; $i <= 25; $i++) {
            // [PENYESUAIAN] Mengubah nama variabel agar sesuai dengan nama kolom
            $tanggal = now()->subDays(rand(1, 730));
            $kategori = $kategoriOptions[array_rand($kategoriOptions)];
            $tipeDokumen = $tipeDokumenOptions[array_rand($tipeDokumenOptions)];

            // Data dasar untuk semua tipe
            $dokumenData = [
                // 'kode_dokumen' dihapus
                'judul' => 'Judul ' . Str::title($tipeDokumen) . ' ' . Str::title($kategori) . ' ' . $i,
                'kategori' => $kategori,
                'tipe_dokumen' => $tipeDokumen,
                'deskripsi' => 'Ini adalah deskripsi untuk ' . $tipeDokumen . ' ' . $i . '. Dokumen ini berisi informasi terkait kategori ' . $kategori . '.',
                'tanggal' => $tanggal, // Nama field diubah
                'file_path' => 'dokumen-files/dummy-document.pdf',
                'bidang_id' => $bidangIds[array_rand($bidangIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            if ($tipeDokumen === 'surat') {
                $tanggalSurat = $tanggal->copy()->subDays(rand(1, 5));
                $dokumenData = array_merge($dokumenData, [
                    'nomor_surat' => 'SRT/' . $tanggalSurat->format('Y/m') . '/' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'pengirim' => $pengirimOptions[array_rand($pengirimOptions)],
                    'penerima' => $penerimaOptions[array_rand($penerimaOptions)],
                    'perihal' => 'Perihal Mengenai ' . $kategori . ' untuk Dokumen ' . $i,
                    'lampiran' => rand(0, 3),
                    'tanggal_surat' => $tanggalSurat,
                ]);
            } else {
                // Pastikan field surat bernilai null jika tipenya 'dokumen'
                $dokumenData = array_merge($dokumenData, [
                    'nomor_surat' => null,
                    'pengirim' => null,
                    'penerima' => null,
                    'perihal' => null,
                    'lampiran' => null,
                    'tanggal_surat' => null,
                ]);
            }

            $dokumens[] = $dokumenData;
        }

        Dokumen::truncate();
        Dokumen::insert($dokumens);

        // =================================================================
        // BAGIAN 5: SEEDING DATA PEGAWAI (DUMMY)
        // =================================================================
        $this->command->info('Membuat data Pegawai (dummy)...');

        if (empty($bidangIds)) {
            $this->command->info('Tidak ada data di tabel bidangs. Silakan jalankan bidangSeeder terlebih dahulu.');
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
                'bidang_id' => $faker->randomElement($bidangIds),
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
