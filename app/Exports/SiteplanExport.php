<?php

namespace App\Exports;

use App\Models\Siteplan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings; // Gunakan WithHeadings untuk header sederhana
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiteplanExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $filters;
    private $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Mengambil data dari database dengan filter.
     * Bagian ini tidak perlu diubah.
     */
    public function query()
    {
        $query = Siteplan::query();

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where('nama', 'like', "%{$search}%");
        }
        if (!empty($this->filters['nama_pt'])) {
            $query->where('nama_pt', $this->filters['nama_pt']);
        }
        if (!empty($this->filters['kecamatan'])) {
            $query->where('kecamatan', $this->filters['kecamatan']);
        }
        if (!empty($this->filters['desa'])) {
            $query->where('desa', $this->filters['desa']);
        }
        if (!empty($this->filters['keterangan'])) {
            $query->where('keterangan', $this->filters['keterangan']);
        }

        return $query->orderBy('nama', 'asc');
    }

    /**
     * [PERUBAHAN UTAMA]
     * Mendefinisikan header sesuai urutan yang diminta tanpa merge.
     */
    public function headings(): array
    {
        return [
            'No.',
            'Nama',
            'Tipe',
            'Luas Lahan Per Unit',
            'Luas Lahan Perumahan (M2)',
            'Luas PSU (35% dari luas lahan Perumahan M2)',
            'Panjang Prasarana Jalan (M)',
            'Lebar Prasarana Jalan (M)',
            'Luas Prasarana Jalan (M2)',
            'Luas Prasarana Drainase (M2)',
            'Luas Prasarana RTH (M2)',
            'Luas Prasarana TPS (M2)',
            'Luas Sarana Pemakaman (M2) (2% dari luas lahan)',
            'Luas Sarana Olahraga/Rekreasi/Perkantoran/Sarana Ibadah (M2)',
            'Panjang Utilitas (Listrik, air minum, telekomunikasi, dan sistem proteksi kebakaran)',
            'Sumber Air Bersih (Sumur Gali/Sumur Bor/PDAM)',
            'Jenis',
            'Nama PT',
            'Jumlah Unit Rumah',
            'Tahun',
            'Alamat (Jalan/RT/RW)',
            'Kecamatan',
            'DESA',
            'Nomor Site Plan',
            'Tanggal Site Plan',
            'Nomor BAST Adm',
            'Tanggal BAST Adm',
            'Nomor BAST Fisik',
            'Tanggal BAST Fisik',
            'Keterangan (Jatuh Tempo/Proses/Selesai)',
        ];
    }

    /**
     * [PERUBAHAN UTAMA]
     * Memetakan data sesuai urutan header yang baru.
     *
     * @param Siteplan $siteplan
     */
    public function map($siteplan): array
    {
        return [
            ++$this->rowNumber,
            $siteplan->nama,
            $siteplan->tipe,
            $siteplan->luas_lahan_per_unit,
            $siteplan->luas_lahan_perumahan,
            $siteplan->luas_psu,
            $siteplan->panjang_prasarana_jalan,
            $siteplan->lebar_prasarana_jalan,
            $siteplan->luas_prasarana_jalan,
            $siteplan->luas_prasarana_drainase,
            $siteplan->luas_prasarana_rth,
            $siteplan->luas_prasarana_tps,
            $siteplan->luas_sarana_pemakaman,
            $siteplan->luas_sarana_olahraga_dll,
            $siteplan->panjang_utilitas,
            $siteplan->sumber_air_bersih,
            $siteplan->jenis,
            $siteplan->nama_pt,
            $siteplan->jumlah_unit_rumah,
            $siteplan->tahun,
            $siteplan->alamat,
            $siteplan->kecamatan,
            $siteplan->desa,
            "'" . $siteplan->nomor_site_plan,
            $siteplan->tanggal_site_plan ? Carbon::parse($siteplan->tanggal_site_plan)->format('d-m-Y') : '-',
            "'" . $siteplan->nomor_bast_adm,
            $siteplan->tanggal_bast_adm ? Carbon::parse($siteplan->tanggal_bast_adm)->format('d-m-Y') : '-',
            "'" . $siteplan->nomor_bast_fisik,
            $siteplan->tanggal_bast_fisik ? Carbon::parse($siteplan->tanggal_bast_fisik)->format('d-m-Y') : '-',
            $siteplan->keterangan,
        ];
    }

    /**
     * Menerapkan style ke sheet.
     */
    public function styles(Worksheet $sheet)
    {
        // Style untuk header di baris pertama (A1 sampai AE1)
        $sheet->getStyle('A1:AE1')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFC5D9F1'],
            ],
        ]);

        // Style untuk seluruh data (border)
        // Diterapkan setelah sheet selesai dibuat agar lebih akurat
    }

    /**
     * [DISEDERHANAKAN]
     * Mendaftarkan event untuk styling akhir.
     * Header sudah dibuat oleh WithHeadings.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // Menambahkan border ke seluruh sel yang terisi (header + data)
                $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Menambahkan alignment TOP untuk sel data
                $sheet->getStyle('A2:' . $highestColumn . $highestRow)->applyFromArray([
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                    ],
                ]);
            },
        ];
    }
}
