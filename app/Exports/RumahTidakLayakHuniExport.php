<?php

namespace App\Exports;

use App\Models\RumahTidakLayakHuni; // Pastikan model ini ada
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

/**
 * Class RumahTidakLayakHuniExport untuk mengekspor data RTLH ke Excel.
 * Menggunakan FromQuery untuk efisiensi memori.
 * Dilengkapi filter dinamis dan styling kustom pada header.
 */
class RumahTidakLayakHuniExport implements FromQuery, WithMapping, WithEvents, ShouldAutoSize
{
    protected $filters;
    private $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Mengambil data dari database menggunakan query builder
     * dan menerapkan filter yang diterima.
     */
    public function query()
    {
        $query = RumahTidakLayakHuni::query();

        // Filter pencarian umum berdasarkan nama kepala keluarga atau NIK
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama_kepala_ruta', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan Kecamatan
        if (!empty($this->filters['kecamatan'])) {
            $query->where('kecamatan', $this->filters['kecamatan']);
        }

        // Filter berdasarkan Desa/Kelurahan
        if (!empty($this->filters['desa_kelurahan'])) {
            $query->where('desa_kelurahan', $this->filters['desa_kelurahan']);
        }

        // Filter berdasarkan Status Perbaikan
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query->orderBy('nama_kepala_ruta', 'asc');
    }

    /**
     * Memetakan setiap baris data ke format array yang akan diekspor.
     * Urutannya disesuaikan dengan header.
     *
     * @param RumahTidakLayakHuni $data
     */
    public function map($data): array
    {
        return [
            ++$this->rowNumber,
            $data->nama_kepala_ruta,
            " " . $data->nik, // Diberi ' agar NIK tidak menjadi format scientific
            $data->umur,
            $data->kecamatan,
            $data->desa_kelurahan,
            $data->alamat,
            $data->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            $data->kategori_rumah,
            $data->luas_rumah,
            $data->kepemilikan_rumah,
            $data->kepemilikan_tanah,
            $data->koordinat,
            $data->status,
            $data->created_at->format('d-m-Y H:i'),
        ];
    }

    /**
     * Mendaftarkan event AfterSheet untuk memanipulasi sheet
     * setelah semua data selesai ditulis.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // 1. Definisikan Header
                $headings = [
                    'No',
                    'Nama Kepala Keluarga',
                    'NIK',
                    'Umur',
                    'Kecamatan',
                    'Desa/Kelurahan',
                    'Alamat Lengkap',
                    'Jenis Kelamin',
                    'Kategori Rumah',
                    'Luas Rumah (m²)',
                    'Kepemilikan Rumah',
                    'Kepemilikan Tanah',
                    'Koordinat',
                    'Status Perbaikan',
                    'Tanggal Input',
                ];

                // Menambahkan 1 baris baru di atas untuk header
                $sheet->insertNewRowBefore(1, 1);
                $sheet->fromArray($headings, null, 'A1');

                // 2. Menerapkan Style untuk Header (Baris 1)
                $lastColumn = $sheet->getHighestColumn();
                $headerStyle = [
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFC5D9F1'], // Biru muda
                    ],
                ];
                $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray($headerStyle);

                // 3. Menerapkan Style untuk Sel Data (Mulai dari baris 2)
                $lastRow = $sheet->getHighestRow();
                if ($lastRow >= 2) {
                    $dataStyle = [
                        'borders' => [
                            'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_TOP,
                        ],
                    ];
                    $sheet->getStyle('A2:' . $lastColumn . $lastRow)->applyFromArray($dataStyle);
                }
            },
        ];
    }
}
