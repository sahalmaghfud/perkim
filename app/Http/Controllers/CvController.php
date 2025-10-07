<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Mengambil semua data CV dari database
        $cvs = Cv::latest()->paginate(10);

        // Mengirim data ke view 'jalan_lingkungan.cv.index'
        // Anda perlu membuat view ini di resources/views/jalan_lingkungan/cv/index.blade.php
        return view('jalan_lingkungan.cv.index', compact('cvs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // Menampilkan form untuk membuat CV baru
        // Anda perlu membuat view ini di resources/views/jalan_lingkungan/cv/create.blade.php
        return view('jalan_lingkungan.cv.create');
    }


    public function store(Request $request)
    {
        // Validasi input dari form
        $validator = Validator::make($request->all(), [
            'nama_cv' => 'required|string|max:255',
            'npwp' => 'nullable|string|max:255|unique:cv,npwp',
            'nomor_rekening' => 'nullable|string|max:255',
            'nama_direktur' => 'nullable|string|max:255',
        ]);

        // Jika validasi gagal, kembali ke form dengan error dan input sebelumnya
        if ($validator->fails()) {
            return redirect()->route('cv.create')
                ->withErrors($validator)
                ->withInput();
        }

        // Membuat data CV baru di database
        Cv::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('cv.index')
            ->with('success', 'Data CV berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cv  $cv
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Cv $cv)
    {
        // Menampilkan detail satu data CV
        // Anda perlu membuat view ini di resources/views/jalan_lingkungan/cv/show.blade.php
        return view('jalan_lingkungan.cv.show', compact('cv'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cv  $cv
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Cv $cv)
    {
        // Menampilkan form untuk mengedit data CV
        // Anda perlu membuat view ini di resources/views/jalan_lingkungan/cv/edit.blade.php
        return view('jalan_lingkungan.cv.edit', compact('cv'));
    }


    public function update(Request $request, Cv $cv)
    {
        // Validasi input dari form edit
        $validator = Validator::make($request->all(), [
            'nama_cv' => 'required|string|max:255',
            'npwp' => 'nullable|string|max:255|unique:cv,npwp,' . $cv->id,
            'nomor_rekening' => 'nullable|string|max:255',
            'nama_direktur' => 'nullable|string|max:255',
        ]);

        // Jika validasi gagal, kembali ke form dengan error dan input sebelumnya
        if ($validator->fails()) {
            return redirect()->route('jalan_lingkungan.cv.edit', $cv->id)
                ->withErrors($validator)
                ->withInput();
        }

        // Mengupdate data CV di database
        $cv->update($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('cv.index')
            ->with('success', 'Data CV berhasil diperbarui.');
    }
    public function destroy(Cv $cv)
    {
        // Menghapus data CV dari database
        $cv->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('cv.index')
            ->with('success', 'Data CV berhasil dihapus.');
    }
}

