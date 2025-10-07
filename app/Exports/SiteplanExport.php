<?php

namespace App\Exports;

use App\Models\Siteplan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiteplanExport implements FromQuery, WithMapping, WithEvents, ShouldAutoSize, WithStyles
{
    protected $filters;
    private $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Menggunakan FromQuery untuk efisiensi dan menerapkan filter.
     */
    public function query()
    {
        $query = Siteplan::query();

        // 1. Filter Pencarian Umum (search)
        // Diperbarui agar hanya mencari 'nama' pemohon sesuai placeholder
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where('nama', 'like', "%{$search}%");
        }

        // 2. BARU: Filter berdasarkan Nama PT
        if (!empty($this->filters['nama_pt'])) {
            $query->where('nama_pt', $this->filters['nama_pt']);
        }

        // 3. Filter berdasarkan Kecamatan (sudah ada)
        if (!empty($this->filters['kecamatan'])) {
            $query->where('kecamatan', $this->filters['kecamatan']);
        }

        // 4. BARU: Filter berdasarkan Desa
        if (!empty($this->filters['desa'])) {
            $query->where('desa', $this->filters['desa']);
        }

        // 5. Filter berdasarkan Keterangan (sudah ada)
        if (!empty($this->filters['keterangan'])) {
            $query->where('keterangan', $this->filters['keterangan']);
        }

        return $query->orderBy('nama', 'asc');
    }

    /**
     * Memetakan data sesuai urutan kolom pada header.
     *
     * @param Siteplan $siteplan
     */
    public function map($siteplan): array
    {
        return [
            ++$this->rowNumber,
            $siteplan->nama,
            $siteplan->nama_pt,
            $siteplan->alamat,
            $siteplan->kecamatan,
            $siteplan->desa,
            "'" . $siteplan->nomor_site_plan, // Diberi ' agar dibaca sebagai teks
            $siteplan->tanggal_site_plan ? Carbon::parse($siteplan->tanggal_site_plan)->format('d-m-Y') : '-',
            $siteplan->jumlah_unit_rumah,
            $siteplan->jenis,
            $siteplan->tipe,
            $siteplan->luas_lahan_per_unit,
            $siteplan->luas_lahan_perumahan,
            $siteplan->luas_psu,
            // Prasarana
            $siteplan->luas_prasarana_jalan,
            $siteplan->luas_prasarana_drainase,
            // Sarana
            $siteplan->luas_sarana_ibadah,      // Asumsi ada kolom ini di DB Anda
            $siteplan->luas_sarana_perniagaan, // Asumsi ada kolom ini di DB Anda
            $siteplan->luas_sarana_olahraga_dll,
            $siteplan->luas_sarana_rth,         // Di gambar RTH masuk Sarana
            $siteplan->luas_sarana_pemakaman,
            // Utilitas
            $siteplan->panjang_utilitas,
            $siteplan->sumber_air_bersih,
            // BAST
            "'" . $siteplan->nomor_bast_adm,
            $siteplan->tanggal_bast_adm ? Carbon::parse($siteplan->tanggal_bast_adm)->format('d-m-Y') : '-',
            "'" . $siteplan->nomor_bast_fisik,
            $siteplan->tanggal_bast_fisik ? Carbon::parse($siteplan->tanggal_bast_fisik)->format('d-m-Y') : '-',
            // Lain-lain
            $siteplan->tahun,
            $siteplan->keterangan,
        ];
    }

    /**
     * Menerapkan style ke sheet.
     */
    public function styles(Worksheet $sheet)
    {
        // Menambahkan border ke sel data mulai dari baris ke-3
        $sheet->getStyle('A3:AD' . ($this->rowNumber + 2))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
            ],
        ]);
    }

    /**
     * Mendaftarkan event untuk membuat custom header setelah sheet dibuat.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Tambah 2 baris kosong di atas untuk header
                $sheet->insertNewRowBefore(1, 2);

                // --- HEADER BARIS 1 (Teks & Merge) ---
                $sheet->setCellValue('A1', 'No.')->mergeCells('A1:A2');
                $sheet->setCellValue('B1', 'NAMA PERUMAHAN')->mergeCells('B1:B2');
                $sheet->setCellValue('C1', 'NAMA PT')->mergeCells('C1:C2');
                $sheet->setCellValue('D1', 'ALAMAT')->mergeCells('D1:D2');
                $sheet->setCellValue('E1', 'LOKASI')->mergeCells('E1:F1');
                $sheet->setCellValue('G1', 'SITEPLAN')->mergeCells('G1:H1');
                $sheet->setCellValue('I1', 'DATA UNIT')->mergeCells('I1:K1');
                $sheet->setCellValue('L1', 'LUAS LAHAN (M2)')->mergeCells('L1:N1');
                $sheet->setCellValue('O1', 'RINCIAN LUAS PSU (M2)')->mergeCells('O1:W1');
                $sheet->setCellValue('X1', 'BERITA ACARA SERAH TERIMA')->mergeCells('X1:AA1');
                $sheet->setCellValue('AB1', 'Tahun')->mergeCells('AB1:AB2');
                $sheet->setCellValue('AC1', 'Keterangan')->mergeCells('AC1:AC2');
                $sheet->setCellValue('AD1', 'File Path')->mergeCells('AD1:AD2'); // Kolom tambahan
    
                // --- HEADER BARIS 2 (Sub-header) ---
                $sheet->setCellValue('E2', 'Kecamatan');
                $sheet->setCellValue('F2', 'Desa/Kelurahan');
                $sheet->setCellValue('G2', 'Nomor');
                $sheet->setCellValue('H2', 'Tanggal');
                $sheet->setCellValue('I2', 'Jumlah');
                $sheet->setCellValue('J2', 'Jenis');
                $sheet->setCellValue('K2', 'Type');
                $sheet->setCellValue('L2', 'Per Unit');
                $sheet->setCellValue('M2', 'Perumahan');
                $sheet->setCellValue('N2', 'PSU');
                $sheet->setCellValue('O2', 'Prasarana Jalan');
                $sheet->setCellValue('P2', 'Prasarana Drainase');
                $sheet->setCellValue('Q2', 'Sarana Ibadah');
                $sheet->setCellValue('R2', 'Sarana Perniagaan');
                $sheet->setCellValue('S2', 'Sarana Olah Raga dan Lapangan Terbuka');
                $sheet->setCellValue('T2', 'Sarana RTH');
                $sheet->setCellValue('U2', 'Sarana Makam');
                $sheet->setCellValue('V2', 'Utilitas Jaringan');
                $sheet->setCellValue('W2', 'Sumber Air Bersih');
                $sheet->setCellValue('X2', 'Nomor BAST Administrasi');
                $sheet->setCellValue('Y2', 'Tanggal');
                $sheet->setCellValue('Z2', 'Nomor BAST Fisik');
                $sheet->setCellValue('AA2', 'Tanggal');

                // --- STYLE UNTUK HEADER ---
                $headerStyle = [
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFC5D9F1'], // Biru muda seperti di gambar
                    ],
                ];

                // Terapkan style ke seluruh range header
                $sheet->getStyle('A1:AD2')->applyFromArray($headerStyle);
            },
        ];
    }
}
