<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule; // Import Rule untuk validasi unique yang lebih rapi

class DokumenController extends Controller
{
    /**
     * Menampilkan daftar semua dokumen dengan fungsionalitas pencarian dan filter.
     */
    public function index(Request $request)
    {
        // Memulai query dengan eager loading relasi 'divisi' untuk efisiensi
        $query = Dokumen::with('divisi')->latest();

        // [PERBAIKAN] Mengelompokkan query pencarian agar tidak bentrok dengan filter lain
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                    ->orWhere('kode_dokumen', 'like', '%' . $request->search . '%');
            });
        }

        // Logika untuk Filter berdasarkan Divisi
        if ($request->filled('divisi_id')) {
            $query->where('divisi_id', $request->divisi_id);
        }

        // Paginasi hasil query
        $daftarDokumen = $query->paginate(10);
        $divisi = Divisi::all();

        // Mengembalikan view dengan data yang diperlukan
        return view('dokumen.index', [
            'dokumens' => $daftarDokumen,
            'divisiList' => $divisi,
            'request' => $request
        ]);
    }

    /**
     * Menampilkan form untuk membuat dokumen baru.
     */
    public function create()
    {
        return view('dokumen.create', [
            'divisiList' => Divisi::all()
        ]);
    }

    /**
     * Menyimpan dokumen baru ke dalam database.
     */
    // DokumenController.php

    public function store(Request $request)
    {
        // Validasi biarkan saja seperti biasa
        $validatedData = $request->validate([
            'kode_dokumen' => 'nullable|string|max:255|unique:dokumens,kode_dokumen',
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tipe_dokumen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_terbit' => 'required|date',
            'divisi_id' => 'required|exists:divisis,id',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120',
        ]);

        // Kita akan debug di sini
        if ($request->hasFile('file_dokumen')) {

            // Coba simpan filenya
            $path = $request->file('file_dokumen')->store('dokumen-files', 'public');
            $validatedData['file_path'] = $path;
        }

        // Kode di bawah ini tidak akan dieksekusi karena ada dd() di atas
        Dokumen::create($validatedData);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil ditambahkan!');
    }

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
            'divisiList' => Divisi::all()
        ]);
    }

    /**
     * Memperbarui data dokumen di dalam database.
     */
    public function update(Request $request, Dokumen $dokumen)
    {
        // [PERBAIKAN] Menyesuaikan validasi untuk update
        $validatedData = $request->validate([
            // 'kode_dokumen' harus unik, kecuali untuk ID dokumen yang sedang diedit
            'kode_dokumen' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('dokumens')->ignore($dokumen->id),
            ],
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'tipe_dokumen' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_terbit' => 'required|date',
            'divisi_id' => 'required|exists:divisis,id',
            // File tidak wajib saat update, dan nama input disesuaikan
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120',
        ]);

        // [PERBAIKAN] Mengaktifkan dan memperbaiki logika update file
        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama jika ada
            if ($dokumen->file_path) {
                // Gunakan path lengkap 'public/...' untuk menghapus
                Storage::delete('public/' . $dokumen->file_path);
            }
            // Upload file baru
            $path = $request->file('file_dokumen')->store('public/dokumen');
            $validatedData['file_path'] = str_replace('public/', '', $path);
        }

        // Hapus key 'file_dokumen' karena tidak ada di tabel DB
        unset($validatedData['file_dokumen']);

        // [PERBAIKAN] Mengaktifkan logika update record
        $dokumen->update($validatedData);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    /**
     * Menghapus dokumen dari database.
     */
    public function destroy(Dokumen $dokumen)
    {
        // Hapus file terkait dari storage jika ada
        if ($dokumen->file_path) {
            Storage::delete('public/' . $dokumen->file_path);
        }

        // Hapus record dari database
        $dokumen->delete();

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus!');
    }

    /**
     * Menampilkan dokumen berdasarkan divisi.
     */
    public function showByDivisi(Request $request, $nama_divisi) // Inject Request di sini
    {
        // 1. Cari divisi berdasarkan nama dari URL. Ini menjadi konteks/default.
        $divisiTerpilih = Divisi::where('nama_divisi', $nama_divisi)->firstOrFail();

        // 2. Ambil data untuk mengisi dropdown filter di view
        $divisiList = Divisi::orderBy('nama_divisi')->get();
        // [BARU] Ambil daftar kategori unik dari semua dokumen
        $kategoriList = Dokumen::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        // 3. Mulai query builder
        $query = Dokumen::with('divisi')->latest();

        // 4. Terapkan filter berdasarkan request dari form
        //    (Ini akan menimpa filter default jika user memilih divisi lain di form)

        // Filter: Pencarian Teks (Judul atau Kode)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                    ->orWhere('kode_dokumen', 'like', '%' . $request->search . '%');
            });
        }

        // Filter: Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter: Divisi
        // Logika: Jika user memilih divisi di form, gunakan itu.
        // Jika tidak, gunakan divisi dari URL sebagai filter.
        if ($request->filled('divisi_id')) {
            $query->where('divisi_id', $request->divisi_id);
        } else {
            // Filter default berdasarkan divisi dari URL
            $query->where('divisi_id', $divisiTerpilih->id);
        }

        // 5. Eksekusi query dengan paginasi
        // withQueryString() penting agar filter tetap aktif saat pindah halaman
        $daftarDokumen = $query->paginate(10)->withQueryString();

        // 6. Kirim semua data yang diperlukan ke view
        return view('dokumen.index', [
            'dokumens' => $daftarDokumen,
            'divisiList' => $divisiList,
            'kategoriList' => $kategoriList, // Kirim daftar kategori
            'divisiTerpilih' => $divisiTerpilih, // Kirim divisi dari URL untuk konteks (judul, tombol, dll)
        ]);
    }
}
