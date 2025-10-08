<?php

namespace App\Http\Controllers;

use App\Models\bidang;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DokumenController extends Controller
{
    /**
     * Menampilkan daftar semua dokumen dengan fungsionalitas pencarian dan filter.
     */
    public function index(Request $request)
    {
        // Memulai query dengan eager loading relasi 'bidang' untuk efisiensi
        $query = Dokumen::with('bidang')->latest();

        // [PENYESUAIAN] Mengelompokkan query pencarian dan menghapus pencarian berdasarkan 'kode_dokumen'
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                // Pencarian hanya berdasarkan 'judul' karena 'kode_dokumen' sudah tidak ada
                $q->where('judul', 'like', '%' . $request->search . '%');
            });
        }

        // Logika untuk Filter berdasarkan bidang
        if ($request->filled('bidang_id')) {
            $query->where('bidang_id', $request->bidang_id);
        }

        // Paginasi hasil query
        $daftarDokumen = $query->paginate(10);
        $bidang = bidang::all();

        // Mengembalikan view dengan data yang diperlukan
        return view('dokumen.index', [
            'dokumens' => $daftarDokumen,
            'bidangList' => $bidang,
            'request' => $request
        ]);
    }

    /**
     * Menampilkan form untuk membuat dokumen baru.
     */
    public function create()
    {
        $kategoriList = Dokumen::select('kategori')->whereNotNull('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        return view('dokumen.create', [
            'bidangList' => bidang::all(),
            'kategoriList' => $kategoriList
        ]);
    }

    /**
     * Menyimpan dokumen baru ke dalam database.
     */
    // ... bagian atas controller sama ...

    public function store(Request $request)
    {
        // 1. Validasi input (tetap sama)
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tipe_dokumen' => 'required|in:dokumen,surat',
            'bidang_id' => 'required|exists:bidang,id',
            'tanggal' => 'required|date',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120',
            'deskripsi' => 'nullable|string',
            'nomor_surat' => 'nullable|string|max:255',
            'pengirim' => 'nullable|string|max:255',
            'penerima' => 'nullable|string|max:255',
            'perihal' => 'nullable|string',
            'lampiran' => 'nullable|integer',
            'tanggal_surat' => 'nullable|date',
        ]);

        // 2. Logika baru untuk menangani dan menyimpan file
        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');

            // --- PERUBAHAN DIMULAI DI SINI ---

            // Ambil informasi yang diperlukan untuk path folder
            $bidang = Bidang::find($validatedData['bidang_id']);
            $namaBidangFolder = Str::slug($bidang->nama_bidang); // Membuat nama folder yang aman dari spasi/karakter aneh
            $bulanTahunFolder = Carbon::parse($validatedData['tanggal'])->format('m-Y'); // Format: bulan-tahun, cth: 10-2025

            // Gabungkan menjadi path direktori yang diinginkan
            $directoryPath = "dokumen-files/{$namaBidangFolder}/{$bulanTahunFolder}";

            // Buat nama file yang unik (sama seperti sebelumnya)
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $newFileName = $originalName . '_' . now()->format('Ymd_His') . '.' . $extension;

            // Simpan file ke direktori baru
            $path = $file->storeAs($directoryPath, $newFileName, 'public');

            $validatedData['file_path'] = $path;
        }

        // 3. Buang key 'file_dokumen' dan simpan data ke database
        unset($validatedData['file_dokumen']);
        Dokumen::create($validatedData);

        // 4. Redirect dengan pesan sukses
        $bidang = Bidang::find($validatedData['bidang_id']);
        $namaBidang = $bidang->nama_bidang;

        return redirect()->route('dokumen.bidang', $namaBidang)
            ->with('success', "Dokumen berhasil ditambahkan ke {$namaBidang}!");
    }

    // ...

    /**
     * Menampilkan detail dari satu dokumen.
     */
    public function show(Dokumen $dokumen)
    {
        return view('pegawai.show', compact('dokumen'));
    }

    /**
     * Menampilkan form untuk mengedit dokumen.
     */
    public function edit(Dokumen $dokumen)
    {
        $kategoriList = Dokumen::select('kategori')->whereNotNull('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        return view('dokumen.edit', [
            'dokumen' => $dokumen,
            'bidangList' => bidang::all(),
            'kategoriList' => $kategoriList
        ]);
    }

    /**
     * Memperbarui data dokumen di dalam database.
     */
    public function update(Request $request, Dokumen $dokumen)
    {
        // 1. Validasi input
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tipe_dokumen' => 'required|in:dokumen,surat',
            'bidang_id' => 'required|exists:bidang,id',
            'tanggal' => 'required|date',
            // File bersifat opsional saat update
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120',
            'deskripsi' => 'nullable|string',
            'nomor_surat' => 'nullable|string|max:255',
            'pengirim' => 'nullable|string|max:255',
            'penerima' => 'nullable|string|max:255',
            'perihal' => 'nullable|string',
            'lampiran' => 'nullable|integer',
            'tanggal_surat' => 'nullable|date',
        ]);

        // 2. Logika untuk mengganti file jika ada file baru yang di-upload
        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama dari storage untuk menghemat ruang
            if ($dokumen->file_path) {
                Storage::disk('public')->delete($dokumen->file_path);
            }

            // --- PERUBAHAN DIMULAI DI SINI ---
            $file = $request->file('file_dokumen');

            // Ambil informasi untuk path dari data yang BARU divalidasi
            $bidang = Bidang::find($validatedData['bidang_id']);
            $namaBidangFolder = Str::slug($bidang->nama_bidang);
            $bulanTahunFolder = Carbon::parse($validatedData['tanggal'])->format('m-Y');

            // Siapkan path direktori yang baru
            $directoryPath = "dokumen-files/{$namaBidangFolder}/{$bulanTahunFolder}";

            // Buat nama file unik (dengan ekstensi yang benar)
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $newFileName = $originalName . '_' . now()->format('Ymd_His') . '.' . $extension;

            // Simpan file baru ke direktori yang benar
            $path = $file->storeAs($directoryPath, $newFileName, 'public');

            // Simpan path baru untuk di-update ke database
            $validatedData['file_path'] = $path;
            // --- AKHIR DARI PERUBAHAN ---
        }

        // 3. Update data di database
        $dokumen->update($validatedData);

        // 4. Redirect ke halaman yang sesuai dengan pesan sukses
        // Ambil nama bidang yang mungkin juga baru diubah
        $namaBidang = $dokumen->bidang->nama_bidang;

        return redirect()->route('dokumen.bidang', $namaBidang)
            ->with('success', 'Dokumen berhasil diupdate!');
    }

    /**
     * Menghapus dokumen dari database.
     */
    public function destroy(Dokumen $dokumen)
    {
        // Hapus file terkait dari storage jika ada
        if ($dokumen->file_path) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        // Hapus record dari database
        $dokumen->delete();

        $bidang = Bidang::find($dokumen['bidang_id']);
        $namaBidang = $bidang->nama_bidang;

        // Redirect dengan pesan sukses yang menyertakan nama bidang
        return redirect()->route('dokumen.bidang', $namaBidang)
            ->with('success', "Dokumen berhasil dihapus!");
    }

    /**
     * Menampilkan dokumen berdasarkan bidang.
     */
    public function showBybidang(Request $request, $nama_bidang)
    {
        $bidangTerpilih = bidang::where('nama_bidang', $nama_bidang)->firstOrFail();
        $bidangList = bidang::orderBy('nama_bidang')->get();
        $kategoriList = Dokumen::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        $query = Dokumen::with('bidang')->latest();

        // [PENYESUAIAN] Menghapus pencarian berdasarkan 'kode_dokumen'
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('bidang_id')) {
            $query->where('bidang_id', $request->bidang_id);
        } else {
            $query->where('bidang_id', $bidangTerpilih->id);
        }

        $daftarDokumen = $query->paginate(10)->withQueryString();

        return view('dokumen.index', [
            'dokumens' => $daftarDokumen,
            'bidangList' => $bidangList,
            'kategoriList' => $kategoriList,
            'bidangTerpilih' => $bidangTerpilih,
        ]);
    }
}
