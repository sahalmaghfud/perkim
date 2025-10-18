# SINTAK - Sistem Informasi Tata Kelola Perumahan dan Kawasan Permukiman

SINTAK adalah aplikasi web yang dibangun menggunakan Laravel untuk membantu pengelolaan data terkait perumahan dan kawasan permukiman (Perkim). Aplikasi ini mencakup berbagai modul untuk manajemen data internal, pelaporan, dan visualisasi.

## Fitur Utama

Aplikasi ini memiliki beberapa modul utama:

* **Dashboard**: Menampilkan ringkasan statistik data seperti jumlah pegawai, dokumen, CV, RTLH, proyek jalan, dan siteplan.
* **Manajemen Dokumen**: Mengelola dokumen internal dan surat-menyurat berdasarkan bidang (Perumahan, Permukiman, PSU, Sekretariat).
* **Manajemen Siteplan**: Mengelola data siteplan perumahan, termasuk informasi proyek, lahan, legalitas, dan PSU. Mendukung import dan export data Excel.
* **Manajemen Kepegawaian**: Mengelola data pegawai, termasuk informasi pribadi, kepegawaian, pendidikan, diklat, dan dokumen terkait. Mendukung export data Excel.
* **Manajemen Jalan Lingkungan**: Mengelola data proyek pekerjaan jalan lingkungan, termasuk detail pekerjaan, kontrak, keuangan, realisasi pencairan, dan dokumentasi foto. Mendukung export data Excel.
* **Manajemen RTLH (Rumah Tidak Layak Huni)**: Mengelola data rumah tidak layak huni, termasuk informasi penghuni, alamat, kondisi properti, dan dokumentasi foto. Mendukung export dan import data Excel.
* **Manajemen Inventaris (Aset)**: Mengelola data aset berdasarkan Kartu Inventaris Barang (KIB).
* **Peta Sebaran RTLH**: Visualisasi data RTLH dalam bentuk peta interaktif.
* **Manajemen CV**: Mengelola data perusahaan (CV) yang terkait dengan proyek jalan lingkungan.
* **Autentikasi & Manajemen Pengguna**: Sistem login dan manajemen hak akses (admin/user).
* **Backup System**: Fitur untuk melakukan backup database dan folder storage.

## Teknologi yang Digunakan

* **Backend**: PHP, Laravel Framework
* **Frontend**: Tailwind CSS, Vite
* **Database**: (Dapat dikonfigurasi, contoh: SQLite, MySQL, PostgreSQL)
* **Lainnya**: Maatwebsite/Excel (untuk import/export), Spatie Laravel Permission (kemungkinan untuk manajemen role)
