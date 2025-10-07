<?php

namespace App\Exports;

use App\Models\JalanLingkungan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class JalanLingkunganExport implements FromQuery, WithMapping, WithEvents, ShouldAutoSize
{
    protected $filters;
    private $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return JalanLingkungan::query()->with('cv')->orderBy('created_at', 'asc');
    }

    /**
     * Memetakan setiap baris data ke format array yang akan diekspor.
     * @param JalanLingkungan $row
     */
    public function map($row): array
    {
        $formatDate = fn($date) => $date ? Carbon::parse($date)->format('d-m-Y') : '-';

        return [
            ++$this->rowNumber,
            $row->uraian,
            // Anggaran
            $row->volume,
            $row->satuan,
            $row->harga_satuan,
            $row->jumlah_harga,
            // DIUBAH: Menambahkan detail CV
            $row->cv->nama_cv ?? '-',
            $row->cv->npwp ?? '-',
            "'" . ($row->cv->nomor_rekening ?? '-'), // Diberi ' agar dibaca sebagai teks
            $row->cv->nama_direktur ?? '-',
            // Kontrak
            $row->nomor_kontrak,
            $formatDate($row->tanggal_kontrak),
            $formatDate($row->tanggal_awal_pekerjaan),
            $formatDate($row->tanggal_akhir_pekerjaan),
            $row->nilai_kontrak,
            // Realisasi 30%
            $row->no_spm_30,
            $row->no_sp2d_30,
            $formatDate($row->tanggal_30),
            $row->nilai_30,
            $row->ppn_30,
            $row->pph_30,
            $row->total_30,
            // Realisasi 95%
            $row->no_spm_95,
            $row->no_sp2d_95,
            $formatDate($row->tanggal_95),
            $row->nilai_95,
            $row->ppn_95,
            $row->pph_95,
            $row->total_95,
            // Realisasi 100%
            $row->no_spm_100,
            $row->no_sp2d_100,
            $formatDate($row->tanggal_100),
            $row->nilai_100,
            $row->ppn_100,
            $row->pph_100,
            $row->total_100,

            // REKAPITULASI
            $row->nilai_30 + $row->nilai_95 + $row->nilai_100,
            $row->ppn_30 + $row->ppn_95 + $row->ppn_100,
            $row->pph_30 + $row->pph_95 + $row->pph_100,
            $row->total_30 + $row->total_95 + $row->total_100,

            // BAPHP & BASTB
            $row->baphp_nomor,
            $formatDate($row->baphp_tanggal),
            $row->bast_nomor,
            $formatDate($row->bast_tanggal),
            $row->keterangan,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->insertNewRowBefore(1, 3);

                // --- DEFINISI HEADER (MERGE & SET VALUE) ---
                $sheet->mergeCells('A1:A3')->setCellValue('A1', 'NO');
                $sheet->mergeCells('B1:B3')->setCellValue('B1', 'URAIAN');
                $sheet->mergeCells('C1:F1')->setCellValue('C1', 'ANGGARAN');
                $sheet->mergeCells('C2:D2')->setCellValue('C2', 'HARGA SATUAN');
                $sheet->setCellValue('C3', 'VOLUME');
                $sheet->setCellValue('D3', 'SATUAN');
                $sheet->mergeCells('E2:E3')->setCellValue('E2', 'HARGA SATUAN');
                $sheet->mergeCells('F2:F3')->setCellValue('F2', 'JUMLAH HARGA');

                // DIUBAH: Header Kontrak diperluas untuk menampung detail CV
                $sheet->mergeCells('G1:O1')->setCellValue('G1', 'KONTRAK');
                $sheet->mergeCells('G2:J2')->setCellValue('G2', 'PELAKSANA (CV)');
                $sheet->setCellValue('G3', 'NAMA CV');
                $sheet->setCellValue('H3', 'NPWP');
                $sheet->setCellValue('I3', 'REK. BANK JAMBI');
                $sheet->setCellValue('J3', 'DIREKTUR');

                $sheet->mergeCells('K2:K3')->setCellValue('K2', 'NOMOR KONTRAK');
                $sheet->mergeCells('L2:L3')->setCellValue('L2', 'TANGGAL KONTRAK');
                $sheet->mergeCells('M2:N2')->setCellValue('M2', 'JANGKA WAKTU PELAKSANAAN');
                $sheet->setCellValue('M3', 'TANGGAL AWAL');
                $sheet->setCellValue('N3', 'TANGGAL AKHIR');
                $sheet->mergeCells('O2:O3')->setCellValue('O2', 'NILAI KONTRAK');

                // Kolom setelahnya digeser
                $sheet->mergeCells('P1:AJ1')->setCellValue('P1', 'REALISASI');
                $sheet->mergeCells('P2:V2')->setCellValue('P2', 'PEMBAYARAN 30%');
                $sheet->setCellValue('P3', 'NO SPM');
                $sheet->setCellValue('Q3', 'NO SP2D');
                $sheet->setCellValue('R3', 'TANGGAL');
                $sheet->setCellValue('S3', 'NILAI');
                $sheet->setCellValue('T3', 'PPN');
                $sheet->setCellValue('U3', 'PPH');
                $sheet->setCellValue('V3', 'TOTAL');

                $sheet->mergeCells('W2:AC2')->setCellValue('W2', 'PEMBAYARAN 95%');
                $sheet->setCellValue('W3', 'NO SPM');
                $sheet->setCellValue('X3', 'NO SP2D');
                $sheet->setCellValue('Y3', 'TANGGAL');
                $sheet->setCellValue('Z3', 'NILAI');
                $sheet->setCellValue('AA3', 'PPN');
                $sheet->setCellValue('AB3', 'PPH');
                $sheet->setCellValue('AC3', 'TOTAL');

                $sheet->mergeCells('AD2:AJ2')->setCellValue('AD2', 'PEMBAYARAN 100%');
                $sheet->setCellValue('AD3', 'NO SPM');
                $sheet->setCellValue('AE3', 'NO SP2D');
                $sheet->setCellValue('AF3', 'TANGGAL');
                $sheet->setCellValue('AG3', 'NILAI');
                $sheet->setCellValue('AH3', 'PPN');
                $sheet->setCellValue('AI3', 'PPH');
                $sheet->setCellValue('AJ3', 'TOTAL');

                $sheet->mergeCells('AK1:AN1')->setCellValue('AK1', 'REKAPITULASI');
                $sheet->mergeCells('AK2:AK3')->setCellValue('AK2', 'NILAI TOTAL');
                $sheet->mergeCells('AL2:AL3')->setCellValue('AL2', 'TOTAL PPN');
                $sheet->mergeCells('AM2:AM3')->setCellValue('AM2', 'TOTAL PPH');
                $sheet->mergeCells('AN2:AN3')->setCellValue('AN2', 'TOTAL');

                $sheet->mergeCells('AO1:AP1')->setCellValue('AO1', 'BAPHP');
                $sheet->mergeCells('AO2:AO3')->setCellValue('AO2', 'NOMOR');
                $sheet->mergeCells('AP2:AP3')->setCellValue('AP2', 'TANGGAL');

                $sheet->mergeCells('AQ1:AR1')->setCellValue('AQ1', 'BASTB');
                $sheet->mergeCells('AQ2:AQ3')->setCellValue('AQ2', 'NOMOR');
                $sheet->mergeCells('AR2:AR3')->setCellValue('AR2', 'TANGGAL');

                $sheet->mergeCells('AS1:AS3')->setCellValue('AS1', 'KET');

                // --- STYLE ---
                $lastCol = 'AS';
                $headerStyle = [
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ];
                $sheet->getStyle('A1:' . $lastCol . '3')->applyFromArray($headerStyle);

                // Pewarnaan Header
                $sheet->getStyle('P2:V3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00'); // Yellow
                $sheet->getStyle('W2:AC3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF92D050'); // Green
                $sheet->getStyle('AD2:AJ3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF00B0F0'); // Blue
                $sheet->getStyle('AK1:AN3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFC000'); // Orange
    
                $lastRow = $sheet->getHighestRow();
                if ($lastRow >= 4) {
                    $dataStyle = [
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
                    ];
                    $sheet->getStyle('A4:' . $lastCol . $lastRow)->applyFromArray($dataStyle);
                }
            },
        ];
    }
}

