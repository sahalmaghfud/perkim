<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\JalanLingkungan;
use App\Models\Pegawai;
use App\Models\Siteplan;
use App\Models\RumahTidakLayakHuni;
use App\Models\Bidang;
use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        // ========================================
        // 1. RINGKASAN UMUM (Overview Cards)
        // ========================================
        $overview = [
            'total_pegawai' => Pegawai::count(),
            'total_bidang' => Bidang::count(),
            'total_dokumen' => Dokumen::count(),
            'total_cv' => Cv::count(),
            'total_siteplan' => Siteplan::count(),
            'total_rtlh' => RumahTidakLayakHuni::count(),
            'total_jalan' => JalanLingkungan::count(),
        ];

        // ========================================
        // 2. PEGAWAI & BIDANG
        // ========================================

        // Distribusi pegawai per bidang (untuk Pie Chart)
        $pegawaiPerBidang = Pegawai::select('bidang.nama_bidang', DB::raw('COUNT(pegawai.id) as jumlah_pegawai'))
            ->join('bidang', 'pegawai.bidang_id', '=', 'bidang.id')
            ->groupBy('bidang.nama_bidang')
            ->get();

        // ========================================
        // 3. DOKUMEN & SURAT
        // ========================================

        // Jumlah dokumen per bidang (untuk Bar/Pie Chart)
        $dokumenPerBidang = Dokumen::select('bidang.nama_bidang', DB::raw('COUNT(dokumens.id) as total'))
            ->join('bidang', 'dokumens.bidang_id', '=', 'bidang.id')
            ->groupBy('bidang.nama_bidang')
            ->get();

        // Dokumen terbaru (untuk Tabel)
        $dokumenTerbaru = Dokumen::with('bidang')
            ->latest()
            ->take(10)
            ->get(['id', 'judul', 'tipe_dokumen', 'kategori', 'bidang_id', 'tanggal', 'created_at', 'file_path']);

        // ========================================
        // 4. RUMAH TIDAK LAYAK HUNI (RTLH)
        // ========================================

        // Status perbaikan (untuk Donut Chart)
        $rtlhStatus = RumahTidakLayakHuni::select('status', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('status')
            ->get();

        // RTLH per kecamatan (untuk Bar Chart)
        $rtlhPerKecamatan = RumahTidakLayakHuni::select('kecamatan', DB::raw('COUNT(*) as total'))
            ->groupBy('kecamatan')
            ->orderBy('total', 'desc')
            ->get();

        // ========================================
        // 5. PROYEK JALAN LINGKUNGAN
        // ========================================

        // Data kontrak terbaru (untuk Tabel)
        $kontrakTerbaru = JalanLingkungan::with('cv')
            ->latest('tanggal_kontrak')
            ->take(10)
            ->get(['id', 'cv_id', 'nomor_kontrak', 'nilai_kontrak', 'tanggal_kontrak', 'uraian']);

        // ========================================
        // 6. SITEPLAN PERUMAHAN
        // ========================================

        // Siteplan per Kecamatan (untuk Bar Chart) - DITAMBAHKAN
        $siteplanPerKecamatan = Siteplan::select('kecamatan', DB::raw('COUNT(*) as total'))
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->orderBy('total', 'desc')
            ->get();

        // Siteplan terbaru (untuk Tabel)
        $siteplanTerbaru = Siteplan::latest()
            ->take(10)
            ->get(['id', 'nama_pt', 'nama', 'luas_lahan_perumahan', 'tahun', 'kecamatan', 'created_at']);

        // ========================================
        // RETURN DATA KE VIEW
        // ========================================
        return view('dashboard', compact(
            // Overview
            'overview',

            // Pegawai
            'pegawaiPerBidang',

            // Dokumen
            'dokumenPerBidang',
            'dokumenTerbaru',

            // RTLH
            'rtlhStatus',
            'rtlhPerKecamatan',

            // Jalan Lingkungan
            'kontrakTerbaru',

            // Siteplan
            'siteplanPerKecamatan', // DITAMBAHKAN
            'siteplanTerbaru'
        ));
    }
}
