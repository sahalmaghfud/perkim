<?php

namespace App\Http\Controllers;

use App\Models\MasterAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use App\Models\Aset;

class MasterAsetController extends Controller
{
    /**
     * Menampilkan daftar semua aset.
     */
    public function index(Request $request)
    {
        // Mulai query builder
        $query = MasterAset::query();

        // 1. Terapkan filter pencarian jika ada input 'search'
        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->input('search');
            // Cari di kolom 'nama_barang' atau kolom relevan lainnya
            $q->where('nama_barang', 'like', "%{$search}%");
        });

        // 2. Terapkan filter jenis KIB jika ada input 'jenis_kib'
        $query->when($request->filled('jenis_kib'), function ($q) use ($request) {
            $q->where('jenis_kib', $request->input('jenis_kib'));
        });

        // 3. Terapkan filter tahun perolehan jika ada input 'tahun'
        $query->when($request->filled('tahun'), function ($q) use ($request) {
            $q->where('tahun_perolehan', $request->input('tahun'));
        });

        // Ambil data yang sudah difilter dan urutkan, lalu paginasi
        // Urutkan berdasarkan data terbaru
        $asets = $query->latest()->paginate(10);

        // Ambil opsi tahun unik untuk dropdown filter, diurutkan dari terbaru
        $tahunOptions = MasterAset::select('tahun_perolehan')
            ->distinct()
            ->orderBy('tahun_perolehan', 'desc')
            ->pluck('tahun_perolehan');

        // Kirim data ke view
        return view('asets.index', compact('asets', 'tahunOptions'));
    }

    /**
     * Menampilkan formulir untuk membuat aset baru.
     */
    public function create(): View
    {
        return view('asets.create', [
            'aset' => new MasterAset()
        ]);
    }

    /**
     * Menyimpan aset baru ke dalam database tanpa validasi.
     */
    public function store(Request $request): RedirectResponse
    {
        // Langsung ambil semua data dari request
        $data = $request->all();

        // Handle unggahan file foto jika ada
        if ($request->hasFile('foto_barang')) {
            $file = $request->file('foto_barang');

            // Membuat nama folder yang aman dari spasi/karakter aneh
            $folderKIB = Str::slug($request->input('jenis_kib', 'lainnya'));

            // Path direktori penyimpanan
            $directoryPath = "inventaris/{$folderKIB}";

            // Buat nama file yang unik untuk menghindari konflik
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $newFileName = Str::slug($originalName) . '_' . now()->format('Ymd_His') . '.' . $extension;

            // Simpan file ke direktori yang sudah ditentukan
            $path = $file->storeAs($directoryPath, $newFileName, 'public');

            // Simpan path file ke dalam data yang akan disimpan ke database
            $data['foto_barang'] = $path;
        }

        MasterAset::create($data);

        return redirect()->route('asets.index')
            ->with('success', 'Aset berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu aset.
     */
    public function show(MasterAset $aset): View
    {
        return view('asets.show', compact('aset'));
    }

    /**
     * Menampilkan formulir untuk mengedit aset.
     */
    public function edit(MasterAset $aset): View
    {
        return view('asets.edit', compact('aset'));
    }

    /**
     * Memperbarui data aset di database tanpa validasi.
     */
    public function update(Request $request, MasterAset $aset): RedirectResponse
    {
        $data = $request->all();

        // Handle jika ada foto baru yang diunggah
        if ($request->hasFile('foto_barang')) {
            // Hapus foto lama jika ada
            if ($aset->foto_barang) {
                Storage::disk('public')->delete($aset->foto_barang);
            }

            // Proses penyimpanan foto baru (sama seperti di method store)
            $file = $request->file('foto_barang');
            $folderKIB = Str::slug($request->input('jenis_kib', 'lainnya'));
            $directoryPath = "inventaris/{$folderKIB}";
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $newFileName = Str::slug($originalName) . '_' . now()->format('Ymd_His') . '.' . $extension;

            $path = $file->storeAs($directoryPath, $newFileName, 'public');
            $data['foto_barang'] = $path;
        }

        $aset->update($data);

        return redirect()->route('asets.index')
            ->with('success', 'Aset berhasil diperbarui.');
    }

    /**
     * Menghapus aset dari database.
     */
    public function destroy(MasterAset $aset): RedirectResponse
    {
        // Hapus file foto dari storage sebelum menghapus record
        if ($aset->foto_barang) {
            Storage::disk('public')->delete($aset->foto_barang);
        }

        $aset->delete();

        return redirect()->route('asets.index')
            ->with('success', 'Aset berhasil dihapus.');
    }
}
