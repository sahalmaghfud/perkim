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

    public function index(Request $request)
    {
        // 1. Ambil data untuk mengisi filter dropdown (tetap sama)
        $kecamatans = Siteplan::select('kecamatan')->whereNotNull('kecamatan')->distinct()->orderBy('kecamatan')->get();
        $desas = Siteplan::select('desa')->whereNotNull('desa')->distinct()->orderBy('desa')->get();
        $namaPts = Siteplan::select('nama_pt')->whereNotNull('nama_pt')->distinct()->orderBy('nama_pt')->get();

        // 2. Mulai query dan terapkan filter berdasarkan request URL
        $query = Siteplan::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")->orWhere('nama_pt', 'like', "%{$search}%");
            });
        }
        if ($request->filled('kecamatan'))
            $query->where('kecamatan', $request->input('kecamatan'));
        if ($request->filled('desa'))
            $query->where('desa', $request->input('desa'));
        if ($request->filled('nama_pt'))
            $query->where('nama_pt', $request->input('nama_pt'));
        if ($request->filled('keterangan'))
            $query->where('keterangan', $request->input('keterangan'));
        if ($request->filled('start_date'))
            $query->where('tanggal_site_plan', '>=', $request->input('start_date'));
        if ($request->filled('end_date'))
            $query->where('tanggal_site_plan', '<=', $request->input('end_date'));

        // 3. Eksekusi query dengan paginasi
        $siteplans = $query->latest()->paginate(15);

        // 4. Kirim semua data (hasil filter & data dropdown) ke view
        return view('siteplans.index', compact('siteplans', 'kecamatans', 'desas', 'namaPts'));
    }

    /**
     * Method BARU untuk menangani filter AJAX.
     * Mengembalikan data dalam format JSON.
     */


    /**
     * Method export tidak perlu diubah, karena sudah menerima parameter dari constructor.
     */
    public function export(Request $request)
    {
        // 1. Ambil SEMUA parameter filter dari URL (search, kecamatan, dll.)
        // dan simpan dalam bentuk array.
        $filters = $request->all();

        // 2. Siapkan nama file
        $fileName = 'data_siteplan_' . now()->format('Y-m-d') . '.xlsx';

        // 3. Panggil class export dan kirimkan array $filters ke dalamnya.
        // Ini adalah langkah PENTING yang menghubungkan controller dengan class export.
        return Excel::download(new SiteplanExport($filters), $fileName);
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
            // Diubah dari back() ke redirect()->route()
            dd($errorMessages);
            return redirect()->route('siteplans.index')->with('error', 'Gagal mengimpor data: ' . implode("; ", $errorMessages));
        }

        // Diubah dari back() ke redirect()->route()
        return redirect()->route('siteplans.index')->with('success', 'Data siteplan berhasil diimpor!');
    }
}
