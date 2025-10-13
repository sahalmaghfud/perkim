<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RumahTidakLayakHuni;

class MapController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data yang dibutuhkan dari database, disesuaikan dengan skema baru
        $allData = RumahTidakLayakHuni::select(
            'koordinat',
            'nama_kepala_ruta',
            'alamat',
            'kepemilikan_tanah', // Kolom baru yang relevan
            'kecamatan',
            'desa_kelurahan'
        )
            ->whereNotNull('koordinat')
            ->get();

        // 2. Data untuk marker peta
        $locations = $allData;

        // 3. Hitung rekapitulasi per kecamatan dan desa
        $rekapitulasi = $allData->groupBy('kecamatan')->map(function ($kecamatanItems, $namaKecamatan) {
            // Hitung total untuk kecamatan ini
            $totalKecamatan = $kecamatanItems->count();

            // Sekarang, kelompokkan data di dalam kecamatan ini berdasarkan desa
            $rekapDesa = $kecamatanItems->groupBy('desa_kelurahan')->map(function ($desaItems, $namaDesa) {
                return [
                    'nama' => $namaDesa,
                    'jumlah' => $desaItems->count()
                ];
            })->values(); // Reset keys untuk array desa

            return [
                'nama_kecamatan' => $namaKecamatan,
                'total' => $totalKecamatan,
                'desa' => $rekapDesa
            ];
        })->values(); // Reset keys untuk array kecamatan

        // 4. Kirim data ke view
        return view('map.index', compact('locations', 'rekapitulasi'));
    }
}
