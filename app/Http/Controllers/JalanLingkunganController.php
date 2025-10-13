<?php

namespace App\Http\Controllers;

use App\Exports\JalanLingkunganExport;
use App\Models\Cv;
use App\Models\JalanLingkungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Ditambahkan untuk mengelola file
use Illuminate\Support\Str; // Ditambahkan untuk helper slug
use Maatwebsite\Excel\Facades\Excel;

class JalanLingkunganController extends Controller
{

    public function index(Request $request)
    {
        $query = JalanLingkungan::with('cv');

        // Terapkan filter kecamatan jika ada
        $query->when($request->kecamatan, function ($q, $kecamatan) {
            return $q->where('kecamatan', $kecamatan);
        });

        // Terapkan filter desa jika ada
        $query->when($request->desa, function ($q, $desa) {
            return $q->where('desa', $desa);
        });

        // Terapkan filter tahun berdasarkan tanggal awal pekerjaan
        $query->when($request->tahun, function ($q, $tahun) {
            return $q->whereYear('tanggal_awal_pekerjaan', $tahun);
        });

        // withQueryString() digunakan agar parameter filter tidak hilang saat pindah halaman
        $jalanLingkungans = $query->latest()->paginate(10)->withQueryString();

        // Mengambil data unik untuk dropdown filter
        $kecamatans = JalanLingkungan::query()->select('kecamatan')->whereNotNull('kecamatan')->distinct()->orderBy('kecamatan')->get();
        $desas = JalanLingkungan::query()->select('desa')->whereNotNull('desa')->distinct()->orderBy('desa')->get();
        $tahuns = JalanLingkungan::query()->selectRaw('YEAR(tanggal_awal_pekerjaan) as tahun')->whereNotNull('tanggal_awal_pekerjaan')->distinct()->orderBy('tahun', 'desc')->get();

        return view('jalan_lingkungan.index', compact('jalanLingkungans', 'kecamatans', 'desas', 'tahuns'));
    }

    /**
     * Menampilkan formulir untuk membuat data baru.
     */
    public function create()
    {
        $cvs = Cv::all();
        return view('jalan_lingkungan.create', compact('cvs'));
    }

