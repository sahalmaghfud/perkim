<?php

namespace App\Http\Controllers;

use App\Exports\RumahTidakLayakHuniExport;
use App\Models\RumahTidakLayakHuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use App\Imports\RumahTidakLayakHuniImport;
use Maatwebsite\Excel\Validators\ValidationException;

class RumahTidakLayakHuniController extends Controller
{
    /**
     * Menampilkan daftar data dengan fitur pencarian dan filter.
     */
    public function index(Request $request)
    {
        // Ambil data unik untuk dropdown filter
        $kecamatans = RumahTidakLayakHuni::select('kecamatan')->whereNotNull('kecamatan')->distinct()->orderBy('kecamatan')->get();
        $desas = RumahTidakLayakHuni::select('desa_kelurahan')->whereNotNull('desa_kelurahan')->distinct()->orderBy('desa_kelurahan')->get();
        $kepemilikanTanahOptions = RumahTidakLayakHuni::select('kepemilikan_tanah')->whereNotNull('kepemilikan_tanah')->distinct()->orderBy('kepemilikan_tanah')->get();

        $query = RumahTidakLayakHuni::query();

        // Terapkan pencarian jika ada input 'search'
        $query->when($request->search, function ($q, $search) {
            return $q->where('nama_kepala_ruta', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%");
        });

        // Terapkan filter untuk kecamatan
        $query->when($request->kecamatan, function ($q, $kecamatan) {
            return $q->where('kecamatan', $kecamatan);
        });

        // Terapkan filter untuk desa/kelurahan
        $query->when($request->desa_kelurahan, function ($q, $desa) {
            return $q->where('desa_kelurahan', $desa);
        });

        // BARU: Terapkan filter untuk kepemilikan tanah
        $query->when($request->kepemilikan_tanah, function ($q, $kepemilikan) {
            return $q->where('kepemilikan_tanah', $kepemilikan);
        });

        $data = $query->latest()->paginate(10)->withQueryString(); // withQueryString() agar filter tetap ada saat pindah halaman

        // Kirim semua data yang diperlukan ke view
        return view('rtlh.index', compact('data', 'kecamatans', 'desas', 'kepemilikanTanahOptions'));
    }


    /**
     * Menampilkan form untuk membuat data baru.
     */
    public function create()
    {
        return view('rtlh.create');
    }

    /**
     * Menyimpan data baru ke dalam database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kepala_ruta' => 'required|string|max:255',
            'nik' => 'nullable|string|unique:rumah_tidak_layak_huni|max:16',
            'umur' => 'nullable|integer',
            'alamat' => 'nullable|string',
            'luas_rumah' => 'nullable|numeric',
            'kode_wilayah' => 'required|string',
            'kecamatan' => 'required|string',
            'desa_kelurahan' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'kepemilikan_tanah' => 'required|string',
            'no_sertifikat' => 'nullable|string',
            'kondisi_lantai' => 'nullable|string',
            'kondisi_dinding' => 'nullable|string',
            'kondisi_atap' => 'nullable|string',
            'sumber_air' => 'nullable|string',
            'sanitasi_wc' => 'nullable|string',
            'dapur' => 'nullable|string',
            'koordinat' => 'nullable|string',
            'foto_rumah' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kondisi_lantai' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kondisi_dinding' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kondisi_atap' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_sanitasi_wc' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kondisi_dapur' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $photoFields = [
            'foto_rumah',
            'foto_kondisi_lantai',
            'foto_kondisi_dinding',
            'foto_kondisi_atap',
            'foto_sanitasi_wc',
            'foto_kondisi_dapur'
        ];

        // Membuat nama folder berdasarkan nama dan NIK
        $folderNamePart = Str::slug($request->nama_kepala_ruta . '-' . ($request->nik ?? Str::random(5)));
        $uploadPath = 'RTLH/' . $folderNamePart . '/kondisi';

        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $fileName = $field . '-' . time() . '.' . $file->getClientOriginalExtension();
                // Simpan file ke path yang baru
                $path = $file->storeAs($uploadPath, $fileName, 'public');
                $validatedData[$field] = $path;
            }
        }

        RumahTidakLayakHuni::create($validatedData);

        return redirect()->route('rtlh.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Menampilkan satu data spesifik.
     */
    public function show(RumahTidakLayakHuni $rumahTidakLayakHuni)
    {
        return view('rtlh.show', compact('rumahTidakLayakHuni'));
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(RumahTidakLayakHuni $rumahTidakLayakHuni)
    {
        return view('rtlh.edit', compact('rumahTidakLayakHuni'));
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, RumahTidakLayakHuni $rumahTidakLayakHuni)
    {
        $validatedData = $request->validate([
            'nama_kepala_ruta' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16|unique:rumah_tidak_layak_huni,nik,' . $rumahTidakLayakHuni->id,
            'umur' => 'nullable|integer',
            'alamat' => 'nullable|string',
            'luas_rumah' => 'nullable|numeric',
            'kode_wilayah' => 'required|string',
            'kecamatan' => 'required|string',
            'desa_kelurahan' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'kepemilikan_tanah' => 'required|string',
            'no_sertifikat' => 'nullable|string',
            'kondisi_lantai' => 'nullable|string',
            'kondisi_dinding' => 'nullable|string',
            'kondisi_atap' => 'nullable|string',
            'sumber_air' => 'nullable|string',
            'sanitasi_wc' => 'nullable|string',
            'dapur' => 'nullable|string',
            'koordinat' => 'nullable|string',
            'foto_rumah' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kondisi_lantai' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kondisi_dinding' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kondisi_atap' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_sanitasi_wc' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_kondisi_dapur' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $photoFields = [
            'foto_rumah',
            'foto_kondisi_lantai',
            'foto_kondisi_dinding',
            'foto_kondisi_atap',
            'foto_sanitasi_wc',
            'foto_kondisi_dapur'
        ];

        // Membuat nama folder berdasarkan nama dan NIK
        $folderNamePart = Str::slug($request->nama_kepala_ruta . '-' . ($request->nik ?? $rumahTidakLayakHuni->id));
        $uploadPath = 'RTLH/' . $folderNamePart . '/kondisi';

        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                // Hapus foto lama jika ada
                if ($rumahTidakLayakHuni->{$field}) {
                    Storage::disk('public')->delete($rumahTidakLayakHuni->{$field});
                }
                // Simpan foto baru
                $file = $request->file($field);
                $fileName = $field . '-' . time() . '.' . $file->getClientOriginalExtension();
                // Simpan file ke path yang baru
                $path = $file->storeAs($uploadPath, $fileName, 'public');
                $validatedData[$field] = $path;
            }
        }

        $rumahTidakLayakHuni->update($validatedData);

        return redirect()->route('rtlh.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(RumahTidakLayakHuni $rumahTidakLayakHuni)
    {
        $photoFields = [
            'foto_rumah',
            'foto_kondisi_lantai',
            'foto_kondisi_dinding',
            'foto_kondisi_atap',
            'foto_sanitasi_wc',
            'foto_kondisi_dapur'
        ];

        foreach ($photoFields as $field) {
            if ($rumahTidakLayakHuni->{$field}) {
                Storage::disk('public')->delete($rumahTidakLayakHuni->{$field});
            }
        }

        $rumahTidakLayakHuni->delete();

        return redirect()->route('rtlh.index')->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Mengekspor data ke Excel.
     */
    public function export()
    {
        $fileName = 'data-rumah-tidak-layak-huni-' . date('Y-m-d') . '.xlsx';
        return Excel::download(new RumahTidakLayakHuniExport, $fileName);
    }



    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new RumahTidakLayakHuniImport, $request->file('file'));
            return redirect()->route('rtlh.index')->with('success', 'Data berhasil diimpor!');

        } catch (ValidationException $e) {
            $failures = $e->failures();
            $errorRows = [];
            foreach ($failures as $failure) {
                $errorRows[] = 'Baris ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }
            // Kirim kembali dengan input dan error agar modal bisa terbuka lagi
            return redirect()->route('rtlh.index')
                ->with('import_errors', $errorRows)
                ->withInput(); // withInput() penting untuk trigger di view

        } catch (\Exception $e) {
            return redirect()->route('rtlh.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

