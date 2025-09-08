<?php

namespace App\Exports;

use App\Models\Siteplan;
use Maatwebsite\Excel\Concerns\FromCollection;

class SiteplanExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Memilih semua kolom yang relevan dari model Siteplan
        return Siteplan::select(
            'nama',
            'tipe',
            'luas_lahan_per_unit',
            'luas_lahan_perumahan',
            'luas_psu',
            'panjang_prasarana_jalan',
            'lebar_prasarana_jalan',
            'luas_prasarana_jalan',
            'luas_prasarana_drainase',
            'luas_prasarana_rth',
            'luas_prasarana_tps',
            'luas_sarana_pemakaman',
            'luas_sarana_olahraga_dll',
            'panjang_utilitas',
            'sumber_air_bersih',
            'jenis',
            'nama_pt',
            'jumlah_unit_rumah',
            'tahun',
            'alamat',
            'kecamatan',
            'desa',
            'nomor_site_plan',
            'tanggal_site_plan',
            'nomor_bast_adm',
            'tanggal_bast_adm',
            'nomor_bast_fisik',
            'tanggal_bast_fisik',
            'keterangan'
        )->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Menentukan nama-nama kolom header di file Excel
        return [
            'Nama',
            'Tipe',
            'Luas Lahan Per Unit',
            'Luas Lahan Perumahan (M2)',
            'Luas PSU (M2)',
            'Panjang Prasarana Jalan (M)',
            'Lebar Prasarana Jalan (M)',
            'Luas Prasarana Jalan (M2)',
            'Luas Prasarana Drainase (M2)',
            'Luas Prasarana RTH (M2)',
            'Luas Prasarana TPS (M2)',
            'Luas Sarana Pemakaman (M2)',
            'Luas Sarana Olahraga/Lainnya (M2)',
            'Panjang Utilitas',
            'Sumber Air Bersih',
            'Jenis',
            'Nama PT',
            'Jumlah Unit Rumah',
            'Tahun',
            'Alamat',
            'Kecamatan',
            'Desa',
            'Nomor Site Plan',
            'Tanggal Site Plan',
            'Nomor BAST Adm',
            'Tanggal BAST Adm',
            'Nomor BAST Fisik',
            'Tanggal BAST Fisik',
            'Keterangan',
        ];
    }
}