    /**
     * Menyimpan data baru ke dalam database, termasuk file.
     */
    public function store(Request $request)
    {
        // Validasi input dari form, termasuk file
        $validatedData = $request->validate([
            'cv_id' => 'required|exists:cv,id',
            'uraian' => 'required|string',
            'kecamatan' => 'nullable|string|max:255',
            'desa' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'volume' => 'nullable|numeric',
            'satuan' => 'nullable|string|max:255',
            'harga_satuan' => 'nullable|numeric',
            'jumlah_harga' => 'nullable|numeric',
            'nomor_kontrak' => 'nullable|string|max:255|',
            'tanggal_kontrak' => 'nullable|date',
            'tanggal_awal_pekerjaan' => 'nullable|date',
            'tanggal_akhir_pekerjaan' => 'nullable|date|after_or_equal:tanggal_awal_pekerjaan',
            'nilai_kontrak' => 'nullable|numeric',
            'baphp_nomor' => 'nullable|string|max:255',
            'baphp_tanggal' => 'nullable|date',
            'bast_nomor' => 'nullable|string|max:255',
            'bast_tanggal' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'foto_sebelum' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_sesudah' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Pencairan 30%
            'no_spm_30' => 'nullable|string|max:255',
            'no_sp2d_30' => 'nullable|string|max:255',
            'tanggal_30' => 'nullable|date',
            'nilai_30' => 'nullable|numeric',
            'ppn_30' => 'nullable|numeric',
            'pph_30' => 'nullable|numeric',
            'total_30' => 'nullable|numeric',

            // Pencairan 95%
            'no_spm_95' => 'nullable|string|max:255',
            'no_sp2d_95' => 'nullable|string|max:255',
            'tanggal_95' => 'nullable|date',
            'nilai_95' => 'nullable|numeric',
            'ppn_95' => 'nullable|numeric',
            'pph_95' => 'nullable|numeric',
            'total_95' => 'nullable|numeric',

            // Pencairan 100%
            'no_spm_100' => 'nullable|string|max:255',
            'no_sp2d_100' => 'nullable|string|max:255',
            'tanggal_100' => 'nullable|date',
            'nilai_100' => 'nullable|numeric',
            'ppn_100' => 'nullable|numeric',
            'pph_100' => 'nullable|numeric',
            'total_100' => 'nullable|numeric',
        ]);

        // Membuat slug dari uraian untuk nama folder
        $uraianSlug = Str::slug($validatedData['uraian']);

        // Handle upload 'foto_sebelum' jika ada
        if ($request->hasFile('foto_sebelum')) {
            $file = $request->file('foto_sebelum');
            $fileName = 'foto-sebelum.' . $file->getClientOriginalExtension();
            // Simpan file dengan path dan nama kustom
            $path = $file->storeAs("jalan-lingkungan/{$uraianSlug}", $fileName, 'public');
            $validatedData['foto_sebelum'] = $path;
        }

        // Handle upload 'foto_sesudah' jika ada
        if ($request->hasFile('foto_sesudah')) {
            $file = $request->file('foto_sesudah');
            $fileName = 'foto-sesudah.' . $file->getClientOriginalExtension();
            // Simpan file dengan path dan nama kustom
            $path = $file->storeAs("jalan-lingkungan/{$uraianSlug}", $fileName, 'public');
            $validatedData['foto_sesudah'] = $path;
        }

        // Membuat data baru
        JalanLingkungan::create($validatedData);

        return redirect()->route('jalan_lingkungan.index')
            ->with('success', 'Data Jalan Lingkungan berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu data jalan lingkungan.
     */
    public function show(JalanLingkungan $jalanLingkungan)
    {
        return view('jalan_lingkungan.show', compact('jalanLingkungan'));
    }

    /**
     * Menampilkan formulir untuk mengedit data.
     */
    public function edit(JalanLingkungan $jalanLingkungan)
    {
        $cvs = Cv::all();
        return view('jalan_lingkungan.edit', compact('jalanLingkungan', 'cvs'));
    }

    /**
     * Memperbarui data yang ada di database, termasuk file.
     */
    public function update(Request $request, JalanLingkungan $jalanLingkungan)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'cv_id' => 'required|exists:cv,id',
            'uraian' => 'required|string',
            'kecamatan' => 'nullable|string|max:255',
            'desa' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'volume' => 'nullable|numeric',
            'satuan' => 'nullable|string|max:255',
            'harga_satuan' => 'nullable|numeric',
            'jumlah_harga' => 'nullable|numeric',
            'nomor_kontrak' => 'nullable|string|max:255|',
            'tanggal_kontrak' => 'nullable|date',
            'tanggal_awal_pekerjaan' => 'nullable|date',
            'tanggal_akhir_pekerjaan' => 'nullable|date|after_or_equal:tanggal_awal_pekerjaan',
            'nilai_kontrak' => 'nullable|numeric',
            'baphp_nomor' => 'nullable|string|max:255',
            'baphp_tanggal' => 'nullable|date',
            'bast_nomor' => 'nullable|string|max:255',
            'bast_tanggal' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'foto_sebelum' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'foto_sesudah' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Pencairan 30%
            'no_spm_30' => 'nullable|string|max:255',
            'no_sp2d_30' => 'nullable|string|max:255',
            'tanggal_30' => 'nullable|date',
            'nilai_30' => 'nullable|numeric',
            'ppn_30' => 'nullable|numeric',
            'pph_30' => 'nullable|numeric',
            'total_30' => 'nullable|numeric',

            // Pencairan 95%
            'no_spm_95' => 'nullable|string|max:255',
            'no_sp2d_95' => 'nullable|string|max:255',
            'tanggal_95' => 'nullable|date',
            'nilai_95' => 'nullable|numeric',
            'ppn_95' => 'nullable|numeric',
            'pph_95' => 'nullable|numeric',
            'total_95' => 'nullable|numeric',

            // Pencairan 100%
            'no_spm_100' => 'nullable|string|max:255',
            'no_sp2d_100' => 'nullable|string|max:255',
            'tanggal_100' => 'nullable|date',
            'nilai_100' => 'nullable|numeric',
            'ppn_100' => 'nullable|numeric',
            'pph_100' => 'nullable|numeric',
            'total_100' => 'nullable|numeric',
        ]);

