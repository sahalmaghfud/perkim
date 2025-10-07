<?php

namespace App\Http\Controllers;

use App\Exports\JalanLingkunganExport;
use App\Models\Cv;
use App\Models\JalanLingkungan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class JalanLingkunganController extends Controller
{

    public function index(Request $request)
    {
        $query = JalanLingkungan::with('cv');

        // Terapkan pencarian jika ada input 'search'
        $query->when($request->search, function ($q, $search) {
            return $q->where('uraian', 'like', "%{$search}%")
                ->orWhere('nomor_kontrak', 'like', "%{$search}%")
                ->orWhereHas('cv', function ($query) use ($search) {
                    $query->where('nama_cv', 'like', "%{$search}%");
                });
        });

        // Terapkan filter jika ada input 'cv_id'
        $query->when($request->cv_id, function ($q, $cv_id) {
            return $q->where('cv_id', $cv_id);
        });

        // withQueryString() digunakan agar parameter search/filter tidak hilang saat pindah halaman
        $jalanLingkungans = $query->latest()->paginate(10)->withQueryString();
        $cvs = Cv::all();

        return view('jalan_lingkungan.index', compact('jalanLingkungans', 'cvs'));
    }

    /**
     * Menampilkan formulir untuk membuat data baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Mengambil semua data CV untuk ditampilkan di dropdown
        $cvs = Cv::all();
        return view('jalan_lingkungan.create', compact('cvs'));
    }

    /**
     * Menyimpan data baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'cv_id' => 'required|exists:cv,id',
            'uraian' => 'required|string',
            'volume' => 'nullable|numeric',
            'satuan' => 'nullable|string|max:255',
            'harga_satuan' => 'nullable|numeric',
            'jumlah_harga' => 'nullable|numeric',
            'nomor_kontrak' => 'nullable|string|max:255|unique:jalan_lingkungan,nomor_kontrak',
            'tanggal_kontrak' => 'nullable|date',
            'tanggal_awal_pekerjaan' => 'nullable|date',
            'tanggal_akhir_pekerjaan' => 'nullable|date|after_or_equal:tanggal_awal_pekerjaan',
            'nilai_kontrak' => 'nullable|numeric',
            'no_spm_30' => 'nullable|string|max:255',
            'no_sp2d_30' => 'nullable|string|max:255',
            'tanggal_30' => 'nullable|date',
            'nilai_30' => 'nullable|numeric',
            'ppn_30' => 'nullable|numeric',
            'pph_30' => 'nullable|numeric',
            'total_30' => 'nullable|numeric',
            'no_spm_95' => 'nullable|string|max:255',
            'no_sp2d_95' => 'nullable|string|max:255',
            'tanggal_95' => 'nullable|date',
            'nilai_95' => 'nullable|numeric',
            'ppn_95' => 'nullable|numeric',
            'pph_95' => 'nullable|numeric',
            'total_95' => 'nullable|numeric',
            'no_spm_100' => 'nullable|string|max:255',
            'no_sp2d_100' => 'nullable|string|max:255',
            'tanggal_100' => 'nullable|date',
            'nilai_100' => 'nullable|numeric',
            'ppn_100' => 'nullable|numeric',
            'pph_100' => 'nullable|numeric',
            'total_100' => 'nullable|numeric',
            'baphp_nomor' => 'nullable|string|max:255',
            'baphp_tanggal' => 'nullable|date',
            'bast_nomor' => 'nullable|string|max:255',
            'bast_tanggal' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        // Membuat data baru
        JalanLingkungan::create($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('jalan_lingkungan.index')
            ->with('success', 'Data Jalan Lingkungan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu data jalan lingkungan.
     *
     * @param  \App\Models\JalanLingkungan  $jalanLingkungan
     * @return \Illuminate\View\View
     */
    public function show(JalanLingkungan $jalanLingkungan)
    {
        return view('jalan_lingkungan.show', compact('jalanLingkungan'));
    }

    /**
     * Menampilkan formulir untuk mengedit data.
     *
     * @param  \App\Models\JalanLingkungan  $jalanLingkungan
     * @return \Illuminate\View\View
     */
    public function edit(JalanLingkungan $jalanLingkungan)
    {
        $cvs = Cv::all();
        return view('jalan_lingkungan.edit', compact('jalanLingkungan', 'cvs'));
    }

    /**
     * Memperbarui data yang ada di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JalanLingkungan  $jalanLingkungan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, JalanLingkungan $jalanLingkungan)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'uraian' => 'required|string',
            'volume' => 'nullable|numeric',
            'satuan' => 'nullable|string|max:255',
            'harga_satuan' => 'nullable|numeric',
            'jumlah_harga' => 'nullable|numeric',
            'nomor_kontrak' => 'nullable|string|max:255|unique:jalan_lingkungan,nomor_kontrak,' . $jalanLingkungan->id,
            'tanggal_kontrak' => 'nullable|date',
            'tanggal_awal_pekerjaan' => 'nullable|date',
            'tanggal_akhir_pekerjaan' => 'nullable|date|after_or_equal:tanggal_awal_pekerjaan',
            'nilai_kontrak' => 'nullable|numeric',
            'no_spm_30' => 'nullable|string|max:255',
            'no_sp2d_30' => 'nullable|string|max:255',
            'tanggal_30' => 'nullable|date',
            'nilai_30' => 'nullable|numeric',
            'ppn_30' => 'nullable|numeric',
            'pph_30' => 'nullable|numeric',
            'total_30' => 'nullable|numeric',
            'no_spm_95' => 'nullable|string|max:255',
            'no_sp2d_95' => 'nullable|string|max:255',
            'tanggal_95' => 'nullable|date',
            'nilai_95' => 'nullable|numeric',
            'ppn_95' => 'nullable|numeric',
            'pph_95' => 'nullable|numeric',
            'total_95' => 'nullable|numeric',
            'no_spm_100' => 'nullable|string|max:255',
            'no_sp2d_100' => 'nullable|string|max:255',
            'tanggal_100' => 'nullable|date',
            'nilai_100' => 'nullable|numeric',
            'ppn_100' => 'nullable|numeric',
            'pph_100' => 'nullable|numeric',
            'total_100' => 'nullable|numeric',
            'baphp_nomor' => 'nullable|string|max:255',
            'baphp_tanggal' => 'nullable|date',
            'bast_nomor' => 'nullable|string|max:255',
            'bast_tanggal' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        // Memperbarui data
        $jalanLingkungan->update($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('jalan_lingkungan.index')
            ->with('success', 'Data Jalan Lingkungan berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     *
     * @param  \App\Models\JalanLingkungan  $jalanLingkungan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(JalanLingkungan $jalanLingkungan)
    {
        // Menghapus data
        $jalanLingkungan->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('jalan_lingkungan.index')
            ->with('success', 'Data Jalan Lingkungan berhasil dihapus.');
    }

    public function export(Request $request)
    {
        // 1. Mengambil semua parameter dari request untuk digunakan sebagai filter.
        //    Contohnya: /export?search=proyek&cv_id=5
        $filters = $request->all();

        // 2. Membuat nama file yang dinamis, menyertakan tanggal ekspor.
        $fileName = 'laporan-jalan-lingkungan-' . date('Y-m-d-His') . '.xlsx';

        // 3. Memanggil class LaporanKontrakExport, meneruskan filter, dan memulai unduhan.
        //    Maatwebsite/Excel akan menangani pembuatan file dan mengirimkannya ke browser.
        return Excel::download(new JalanLingkunganExport($filters), $fileName);
    }









}


