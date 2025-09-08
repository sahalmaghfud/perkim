<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\pegawaiController;
use App\Http\Controllers\SiteplanController;

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


Route::resource('dokumen', DokumenController::class)
    ->parameters(['dokumen' => 'dokumen']);
Route::resource('siteplans', SiteplanController::class);


// Route khusus untuk menampilkan dokumen berdasarkan divisi (disesuaikan agar konsisten)
Route::get('/{nama_bidang}/dokumen', [DokumenController::class, 'showByBidang'])->name('dokumen.bidang');


Route::get('/dashboard', function () {
    return view('dashboard');
});


Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
Route::get('/pegawai/test/', [PegawaiController::class, 'index']);

Route::get('/pegawai/export', [PegawaiController::class, 'export'])->name('pegawai.export');

Route::get('/siteplans/export/new', [SiteplanController::class, 'export'])->name('siteplans.export');
Route::post('/siteplans/import', [SiteplanController::class, 'import'])->name('siteplans.import');
