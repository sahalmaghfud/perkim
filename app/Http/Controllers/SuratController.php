<?php
namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;
use App\Models\Surat; // Asumsi Anda punya model Surat

class SuratController extends Controller
{
    public function index(Request $request)
    {
        $query = Surat::with('divisi')->latest(); // Eager loading untuk efisiensi

        // Logika untuk Pencarian
        if ($request->filled('search')) {
            $query->where('nomor_surat', 'like', '%' . $request->search . '%')
                ->orWhere('perihal', 'like', '%' . $request->search . '%');
        }

        // Logika untuk Filter Divisi
        if ($request->filled('divisi_id')) {
            $query->where('divisi_id', $request->divisi_id);
        }

        $daftarSurat = $query->paginate(10); // Paginasi 10 data per halaman
        $divisi = Divisi::all();

        return view('surat.index', [
            'surats' => $daftarSurat,
            'divisiList' => $divisi,
            'request' => $request // Kirim request untuk mempertahankan value di form filter
        ]);
    }

    /**
     * Menampilkan form untuk membuat surat baru.
     */
    // ...
    public function create(Request $request)
    {
        return view('surat.create', [
            'divisiList' => Divisi::all(),
            // Kirim ID divisi yang dipilih dari URL ke view
            'selectedDivisiId' => $request->divisi_id
        ]);
    }
    // ...

    /**
     * Menyimpan surat baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:surats',
            'tanggal_surat' => 'required|date',
            'jenis_surat' => 'required|string',
            'perihal' => 'required|string',
            'sifat' => 'required|string',
            'pengirim' => 'nullable|string',
            'penerima' => 'nullable|string',
            'divisi_id' => 'required|exists:divisis,id',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048', // File maks 2MB
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('public/files');
            $validatedData['file_path'] = $path;
        }

        $surat = Surat::create($validatedData);

        // Cari tahu nama divisi dari ID yang baru saja disimpan
        $divisi = Divisi::find($surat->divisi_id);

        // Jika divisi ditemukan, arahkan ke halaman divisi tersebut.
        // Jika tidak (seharusnya tidak mungkin terjadi), arahkan ke halaman utama.
        if ($divisi) {
            return redirect()->route('surat.divisi', ['nama_divisi' => $divisi->nama_divisi])
                ->with('success', 'Surat berhasil ditambahkan!');
        }

        return redirect()->route('surat.index')->with('success', 'Surat berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail satu surat.
     */
    public function show(Surat $surat)
    {
        return view('surat.show', compact('surat'));
    }

    /**
     * Menampilkan form untuk mengedit surat.
     */
    public function edit(Surat $surat)
    {
        return view('surat.edit', [
            'surat' => $surat,
            'divisiList' => Divisi::all()
        ]);
    }

    /**
     * Memperbarui data surat di database.
     */
    public function update(Request $request, Surat $surat)
    {
        $validatedData = $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:surats,nomor_surat,' . $surat->id,
            'tanggal_surat' => 'required|date',
            'jenis_surat' => 'required|string',
            'perihal' => 'required|string',
            'sifat' => 'required|string',
            'pengirim' => 'nullable|string',
            'penerima' => 'nullable|string',
            'divisi_id' => 'required|exists:divisis,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // File tidak wajib diisi saat update
        ]);

        // if ($request->hasFile('file')) {
        //     // Hapus file lama jika ada
        //     // if ($surat->file_path) {
        //     //     Storage::delete($surat->file_path);
        //     // }
        //     // Upload file baru
        //     $path = $request->file('file')->store('public/files');
        //     $validatedData['file_path'] = $path;
        // }

        $surat->update($validatedData);

        return redirect()->back()->with('success', 'Surat berhasil diperbarui!');
    }

    /**
     * Menghapus surat dari database.
     */
    public function destroy(Surat $surat)
    {
        // Hapus file terkait dari storage
        // if ($surat->file_path) {
        //     Storage::delete($surat->file_path);
        // }

        $surat->delete();

        return redirect()->back()->with('success', 'Surat berhasil dihapus!');
    }

    /**
     * Menampilkan surat berdasarkan divisi yang dipilih dari URL.
     * Method ini akan diakses melalui route '/surat/{nama_divisi}'.
     * * @param string $namaDivisi Nilai ini otomatis diisi Laravel dari parameter rute.
     */
    public function showByDivisi($nama_divisi)
    {
        // Cari divisi berdasarkan nama. Jika tidak ditemukan, tampilkan halaman 404.
        $divisi = Divisi::where('nama_divisi', $nama_divisi)->firstOrFail();

        // Ambil semua surat yang memiliki divisi_id yang cocok, urutkan dari yang terbaru
        $daftarSurat = Surat::with('divisi')
            ->where('divisi_id', $divisi->id)
            ->latest()
            ->paginate(10); // Gunakan paginasi juga di sini

        // Kita bisa menggunakan kembali view 'surat.index'
        // karena fungsinya sama, yaitu menampilkan daftar surat.
        return view('surat.index', [
            'surats' => $daftarSurat,
            'divisiList' => Divisi::all(), // Kirim semua divisi untuk filter dropdown
            'divisiTerpilih' => $divisi,   // Kirim info divisi yang sedang aktif
            'request' => request() // Untuk mempertahankan value filter jika ada
        ]);
    }
}
