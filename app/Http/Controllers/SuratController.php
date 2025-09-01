<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse; // Import untuk type-hinting

class SuratController extends Controller
{
    /**
     * Menampilkan daftar semua surat dengan filter dan pencarian.
     */
    public function index(Request $request)
    {
        $query = Surat::with('divisi')->latest();

        // [PERBAIKAN] Mengelompokkan query pencarian agar tidak bentrok dengan filter
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_surat', 'like', '%' . $request->search . '%')
                    ->orWhere('perihal', 'like', '%' . $request->search . '%');
            });
        }

        // Logika untuk Filter Divisi
        if ($request->filled('divisi_id')) {
            $query->where('divisi_id', $request->divisi_id);
        }

        $daftarSurat = $query->paginate(10)->withQueryString(); // withQueryString() agar filter tetap ada saat pindah halaman
        $divisiList = Divisi::orderBy('nama_divisi')->get();

        return view('surat.index', [
            'surats' => $daftarSurat,
            'divisiList' => $divisiList,
            // 'request' tidak perlu dikirim karena bisa diakses global via helper request() di view
        ]);
    }

    /**
     * Menampilkan form untuk membuat surat baru.
     */
    public function create(Request $request)
    {
        return view('surat.create', [
            'divisiList' => Divisi::orderBy('nama_divisi')->get(),
            'selectedDivisiId' => $request->query('divisi_id') // Lebih baik mengambil dari query string
        ]);
    }

    /**
     * Menyimpan surat baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {

        dd($request->file('file_surat'));
        $validatedData = $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:surats,nomor_surat',
            'tanggal_surat' => 'required|date',
            'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
            'perihal' => 'required|string',
            'sifat' => 'required|string',
            'pengirim' => 'nullable|string|max:255',
            'penerima' => 'nullable|string|max:255',
            'divisi_id' => 'required|exists:divisis,id',
            'keterangan' => 'nullable|string',
            // [PERBAIKAN] Mengganti 'file' menjadi 'file_surat' sesuai form
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file_surat')) {
            // [PERBAIKAN] Menyimpan file ke storage/app/public/surat-files
            // Ini adalah praktik terbaik untuk file yang bisa diakses publik.
            $path = $request->file('file_surat')->store('surat-files', 'public');
            $validatedData['file_path'] = $path;
        }

        Surat::create($validatedData);

        // [PERBAIKAN] Redirect ke halaman index agar lebih konsisten
        return redirect()->back()->with('success', 'Surat berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail satu surat.
     */
    public function show(Surat $surat)
    {
        // Eager load relasi divisi
        $surat->load('divisi');
        return view('surat.show', compact('surat'));
    }

    /**
     * Menampilkan form untuk mengedit surat.
     */
    public function edit(Surat $surat)
    {
        return view('surat.edit', [
            'surat' => $surat,
            'divisiList' => Divisi::orderBy('nama_divisi')->get()
        ]);
    }

    /**
     * Memperbarui data surat di database.
     */
    public function update(Request $request, Surat $surat): RedirectResponse
    {
        $validatedData = $request->validate([
            // Abaikan unique check untuk record saat ini
            'nomor_surat' => 'required|string|max:255|unique:surats,nomor_surat,' . $surat->id,
            'tanggal_surat' => 'required|date',
            'jenis_surat' => 'required|string|in:Surat Masuk,Surat Keluar',
            'perihal' => 'required|string',
            'sifat' => 'required|string',
            'pengirim' => 'nullable|string|max:255',
            'penerima' => 'nullable|string|max:255',
            'divisi_id' => 'required|exists:divisis,id',
            'keterangan' => 'nullable|string',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('file_surat')) {
            // [PERBAIKAN] Hapus file lama jika ada sebelum mengupload yang baru
            if ($surat->file_path) {
                Storage::disk('public')->delete($surat->file_path);
            }
            // Upload file baru
            $path = $request->file('file_surat')->store('surat-files', 'public');
            $validatedData['file_path'] = $path;
        }

        $surat->update($validatedData);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil diperbarui!');
    }

    /**
     * Menghapus surat dari database.
     */
    public function destroy(Surat $surat): RedirectResponse
    {
        // [PERBAIKAN] Hapus file terkait dari storage menggunakan disk 'public'
        if ($surat->file_path) {
            Storage::disk('public')->delete($surat->file_path);
        }

        $surat->delete();

        return redirect()->route('surat.index')->with('success', 'Surat berhasil dihapus!');
    }

    public function showByDivisi(Request $request, $nama_divisi)
    {
        $divisi = Divisi::where('nama_divisi', $nama_divisi)->firstOrFail();

        // Kita bisa menggunakan kembali logika dari method index()
        $query = Surat::with('divisi')->where('divisi_id', $divisi->id)->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_surat', 'like', '%' . $request->search . '%')
                    ->orWhere('perihal', 'like', '%' . $request->search . '%');
            });
        }

        $daftarSurat = $query->paginate(10)->withQueryString();
        $divisiList = Divisi::orderBy('nama_divisi')->get();

        return view('surat.index', [
            'surats' => $daftarSurat,
            'divisiList' => $divisiList,
            'divisiTerpilih' => $divisi,
        ]);
    }
}
