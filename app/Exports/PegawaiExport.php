<?php

namespace App\Exports;

use App\Models\Pegawai;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PegawaiExport implements FromQuery, WithMapping, WithEvents, ShouldAutoSize, WithStyles
{
    private $rowNumber = 0;

    /**
     * Mengambil data pegawai dari database.
     * Menggunakan `FromQuery` lebih efisien untuk data besar.
     */
    public function query()
    {
        return Pegawai::query()->with('pangkat')->orderBy('nama', 'asc');
    }

    /**
     * Memetakan data dari model Pegawai ke format array untuk setiap baris Excel.
     *
     * @param Pegawai $pegawai
     */
    public function map($pegawai): array
    {
        // Hitung Masa Kerja dari TMT CPNS
        $masaKerja = Carbon::parse($pegawai->tmt_cpns)->diff(now());

        // Hitung Usia dari Tanggal Lahir
        $usia = Carbon::parse($pegawai->tanggal_lahir)->diff(now());

        return [
            // No. Urut
            ++$this->rowNumber,

            // NAMA
            $pegawai->nama,

            // NIP (diberi tanda ' agar Excel membacanya sebagai teks)
            "'" . $pegawai->nip,

            // TMT CPNS
            Carbon::parse($pegawai->tmt_cpns)->format('d-m-Y'),

            // PANGKAT - GOL/RUANG
            $pegawai->pangkat ? ($pegawai->pangkat->golongan . '/' . $pegawai->pangkat->ruang) : '-',

            // PANGKAT - TMT
            Carbon::parse($pegawai->tmt_pangkat)->format('d-m-Y'),

            // JABATAN - NAMA JABATAN
            $pegawai->nama_jabatan,

            // JABATAN - ESELON
            $pegawai->eselon,

            // JABATAN - TMT
            $pegawai->tmt_jabatan ? Carbon::parse($pegawai->tmt_jabatan)->format('d-m-Y') : '-',

            // MASA KERJA - TAHUN
            $masaKerja->y,

            // MASA KERJA - BULAN
            $masaKerja->m,

            // DIKLAT JABATAN - NAMA
            $pegawai->nama_diklat,

            // DIKLAT JABATAN - TAHUN
            $pegawai->tahun_diklat,

            // DIKLAT JABATAN - JML JAM
            $pegawai->jumlah_jam_diklat,

            $pegawai->nama_univ,

            // PENDIDIKAN TERAKHIR - TH/LULUS
            $pegawai->tahun_lulus,

            // PENDIDIKAN TERAKHIR - TKT. IJAZAH
            $pegawai->pendidikan_terakhir,


            // JENIS KELAMIN - L
            $pegawai->jenis_kelamin == 'L' ? 'L' : '',

            // JENIS KELAMIN - P
            $pegawai->jenis_kelamin == 'P' ? 'P' : '',

            // USIA - TAHUN
            $usia->y,

            // USIA - BULAN
            $usia->m,

            // CATATAN MUTASI KEPEG
            $pegawai->catatan_mutasi,

            // KET
            $pegawai->keterangan,
        ];
    }

    /**
     * Menerapkan style ke seluruh sheet.
     */
    public function styles(Worksheet $sheet)
    {
        // Menambahkan border ke seluruh sel data mulai dari baris ke-3
        $sheet->getStyle('A3:W' . ($this->rowNumber + 2))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
    }

    /**
     * Mendaftarkan event untuk manipulasi sheet setelah data dimuat.
     * Digunakan untuk membuat header multi-baris.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Menambahkan baris baru di atas untuk header
                $sheet->insertNewRowBefore(1, 2);

                // --- HEADER BARIS 1 (Teks & Merge) ---
                $sheet->setCellValue('A1', 'No. Urut')->mergeCells('A1:A2');
                $sheet->setCellValue('B1', 'NAMA')->mergeCells('B1:B2');
                $sheet->setCellValue('C1', 'NIP')->mergeCells('C1:C2');
                $sheet->setCellValue('D1', 'TMT CPNS')->mergeCells('D1:D2');
                $sheet->setCellValue('E1', 'PANGKAT')->mergeCells('E1:F1');
                $sheet->setCellValue('G1', 'JABATAN')->mergeCells('G1:I1');
                $sheet->setCellValue('J1', 'MASA KERJA')->mergeCells('J1:K1');
                $sheet->setCellValue('L1', 'DIKLAT JABATAN')->mergeCells('L1:N1');
                $sheet->setCellValue('O1', 'PENDIDIKAN TERAKHIR')->mergeCells('O1:Q1');
                $sheet->setCellValue('R1', 'JENIS KELAMIN')->mergeCells('R1:S1');
                $sheet->setCellValue('T1', 'USIA')->mergeCells('T1:U1');
                $sheet->setCellValue('V1', 'CATATAN MUTASI KEPEG')->mergeCells('V1:V2');
                $sheet->setCellValue('W1', 'KET')->mergeCells('W1:W2');


                // --- HEADER BARIS 2 (Sub-header) ---
                $sheet->setCellValue('E2', 'GOL/RUANG');
                $sheet->setCellValue('F2', 'TMT');
                $sheet->setCellValue('G2', 'NAMA JABATAN');
                $sheet->setCellValue('H2', 'ESELON');
                $sheet->setCellValue('I2', 'TMT');
                $sheet->setCellValue('J2', 'TAHUN');
                $sheet->setCellValue('K2', 'BULAN');
                $sheet->setCellValue('L2', 'NAMA');
                $sheet->setCellValue('M2', 'TAHUN');
                $sheet->setCellValue('N2', 'JML JAM');
                $sheet->setCellValue('O2', 'NAMA UNIV/P.T');
                $sheet->setCellValue('P2', 'THN LULUS');
                $sheet->setCellValue('Q2', 'TKT. IJAZAH');
                $sheet->setCellValue('R2', 'L');
                $sheet->setCellValue('S2', 'P');
                $sheet->setCellValue('T2', 'TAHUN');
                $sheet->setCellValue('U2', 'BULAN');


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
                        'startColor' => ['argb' => 'FFD3D3D3'], // Warna abu-abu muda
                    ],
                ];

                // Terapkan style ke seluruh range header (A1 sampai W2)
                $sheet->getStyle('A1:W2')->applyFromArray($headerStyle);
            },
        ];
    }
}