        $newUraianSlug = Str::slug($validatedData['uraian']);
        $originalUraianSlug = Str::slug($jalanLingkungan->uraian);
        $uraianHasChanged = $newUraianSlug !== $originalUraianSlug;
        $updateData = $validatedData;

        // Handle 'foto_sebelum'
        if ($request->hasFile('foto_sebelum')) {
            if ($jalanLingkungan->foto_sebelum)
                Storage::disk('public')->delete($jalanLingkungan->foto_sebelum);
            $file = $request->file('foto_sebelum');
            $fileName = 'foto-sebelum.' . $file->getClientOriginalExtension();
            $path = $file->storeAs("jalan-lingkungan/{$newUraianSlug}", $fileName, 'public');
            $updateData['foto_sebelum'] = $path;
        } elseif ($uraianHasChanged && $jalanLingkungan->foto_sebelum) {
            $oldPath = $jalanLingkungan->foto_sebelum;
            $fileName = basename($oldPath);
            $newPath = "jalan-lingkungan/{$newUraianSlug}/{$fileName}";
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->move($oldPath, $newPath);
                $updateData['foto_sebelum'] = $newPath;
            }
        }

        // Handle 'foto_sesudah'
        if ($request->hasFile('foto_sesudah')) {
            if ($jalanLingkungan->foto_sesudah)
                Storage::disk('public')->delete($jalanLingkungan->foto_sesudah);
            $file = $request->file('foto_sesudah');
            $fileName = 'foto-sesudah.' . $file->getClientOriginalExtension();
            $path = $file->storeAs("jalan-lingkungan/{$newUraianSlug}", $fileName, 'public');
            $updateData['foto_sesudah'] = $path;
        } elseif ($uraianHasChanged && $jalanLingkungan->foto_sesudah) {
            $oldPath = $jalanLingkungan->foto_sesudah;
            $fileName = basename($oldPath);
            $newPath = "jalan-lingkungan/{$newUraianSlug}/{$fileName}";
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->move($oldPath, $newPath);
                $updateData['foto_sesudah'] = $newPath;
            }
        }

        // Memperbarui data
        $jalanLingkungan->update($updateData);

        // Hapus direktori lama jika 'uraian' berubah dan direktori sudah kosong
        if ($uraianHasChanged) {
            $oldDirectory = "jalan-lingkungan/{$originalUraianSlug}";
            if (Storage::disk('public')->exists($oldDirectory) && count(Storage::disk('public')->files($oldDirectory)) === 0) {
                Storage::disk('public')->deleteDirectory($oldDirectory);
            }
        }

        return redirect()->route('jalan_lingkungan.index')
            ->with('success', 'Data Jalan Lingkungan berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database, termasuk file terkait.
     */
    public function destroy(JalanLingkungan $jalanLingkungan)
    {
        // Hapus file 'foto_sebelum' dari storage jika ada
        if ($jalanLingkungan->foto_sebelum) {
            Storage::disk('public')->delete($jalanLingkungan->foto_sebelum);
        }

        // Hapus file 'foto_sesudah' dari storage jika ada
        if ($jalanLingkungan->foto_sesudah) {
            Storage::disk('public')->delete($jalanLingkungan->foto_sesudah);
        }

        // Menghapus data dari database
        $jalanLingkungan->delete();

        return redirect()->route('jalan_lingkungan.index')
            ->with('success', 'Data Jalan Lingkungan berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $filters = $request->all();
        $fileName = 'laporan-jalan-lingkungan-' . date('Y-m-d-His') . '.xlsx';
        return Excel::download(new JalanLingkunganExport($filters), $fileName);
    }
}

