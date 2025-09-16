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
use App\Models\Pangkat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
            ['nama_bidang' => 'sekertariat'],  // Tata Usaha
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
                'bidang_slug' => 'sekertariat',
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
        $data = [
            ['pangkat' => 'Juru Muda', 'golongan' => 'I', 'ruang' => 'a'],
            ['pangkat' => 'Juru Muda Tingkat I', 'golongan' => 'I', 'ruang' => 'b'],
            ['pangkat' => 'Juru', 'golongan' => 'I', 'ruang' => 'c'],
            ['pangkat' => 'Juru Tingkat I', 'golongan' => 'I', 'ruang' => 'd'],
            ['pangkat' => 'Pengatur Muda', 'golongan' => 'II', 'ruang' => 'a'],
            ['pangkat' => 'Pengatur Muda Tingkat I', 'golongan' => 'II', 'ruang' => 'b'],
            ['pangkat' => 'Pengatur', 'golongan' => 'II', 'ruang' => 'c'],
            ['pangkat' => 'Pengatur Tingkat I', 'golongan' => 'II', 'ruang' => 'd'],
            ['pangkat' => 'Penata Muda', 'golongan' => 'III', 'ruang' => 'a'],
            ['pangkat' => 'Penata Muda Tingkat I', 'golongan' => 'III', 'ruang' => 'b'],
            ['pangkat' => 'Penata', 'golongan' => 'III', 'ruang' => 'c'],
            ['pangkat' => 'Penata Tingkat I', 'golongan' => 'III', 'ruang' => 'd'],
            ['pangkat' => 'Pembina', 'golongan' => 'IV', 'ruang' => 'a'],
            ['pangkat' => 'Pembina Tingkat I', 'golongan' => 'IV', 'ruang' => 'b'],
            ['pangkat' => 'Pembina Utama Muda', 'golongan' => 'IV', 'ruang' => 'c'],
            ['pangkat' => 'Pembina Utama Madya', 'golongan' => 'IV', 'ruang' => 'd'],
            ['pangkat' => 'Pembina Utama', 'golongan' => 'IV', 'ruang' => 'e'],
        ];

        // Masukkan data ke dalam database
        foreach ($data as $item) {
            Pangkat::create($item);
        }

        DB::table('pegawai')->insert([
            // Data 1: ERIK AHMAD, ST
            [
                'bidang_id' => 1, // Asumsi, silakan disesuaikan
                'pangkat_id' => 11, // Penata - III/c
                'nama' => 'Erik Ahmad, ST',
                'nip' => '198205132010011009',
                'tempat_lahir' => 'Padang', // Asumsi, tidak ada di data
                'tanggal_lahir' => '1982-05-13', // Diambil dari NIP
                'jenis_kelamin' => 'L',
                'foto' => null,
                'tmt_cpns' => '2010-02-08',
                'tmt_pangkat' => '2018-04-01',
                'nama_jabatan' => 'Kasi Survey, Analisa Data Perumahan',
                'eselon' => 'IV.a',
                'tmt_jabatan' => '2018-02-15',
                'nama_diklat' => null,
                'tahun_diklat' => null,
                'jumlah_jam_diklat' => null,
                'pendidikan_terakhir' => 'UNIV. BUNG HATTA',
                'jurusan' => 'Teknik', // Diambil dari gelar
                'tahun_lulus' => '2007',
                'catatan_mutasi' => null,
                'keterangan' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Data 2: FAISAL, SH
            [
                'bidang_id' => 1, // Asumsi, silakan disesuaikan
                'pangkat_id' => 12, // Penata Tingkat I - III/d
                'nama' => 'Faisal, SH',
                'nip' => '198304182008011001',
                'tempat_lahir' => 'Jambi', // Asumsi, tidak ada di data
                'tanggal_lahir' => '1983-04-18', // Diambil dari NIP
                'jenis_kelamin' => 'L',
                'foto' => null,
                'tmt_cpns' => '2008-01-01',
                'tmt_pangkat' => '2018-10-01',
                'nama_jabatan' => 'Kabid Perumahan dan Permukiman',
                'eselon' => 'III.b',
                'tmt_jabatan' => '2021-06-07',
                'nama_diklat' => 'PIM III',
                'tahun_diklat' => '2018',
                'jumlah_jam_diklat' => 893,
                'pendidikan_terakhir' => 'UNBARI',
                'jurusan' => 'Ilmu Hukum', // Diambil dari gelar
                'tahun_lulus' => '2010',
                'catatan_mutasi' => null,
                'keterangan' => 'Kesra',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Data 3: INANI, SE
            [
                'bidang_id' => 2, // Asumsi, silakan disesuaikan
                'pangkat_id' => 11, // Penata - III/c
                'nama' => 'Inani, SE',
                'nip' => '198101012008012016',
                'tempat_lahir' => 'Jambi', // Asumsi, tidak ada di data
                'tanggal_lahir' => '1981-01-01', // Diambil dari NIP
                'jenis_kelamin' => 'P',
                'foto' => null,
                'tmt_cpns' => '2008-01-01',
                'tmt_pangkat' => '2019-04-01',
                'nama_jabatan' => 'Kasubag Umum dan Keuangan',
                'eselon' => 'IV.a',
                'tmt_jabatan' => '2020-02-07',
                'nama_diklat' => null,
                'tahun_diklat' => null,
                'jumlah_jam_diklat' => null,
                'pendidikan_terakhir' => 'UNBARI',
                'jurusan' => 'Ekonomi', // Diambil dari gelar
                'tahun_lulus' => '2010',
                'catatan_mutasi' => null,
                'keterangan' => 'BPKAD',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Data 4: METTI ARNAWATI, SH
            [
                'bidang_id' => 3, // Asumsi, silakan disesuaikan
                'pangkat_id' => 11, // Penata - III/c
                'nama' => 'Metti Arnawati, SH',
                'nip' => '198105152010012001',
                'tempat_lahir' => 'Jambi', // Asumsi, tidak ada di data
                'tanggal_lahir' => '1981-05-15', // Diambil dari NIP
                'jenis_kelamin' => 'P',
                'foto' => null,
                'tmt_cpns' => '2010-01-01',
                'tmt_pangkat' => '2019-04-01',
                'nama_jabatan' => 'Kasi Sarana dan Prasarana',
                'eselon' => 'IV.a',
                'tmt_jabatan' => '2018-02-15',
                'nama_diklat' => null,
                'tahun_diklat' => null,
                'jumlah_jam_diklat' => null,
                'pendidikan_terakhir' => 'UNIV. JAMBI',
                'jurusan' => 'Ilmu Hukum', // Diambil dari gelar
                'tahun_lulus' => '2003',
                'catatan_mutasi' => null,
                'keterangan' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        $this->command->info('Database seeding selesai!');
    }
}
