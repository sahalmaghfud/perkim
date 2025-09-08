<?php

namespace App\Imports;

use App\Models\Siteplan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToModel;

class SiteplanImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Siteplan([
            'nama' => $row['nama'] ?? null,
            'tipe' => $row['tipe'] ?? null,
            'luas_lahan_per_unit' => $row['luas_lahan_per_unit'] ?? null,
            'luas_lahan_perumahan' => $row['luas_lahan_perumahan_m2'] ?? null,
            'luas_psu' => $row['luas_psu_35_dari_luas_lahan_perumahan_m2'] ?? null,
            'panjang_prasarana_jalan' => $row['panjang_prasarana_jalan_m'] ?? null,
            'lebar_prasarana_jalan' => $row['lebar_prasarana_jalan_m'] ?? null,
            'luas_prasarana_jalan' => $row['luas_prasarana_jalan_m2'] ?? null,
            'luas_prasarana_drainase' => $row['luas_prsarana_drainase_m2'] ?? null,
            'luas_prasarana_rth' => $row['luas_prsarana_rth_m2'] ?? null,
            'luas_prasarana_tps' => $row['luas_prsarana_tps_m2'] ?? null,
            'luas_sarana_pemakaman' => $row['luas_sarana_pemakaman_m2_2_dari_luas_lahan'] ?? null,
            'luas_sarana_olahraga_dll' => $row['luas_sarana_olahragarekreasiperkantoransarana_ibadah_m2'] ?? null,
            'panjang_utilitas' => $row['panjang_utilitas_listrik_air_minum_telekomunikasi_dan_sistem_proteksi_kebakaran'] ?? null,
            'sumber_air_bersih' => $row['sumber_air_bersih_sumur_galisumur_borpdam'] ?? null,
            'jenis' => $row['jenis'] ?? null,
            'nama_pt' => $row['nama_pt'] ?? null,
            'jumlah_unit_rumah' => $row['jumlah_unit_rumah'] ?? null,
            'tahun' => $row['tahun'] ?? null,
            'alamat' => $row['alamat_jalanrtrw'] ?? null,
            'kecamatan' => $row['kecamatan'] ?? null,
            'desa' => $row['desa'] ?? null,
            'nomor_site_plan' => $row['nomor_site_plan'] ?? null,
            'tanggal_site_plan' => $this->transformDate($row['tanggal_site_plan'] ?? null),
            'nomor_bast_adm' => $row['nomor_bast_adm'] ?? null,
            'tanggal_bast_adm' => $this->transformDate($row['tanggal_bast_adm'] ?? null),
            'nomor_bast_fisik' => $row['nomor_bast_fisik'] ?? null,
            'tanggal_bast_fisik' => $this->transformDate($row['tanggal_bast_fisik'] ?? null),
            'keterangan' => $row['keterangan_jatuh_tempoprosesselesai'] ?? null,
        ]);
    }

    /**
     * Transform a date value from Excel.
     *
     * @param  string|int|null  $value
     * @return string|null
     */
    private function transformDate($value)
    {
        if (empty($value)) {
            return null;
        }

        // Coba parsing jika formatnya sudah Y-m-d atau d-m-Y
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            // Jika gagal, anggap itu adalah serial number Excel dan konversi
            try {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))->format('Y-m-d');
            } catch (\Exception $e) {
                return null; // Kembalikan null jika konversi tetap gagal
            }
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        // Menambahkan aturan validasi dasar
        return [
            '*.nama' => 'required',
            '*.nama_pt' => 'required',
            '*.nomor_site_plan' => 'nullable|unique:siteplans,nomor_site_plan',
        ];
    }
}
