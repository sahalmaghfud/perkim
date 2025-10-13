<?php

namespace App\Imports;

use App\Models\RumahTidakLayakHuni;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class RumahTidakLayakHuniImport implements
    ToModel,
    WithHeadingRow,
    WithBatchInserts,
    WithChunkReading,
    SkipsOnError
{
    /**
     * Memetakan data dari setiap baris di file Excel ke model RumahTidakLayakHuni.
     * WithHeadingRow akan secara otomatis mengubah header seperti 'Nama Kepala Keluarga'
     * menjadi 'nama_kepala_keluarga' sebagai kunci array.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new RumahTidakLayakHuni([
            'nama_kepala_ruta' => $row['nama_kepala_keluarga'],
            'nik' => $row['nik'],
            'umur' => $row['umur'],
            'kecamatan' => $row['kecamatan'],
            'desa_kelurahan' => $row['desakelurahan'],
            'alamat' => $row['alamat_lengkap'],
            'jenis_kelamin' => ($row['jenis_kelamin'] === 'Laki-laki') ? 'L' : 'P',
            'luas_rumah' => $row['luas_rumah_m'],
            'kepemilikan_tanah' => $row['kepemilikan_tanah'],
            'no_sertifikat' => $row['no_sertifikat'],
            'kondisi_lantai' => $row['kondisi_lantai'],
            'kondisi_dinding' => $row['kondisi_dinding'],
            'kondisi_atap' => $row['kondisi_atap'],
            'sumber_air' => $row['sumber_air'],
            'sanitasi_wc' => $row['sanitasiwc'],
            'dapur' => $row['dapur'],
            'kode_wilayah' => $row['kode_wilayah'],
            'koordinat' => $row['koordinat'],
        ]);
    }

    /**
     * Menentukan ukuran batch untuk penyisipan data ke database.
     * Ini akan mengelompokkan beberapa data sebelum melakukan query INSERT.
     */
    public function batchSize(): int
    {
        return 500;
    }

    /**
     * Menentukan ukuran chunk untuk membaca file Excel.
     * Ini berguna untuk file yang sangat besar agar tidak membebani memori.
     */
    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * Menangani error/exception yang mungkin terjadi selama proses import.
     * @param Throwable $e
     */
    public function onError(Throwable $e)
    {
        dd($e);
    }
}

