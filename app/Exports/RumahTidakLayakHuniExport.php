<?php

namespace App\Exports;

use App\Models\RumahTidakLayakHuni;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RumahTidakLayakHuniExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
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

        return $query->orderBy('nama_kepala_ruta', 'asc');
    }

    /**
     * Memetakan setiap baris data ke format array yang akan diekspor.
     * @param RumahTidakLayakHuni $data
     */
    public function map($data): array
    {
        return [
            ++$this->rowNumber,
            $data->nama_kepala_ruta,
            "'" . $data->nik, // Diberi ' agar NIK tidak menjadi format scientific
            $data->umur,
            $data->kecamatan,
            $data->desa_kelurahan,
            $data->alamat,
            $data->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            $data->luas_rumah,
            $data->kepemilikan_tanah,
            "'" . $data->no_sertifikat,
            $data->kondisi_lantai,
            $data->kondisi_dinding,
            $data->kondisi_atap,
            $data->sumber_air,
            $data->sanitasi_wc,
            $data->dapur,
            $data->koordinat,
            $data->created_at->format('d-m-Y H:i'),
        ];
    }

    /**
     * Menentukan header untuk file Excel.
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Kepala Keluarga',
            'NIK',
            'Umur',
            'Kecamatan',
            'Desa/Kelurahan',
            'Alamat Lengkap',
            'Jenis Kelamin',
            'Luas Rumah (m²)',
            'Kepemilikan Tanah',
            'No Sertifikat',
            'Kondisi Lantai',
            'Kondisi Dinding',
            'Kondisi Atap',
            'Sumber Air',
            'Sanitasi/WC',
            'Dapur',
            'Koordinat',
            'Tanggal Input',
        ];
    }

    /**
     * Menerapkan styling setelah sheet dibuat.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastColumn = $sheet->getHighestColumn();

                // Style untuk header
                $headerStyle = [
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFC5D9F1']],
                ];
                $sheet->getStyle('A1:' . $lastColumn . '1')->applyFromArray($headerStyle);

                // Style untuk sel data
                $lastRow = $sheet->getHighestRow();
                if ($lastRow >= 2) {
                    $dataStyle = [
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_TOP],
                    ];
                    $sheet->getStyle('A2:' . $lastColumn . $lastRow)->applyFromArray($dataStyle);
                }
            },
        ];
    }
}
