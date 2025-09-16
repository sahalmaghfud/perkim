<?php

namespace App\Http\Controllers;

use App\Exports\SiteplanExport;
use App\Models\Siteplan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiteplanImport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


// Import Rule class

class SiteplanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil data terbaru dengan paginasi 10 item per halaman
        $siteplans = Siteplan::latest()->paginate(10);
        return view('siteplans.index', compact('siteplans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('siteplans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Menentukan aturan validasi untuk semua field
        $rules = [
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'luas_lahan_per_unit' => 'nullable|string|max:255',
            'luas_lahan_perumahan' => 'nullable|numeric|min:0',
            'luas_psu' => 'nullable|numeric|min:0',
            'panjang_prasarana_jalan' => 'nullable|numeric|min:0',
            'lebar_prasarana_jalan' => 'nullable|numeric|min:0',
            'luas_prasarana_jalan' => 'nullable|numeric|min:0',
            'luas_prasarana_drainase' => 'nullable|numeric|min:0',
            'luas_prasarana_rth' => 'nullable|numeric|min:0',
            'luas_prasarana_tps' => 'nullable|numeric|min:0',
            'luas_sarana_pemakaman' => 'nullable|numeric|min:0',
            'luas_sarana_olahraga_dll' => 'nullable|numeric|min:0',
            'panjang_utilitas' => 'nullable|string|max:255',
            'sumber_air_bersih' => 'nullable|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'nama_pt' => 'required|string|max:255',
            'jumlah_unit_rumah' => 'nullable|integer|min:0',
            'tahun' => 'nullable|digits:4|integer|min:1900',
            'alamat' => 'nullable|string',
            'kecamatan' => 'nullable|string|max:255',
            'desa' => 'nullable|string|max:255',
            'nomor_site_plan' => 'nullable|string|max:255|unique:siteplans,nomor_site_plan',
            'tanggal_site_plan' => 'nullable|date',
            'nomor_bast_adm' => 'nullable|string|max:255',
            'tanggal_bast_adm' => 'nullable|date',
            'nomor_bast_fisik' => 'nullable|string|max:255',
            'tanggal_bast_fisik' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ];

        // Menjalankan validasi
        $validatedData = $request->validate($rules);

        // --- Proses Upload File ---
        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $namaPerumahan = $request->input('nama');
            // Membuat nama file yang aman dari nama perumahan + timestamp agar unik
            $fileName = Str::slug($namaPerumahan) . '_' . time() . '.' . $file->getClientOriginalExtension();
            // Simpan file dengan nama baru
            $path = $file->storeAs('siteplans', $fileName, 'public');
            $validatedData['file_path'] = $path;
        }

        // Membuat data baru dengan data yang sudah divalidasi (termasuk path file jika ada)
        Siteplan::create($validatedData);

        return redirect()->route('siteplans.index')
            ->with('success', 'Data siteplan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siteplan $siteplan)
    {
        return view('siteplans.show', compact('siteplan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siteplan $siteplan)
    {
        return view('siteplans.edit', compact('siteplan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siteplan $siteplan)
    {
        // Menentukan aturan validasi untuk semua field saat update
        $rules = [
            'nama' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'luas_lahan_per_unit' => 'nullable|string|max:255',
            'luas_lahan_perumahan' => 'nullable|numeric|min:0',
            'luas_psu' => 'nullable|numeric|min:0',
            'panjang_prasarana_jalan' => 'nullable|numeric|min:0',
            'lebar_prasarana_jalan' => 'nullable|numeric|min:0',
            'luas_prasarana_jalan' => 'nullable|numeric|min:0',
            'luas_prasarana_drainase' => 'nullable|numeric|min:0',
            'luas_prasarana_rth' => 'nullable|numeric|min:0',
            'luas_prasarana_tps' => 'nullable|numeric|min:0',
            'luas_sarana_pemakaman' => 'nullable|numeric|min:0',
            'luas_sarana_olahraga_dll' => 'nullable|numeric|min:0',
            'panjang_utilitas' => 'nullable|string|max:255',
            'sumber_air_bersih' => 'nullable|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'nama_pt' => 'required|string|max:255',
            'jumlah_unit_rumah' => 'nullable|integer|min:0',
            'tahun' => 'nullable|digits:4|integer|min:1900',
            'alamat' => 'nullable|string',
            'kecamatan' => 'nullable|string|max:255',
            'desa' => 'nullable|string|max:255',
            'nomor_site_plan' => ['nullable', 'string', 'max:255', Rule::unique('siteplans')->ignore($siteplan->id)],
            'tanggal_site_plan' => 'nullable|date',
            'nomor_bast_adm' => 'nullable|string|max:255',
            'tanggal_bast_adm' => 'nullable|date',
            'nomor_bast_fisik' => 'nullable|string|max:255',
            'tanggal_bast_fisik' => 'nullable|date',
            'keterangan' => 'nullable|string',
            // Aturan validasi untuk file
            'file_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ];

        // Menjalankan validasi
        $validatedData = $request->validate($rules);

        // --- Proses Upload File Baru (jika ada) ---
        if ($request->hasFile('file_path')) {
            // 1. Hapus file lama jika ada
            if ($siteplan->file_path) {
                Storage::disk('public')->delete($siteplan->file_path);
            }

            // 2. Simpan file baru dengan nama kustom
            $file = $request->file('file_path');
            $namaPerumahan = $request->input('nama');
            // Membuat nama file yang aman dari nama perumahan + timestamp agar unik
            $fileName = Str::slug($namaPerumahan) . '_' . time() . '.' . $file->getClientOriginalExtension();
            // Simpan file dengan nama baru
            $path = $file->storeAs('siteplans', $fileName, 'public');
            $validatedData['file_path'] = $path;
        }


        // Memperbarui data yang ada
        $siteplan->update($validatedData);

        return redirect()->route('siteplans.index')
            ->with('success', 'Data siteplan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siteplan $siteplan)
    {
        // Hapus file dari storage jika ada sebelum menghapus data dari database
        if ($siteplan->file_path) {
            Storage::disk('public')->delete($siteplan->file_path);
        }

        $siteplan->delete();

        return redirect()->route('siteplans.index')
            ->with('success', 'Data siteplan berhasil dihapus.');
    }


    /**
     * Export data to Excel.
     */
    public function export()
    {
        return Excel::download(new SiteplanExport, 'siteplans.xlsx');
    }

    /**
     * Import data from Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new SiteplanImport, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris " . $failure->row() . ": " . implode(", ", $failure->errors());
            }
            return back()->with('error', 'Gagal mengimpor data: ' . implode("; ", $errorMessages));
        }

        return back()->with('success', 'Data siteplan berhasil diimpor!');
    }
}
