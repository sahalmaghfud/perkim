<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\pegawaiController;
use App\Http\Controllers\SuratController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');

// Rute untuk memproses login
Route::post('/login', [AuthController::class, 'login']);

// Rute untuk logout (Middleware: auth)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute untuk halaman dashboard yang dilindungi (Middleware: auth)
Route::get('/dashboard', function () {
    return redirect()->route('/dashboard');
})->name('dashboard')->middleware('auth');


// Rute default yang akan mengarahkan ke login jika belum login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::resource('surat', SuratController::class);
Route::resource('dokumen', DokumenController::class)
    ->parameters(['dokumen' => 'dokumen']);



// Route khusus untuk menampilkan dokumen berdasarkan divisi (disesuaikan agar konsisten)
Route::get('/{nama_divisi}/dokumen', [DokumenController::class, 'showByDivisi'])->name('dokumen.divisi');
Route::get('/{nama_divisi}/surat', [SuratController::class, 'showByDivisi'])->name('surat.divisi');

Route::get('/dashboard', function () {
    return view('dashboard');
});


Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');

Route::get('/pegawai/export', [PegawaiController::class, 'export'])->name('pegawai.export');
