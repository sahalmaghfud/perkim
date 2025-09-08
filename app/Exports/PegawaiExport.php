<?php

namespace App\Exports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PegawaiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pegawai::with('bidang')->get()->map(function ($p) {
            return [
                'NIP' => $p->nip,
                'Nama Lengkap' => $p->nama_lengkap,
                'bidang' => $p->bidang->nama_bidang ?? 'N/A',
                'Jabatan' => $p->jabatan,
                'Email' => $p->email,
                'Tanggal Masuk' => $p->tanggal_masuk,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Nama Lengkap',
            'bidang',
            'Jabatan',
            'Email',
            'Tanggal Masuk',
        ];
    }
}
