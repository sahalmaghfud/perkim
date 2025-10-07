<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Bidang;
use App\Models\Pangkat;
use App\Models\DokumenPegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str; // Tambahkan ini untuk menggunakan helper Str
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PegawaiExport;
use Carbon\Carbon;

class PegawaiController extends Controller
{


    /**
     * Menampilkan daftar semua pegawai.
     */
    public function index()
    {
        $pegawais = Pegawai::with(['pangkat', 'bidang'])->latest()->paginate(10);

        // Proses setiap data pegawai untuk menambahkan status pangkat
        $pegawais->getCollection()->transform(function ($pegawai) {
            if (is_null($pegawai->tmt_pangkat)) {
                $pegawai->status_pangkat = [
                    'color' => 'gray',
                    'tooltip' => 'TMT Pangkat tidak diisi.'
                ];
                return $pegawai;
            }

            $tmtPangkat = Carbon::parse($pegawai->tmt_pangkat);
            $selisihBulan = round($tmtPangkat->diffInMonths(Carbon::now()));

            if ($selisihBulan >= 48) { // 4 tahun atau lebih
                $pegawai->status_pangkat = [
                    'color' => 'red',
                    'tooltip' => 'Perlu diproses: Lebih dari 4 tahun sejak TMT Pangkat terakhir.'
                ];
            } elseif ($selisihBulan >= 44) {
                $pegawai->status_pangkat = [
                    'color' => 'yellow',
                    'tooltip' => 'Mendekati periode: ' . $selisihBulan . ' bulan sejak TMT Pangkat terakhir.'
                ];
            } else {
                $pegawai->status_pangkat = [
                    'color' => 'green',
                    'tooltip' => 'Periode aman: Baru ' . $selisihBulan . ' bulan sejak TMT Pangkat terakhir.'
                ];
            }

            return $pegawai;
        });

        // Urutkan berdasarkan warna (merah → kuning → hijau → abu-abu)
        $orderedColors = ['red', 'yellow', 'green', 'gray'];
        $sorted = $pegawais->getCollection()->sortBy(function ($pegawai) use ($orderedColors) {
            return array_search($pegawai->status_pangkat['color'], $orderedColors);
        })->values();

        // Ganti koleksi hasil paginate dengan yang sudah diurutkan
        $pegawais->setCollection($sorted);

        return view('pegawai.index', compact('pegawais'));
    }

    /**
     * Menampilkan form untuk membuat pegawai baru.
     */
    public function create()
    {
        $bidangs = Bidang::all();
        $pangkats = Pangkat::all();
        return view('pegawai.create', compact('bidangs', 'pangkats'));
    }

    /**
     * Menyimpan data pegawai baru ke database.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:25|unique:pegawai,nip',
            'bidang_id' => 'required|exists:bidang,id',
            'pangkat_id' => 'required|exists:pangkat,id',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'foto' => 'nullable',
            'tmt_cpns' => 'required|date',
            'tmt_pangkat' => 'required|date',
            'nama_jabatan' => 'nullable|string|max:255',
            'eselon' => 'nullable|string|max:5',
            'tmt_jabatan' => 'nullable|date',
            'nama_diklat' => 'nullable|string|max:255',
            'tahun_diklat' => 'nullable|digits:4|integer',
            'jumlah_jam_diklat' => 'nullable|integer',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jurusan' => 'required|string|max:150',
            'tahun_lulus' => 'required|digits:4|integer|min:1950|max:' . (date('Y')),
            'jenis_kelamin' => 'required|in:L,P',
            'catatan_mutasi' => 'nullable|string',
            'nama_univ' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto-pegawai', 'public');
            $validatedData['foto'] = $path;
        }

        Pegawai::create($validatedData);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data seorang pegawai.
     */
    public function show(Pegawai $pegawai)
    {
        $pegawai->load('dokumenPegawai');
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Menampilkan form untuk mengedit data pegawai.
     */
    public function edit(Pegawai $pegawai)
    {
        $bidangs = Bidang::all();
        $pangkats = Pangkat::all();
        return view('pegawai.edit', compact('pegawai', 'bidangs', 'pangkats'));
    }

    /**
     * Memperbarui data pegawai di database.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => ['required', 'string', 'max:25', Rule::unique('pegawai')->ignore($pegawai->id)],
            'bidang_id' => 'required|exists:bidang,id',
            'pangkat_id' => 'required|exists:pangkat,id',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tmt_cpns' => 'required|date',
            'tmt_pangkat' => 'required|date',
            'nama_jabatan' => 'nullable|string|max:255',
            'eselon' => 'nullable|string|max:5',
            'tmt_jabatan' => 'nullable|date',
            'nama_diklat' => 'nullable|string|max:255',
            'tahun_diklat' => 'nullable|digits:4|integer',
            'jumlah_jam_diklat' => 'nullable|integer',
            'pendidikan_terakhir' => 'required|string|max:100',
            'jurusan' => 'required|string|max:150',
            'tahun_lulus' => 'required|digits:4|integer|min:1950|max:' . (date('Y')),
            'jenis_kelamin' => 'required|in:L,P',
            'catatan_mutasi' => 'nullable|string',
            'nama_univ' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);


        if ($request->hasFile('foto')) {
            if ($pegawai->foto) {
                Storage::delete($pegawai->foto);
            }
            $path = $request->file('foto')->store('public/foto_pegawai');
            $validatedData['foto'] = $path;
        }

        $pegawai->update($validatedData);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Menghapus data pegawai dari database.
     */
    public function destroy(Pegawai $pegawai)
    {
        if ($pegawai->foto) {
            Storage::delete($pegawai->foto);
        }
        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil dihapus.');
    }


    /**
     * Menyimpan dokumen baru untuk pegawai tertentu.
     */
    public function dokumenStore(Request $request, Pegawai $pegawai)
    {
        $validator = Validator::make($request->all(), [
            'jenis_dokumen' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        // Membuat nama folder dan file yang aman untuk sistem file
        $namaPegawaiSlug = Str::slug($pegawai->nama, '_');
        $jenisDokumenSlug = Str::slug($request->jenis_dokumen, '_');
        $judulSlug = Str::slug($request->judul, '_');
        $tanggalUpload = now()->format('Y-m-d');

        // Menyusun path folder: nama_pegawai/jenis_dokumen/
        $folderPath = 'dokumen_pegawai/' . $namaPegawaiSlug . '/' . $jenisDokumenSlug;

        // Menyusun nama file: judul_nama_pegawai_tanggal.ext
        $fileName = $judulSlug . '_' . $namaPegawaiSlug . '_' . $tanggalUpload . '.' . $extension;

        // Menyimpan file dengan path dan nama yang sudah ditentukan
        $filePath = $file->storeAs($folderPath, $fileName, 'public');

        $pegawai->dokumenPegawai()->create([
            'jenis_dokumen' => $request->jenis_dokumen,
            'judul' => $request->judul,
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /**
     * Menampilkan atau mengunduh file dokumen.
     */

    /**
     * Menghapus dokumen milik pegawai.
     */
    public function dokumenDestroy(DokumenPegawai $dokumen)
    {

        Storage::delete($dokumen->file_path);
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }


    public function export()
    {
        // Mendefinisikan nama file yang akan di-download
        $fileName = 'Laporan_Data_Pegawai_' . date('Y-m-d') . '.xlsx';

        // Menggunakan Maatwebsite/Excel untuk men-download file
        return Excel::download(new PegawaiExport, $fileName);
    }

}

