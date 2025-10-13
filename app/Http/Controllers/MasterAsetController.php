<?php

namespace App\Http\Controllers;

use App\Models\MasterAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
class MasterAsetController extends Controller
{
    /**
     * Menampilkan daftar semua aset.
     */
    public function index(): View
    {
        $asets = MasterAset::latest()->paginate(10);
        return view('asets.index', compact('asets'));
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
