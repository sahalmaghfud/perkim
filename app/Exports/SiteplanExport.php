<?php

namespace App\Exports;

use App\Models\Siteplan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class SiteplanExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @var array
     */
    protected $filters;

    /**
     * Constructor untuk menerima array filter dari controller.
     *
     * @param array $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Menyiapkan query ke database dengan menerapkan filter yang diterima.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Siteplan::query();

        // 1. Terapkan filter pencarian kata kunci
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nama_pt', 'like', "%{$search}%")
                    ->orWhere('nomor_site_plan', 'like', "%{$search}%");
            });
        }

        // 2. Terapkan filter berdasarkan kategori (dropdown)
        if (!empty($this->filters['kecamatan'])) {
            $query->where('kecamatan', $this->filters['kecamatan']);
        }
        if (!empty($this->filters['desa'])) {
            $query->where('desa', $this->filters['desa']);
        }
        if (!empty($this->filters['nama_pt'])) {
            $query->where('nama_pt', $this->filters['nama_pt']);
        }
        if (!empty($this->filters['keterangan'])) {
            $query->where('keterangan', $this->filters['keterangan']);
        }
        if (!empty($this->filters['jenis'])) {
            $query->where('jenis', $this->filters['jenis']);
        }
        if (!empty($this->filters['tahun'])) {
            $query->where('tahun', $this->filters['tahun']);
        }

        // 3. Terapkan filter rentang tanggal
        if (!empty($this->filters['start_date'])) {
            $query->whereDate('tanggal_site_plan', '>=', $this->filters['start_date']);
        }
        if (!empty($this->filters['end_date'])) {
            $query->whereDate('tanggal_site_plan', '<=', $this->filters['end_date']);
        }

        return $query->latest('created_at')->get();
    }

    /**
     * Menentukan nama-nama kolom header di file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
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

    /**
     * Memetakan data dari setiap model ke dalam array untuk setiap baris di Excel.
     *
     * @param mixed $siteplan
     * @return array
     */
    public function map($siteplan): array
    {
        return [
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
            $siteplan->nomor_site_plan,
            $siteplan->tanggal_site_plan ? Carbon::parse($siteplan->tanggal_site_plan)->format('d-m-Y') : '',
            $siteplan->nomor_bast_adm,
            $siteplan->tanggal_bast_adm ? Carbon::parse($siteplan->tanggal_bast_adm)->format('d-m-Y') : '',
            $siteplan->nomor_bast_fisik,
            $siteplan->tanggal_bast_fisik ? Carbon::parse($siteplan->tanggal_bast_fisik)->format('d-m-Y') : '',
            $siteplan->keterangan,
        ];
    }
}
