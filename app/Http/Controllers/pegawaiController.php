<?php

namespace App\Http\Controllers;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Exports\PegawaiExport;
use Maatwebsite\Excel\Facades\Excel;

class pegawaiController extends Controller
{
    public function index()
    {
        // Mengambil data pegawai dengan relasi ke divisi
        // Menggunakan with('divisi') untuk Eager Loading (menghindari N+1 problem)
        // Menggunakan paginate() untuk membatasi data per halaman
        $pegawai = Pegawai::with('divisi')->latest()->paginate(10);

        // Mengirim data pegawai ke view 'pegawai.index'
        return view('pegawai', compact('pegawai'));
    }

    public function export()
    {
        return Excel::download(new PegawaiExport, 'data_pegawai.xlsx');
    }
}
