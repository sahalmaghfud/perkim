<?php

namespace App\Http\Controllers;

use App\Exports\RumahTidakLayakHuniExport;
use App\Models\RumahTidakLayakHuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;


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

        $query = RumahTidakLayakHuni::query();

        // Terapkan pencarian jika ada input 'search'
        $query->when($request->search, function ($q, $search) {
            return $q->where('nama_kepala_ruta', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%");
        });

        // Terapkan filter jika ada input 'status'
        $query->when($request->status, function ($q, $status) {
            return $q->where('status', $status);
        });

        // BARU: Terapkan filter untuk kecamatan
        $query->when($request->kecamatan, function ($q, $kecamatan) {
            return $q->where('kecamatan', $kecamatan);
        });

        // BARU: Terapkan filter untuk desa/kelurahan
        $query->when($request->desa_kelurahan, function ($q, $desa) {
            return $q->where('desa_kelurahan', $desa);
        });

        $data = $query->latest()->paginate(10)->withQueryString(); // withQueryString() agar filter tetap ada saat pindah halaman

        // Kirim semua data yang diperlukan ke view
        return view('rtlh.index', compact('data', 'kecamatans', 'desas'));
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
            'nik' => 'required|string|unique:rumah_tidak_layak_huni|max:16',
            'umur' => 'required|integer',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'kecamatan' => 'required|string',
            'desa_kelurahan' => 'required|string',
            'luas_rumah' => 'required|numeric',
            'status' => 'required|in:sudah diperbaiki,sedang diperbaiki,belum diperbaiki',
            'foto_sebelum_perbaikan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_sesudah_perbaikan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // Tambahkan validasi untuk field lain jika diperlukan
            'kode_wilayah' => 'nullable|string',
            'kategori_rumah' => 'nullable|string',
            'kepemilikan_rumah' => 'nullable|string',
            'kepemilikan_tanah' => 'nullable|string',
            'koordinat' => 'nullable|string',
        ]);

        // Proses unggah file "sebelum"
        if ($request->hasFile('foto_sebelum_perbaikan')) {
            $file = $request->file('foto_sebelum_perbaikan');
            $namaFile = $request->nik . '-sebelum-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('rtlh', $namaFile, 'public');
            $validatedData['foto_sebelum_perbaikan'] = $path;
        }

        // Proses unggah file "sesudah"
        if ($request->hasFile('foto_sesudah_perbaikan')) {
            $file = $request->file('foto_sesudah_perbaikan');
            $namaFile = $request->nik . '-sesudah-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('rtlh', $namaFile, 'public');
            $validatedData['foto_sesudah_perbaikan'] = $path;
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
            'nik' => 'required|string|max:16|unique:rumah_tidak_layak_huni,nik,' . $rumahTidakLayakHuni->id,
            'umur' => 'required|integer',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'kecamatan' => 'required|string',
            'desa_kelurahan' => 'required|string',
            'luas_rumah' => 'required|numeric',
            'status' => 'required|in:sudah diperbaiki,sedang diperbaiki,belum diperbaiki',
            'foto_sebelum_perbaikan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_sesudah_perbaikan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kode_wilayah' => 'string',
            'kategori_rumah' => 'nullable|string',
            'kepemilikan_rumah' => 'nullable|string',
            'kepemilikan_tanah' => 'nullable|string',
            'koordinat' => 'nullable|string',
        ]);

        // Proses update file "sebelum"
        if ($request->hasFile('foto_sebelum_perbaikan')) {
            if ($rumahTidakLayakHuni->foto_sebelum_perbaikan) {
                Storage::disk('public')->delete($rumahTidakLayakHuni->foto_sebelum_perbaikan);
            }
            $file = $request->file('foto_sebelum_perbaikan');
            $namaFile = $request->nik . '-sebelum-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('rtlh', $namaFile, 'public');
            $validatedData['foto_sebelum_perbaikan'] = $path;
        }

        // Proses update file "sesudah"
        if ($request->hasFile('foto_sesudah_perbaikan')) {
            if ($rumahTidakLayakHuni->foto_sesudah_perbaikan) {
                Storage::disk('public')->delete($rumahTidakLayakHuni->foto_sesudah_perbaikan);
            }
            $file = $request->file('foto_sesudah_perbaikan');
            $namaFile = $request->nik . '-sesudah-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('rtlh', $namaFile, 'public');
            $validatedData['foto_sesudah_perbaikan'] = $path;
        }

        $rumahTidakLayakHuni->update($validatedData);

        return redirect()->route('rtlh.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(RumahTidakLayakHuni $rumahTidakLayakHuni)
    {
        // Hapus kedua foto jika ada
        if ($rumahTidakLayakHuni->foto_sebelum_perbaikan) {
            Storage::disk('public')->delete($rumahTidakLayakHuni->foto_sebelum_perbaikan);
        }
        if ($rumahTidakLayakHuni->foto_sesudah_perbaikan) {
            Storage::disk('public')->delete($rumahTidakLayakHuni->foto_sesudah_perbaikan);
        }

        $rumahTidakLayakHuni->delete();

        return redirect()->route('rtlh.index')->with('success', 'Data berhasil dihapus.');
    }

    public function export()
    {
        // Tentukan nama file yang akan diunduh
        $fileName = 'data-rumah-tidak-layak-huni-' . date('Y-m-d') . '.xlsx';

        // Panggil class Export dan unduh filenya
        return Excel::download(new RumahTidakLayakHuniExport, $fileName);
    }
}
