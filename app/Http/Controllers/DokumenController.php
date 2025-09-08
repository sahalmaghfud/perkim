<?php

namespace App\Http\Controllers;

use App\Models\bidang;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
        return view('dokumen.create', [
            'bidangList' => bidang::all()
        ]);
    }

    /**
     * Menyimpan dokumen baru ke dalam database.
     */
    // ... bagian atas controller sama ...

    public function store(Request $request)
    {
        // [PENYESUAIAN] Validasi tetap sama
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

        // [PENYESUAIAN] Logika baru untuk menyimpan file
        if ($request->hasFile('file_dokumen')) {
            // 1. Ambil file dari request
            $file = $request->file('file_dokumen');


            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            // 3. Ambil ekstensi file
            $extension = $file->getClientOriginalExtension();

            // 4. Buat nama baru (nama_asli + timestamp + ekstensi)
            $newFileName = $originalName . '_' . now()->format('Y-m-d_H-i-s') . '.' . $extension;


            // 4. Simpan file dengan nama baru menggunakan storeAs()
            //    Argumen: (path, nama_file_baru, disk)
            $path = $file->storeAs('dokumen-files', $newFileName, 'public');

            // 5. Simpan path ke database
            $validatedData['file_path'] = $path;
        }

        unset($validatedData['file_dokumen']);
        Dokumen::create($validatedData);

        $bidang = Bidang::find($validatedData['bidang_id']);
        $namaBidang = $bidang->nama_bidang; // Asumsikan kolom nama di tabel bidang adalah 'nama'


        // Redirect dengan pesan sukses yang menyertakan nama bidang
        return redirect()->route('dokumen.bidang', $namaBidang)
            ->with('success', "Dokumen berhasil ditambahkan ke {$namaBidang}!");
    }

    // ...

    /**
     * Menampilkan detail dari satu dokumen.
     */
    public function show(Dokumen $dokumen)
    {
        return view('dokumen.show', compact('dokumen'));
    }

    /**
     * Menampilkan form untuk mengedit dokumen.
     */
    public function edit(Dokumen $dokumen)
    {
        return view('dokumen.edit', [
            'dokumen' => $dokumen,
            'bidangList' => bidang::all()
        ]);
    }

    /**
     * Memperbarui data dokumen di dalam database.
     */
    public function update(Request $request, Dokumen $dokumen)
    {
        // Validasi tetap sama
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            // ... validasi lainnya ...
            'tanggal_surat' => 'nullable|date',
        ]);

        // [PENYESUAIAN] Logika baru untuk update file
        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama jika ada
            if ($dokumen->file_path) {
                Storage::disk('public')->delete($dokumen->file_path);
            }

            // 1. Ambil file dari request
            $file = $request->file('file_dokumen');

            // 2. Ambil nama asli file
            $originalName = $file->getClientOriginalName();

            // 3. Buat nama baru yang unik
            $newFileName = $originalName . '_' . now()->format('Y-m-d_H-i-s');

            // 4. Simpan file baru dengan nama kustom
            $path = $file->storeAs('dokumen-files', $newFileName, 'public');
            $validatedData['file_path'] = $path;
        }

        unset($validatedData['file_dokumen']);
        $dokumen->update($validatedData);

        $bidang = Bidang::find($validatedData['bidang_id']);
        $namaBidang = $bidang->nama_bidang; // Asumsikan kolom nama di tabel bidang adalah 'nama'

        // Redirect dengan pesan sukses yang menyertakan nama bidang
        return redirect()->route('dokumen.bidang', $namaBidang)
            ->with('success', "Dokumen berhasil edit");
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
