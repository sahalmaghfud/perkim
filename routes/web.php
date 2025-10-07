<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\JalanLingkunganController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SiteplanController;
use App\Http\Controllers\RumahTidakLayakHuniController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\BackupController;

// --- ROUTE UNTUK TAMU (YANG BELUM LOGIN) ---
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

// --- ROUTE UNTUK PENGGUNA YANG SUDAH LOGIN ---
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('backup')->middleware(['auth'])->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('backup.index');
        Route::get('/database', [BackupController::class, 'backupDatabase'])->name('backup.database');

        // Ganti dari GET menjadi POST
        Route::post('/storage', [BackupController::class, 'backupStorage'])->name('backup.storage');
    });

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resourceful Routes
    Route::resource('dokumen', DokumenController::class);
    Route::resource('siteplans', SiteplanController::class);
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('jalan_lingkungan', JalanLingkunganController::class);
    Route::resource('rtlh', RumahTidakLayakHuniController::class)->parameters([
        'rtlh' => 'rumahTidakLayakHuni'
    ]);
    Route::resource('cv', App\Http\Controllers\CvController::class);
    // ->names([
    //     'index' => 'jalan_lingkungan.cv.index',
    //     'create' => 'jalan_lingkungan.cv.create',
    //     'store' => 'jalan_lingkungan.cv.store',
    //     'show' => 'jalan_lingkungan.cv.show',
    //     'edit' => 'jalan_lingkungan.cv.edit',
    //     'update' => 'jalan_lingkungan.cv.update',
    //     'destroy' => 'jalan_lingkungan.cv.destroy',
    // ]);
    // Route khusus untuk Siteplan (Export & Import)
    Route::get('/siteplans/export/new', [SiteplanController::class, 'export'])->name('siteplans.export');
    Route::post('/siteplans/import', [SiteplanController::class, 'import'])->name('siteplans.import');

    // Route khusus untuk Pegawai
    Route::get('/pegawai/export', [PegawaiController::class, 'export'])->name('pegawai.export');

    // Route untuk manajemen dokumen per pegawai
    Route::post('/pegawai/{pegawai}/dokumen', [PegawaiController::class, 'dokumenStore'])->name('pegawai.dokumen.store');
    Route::get('/pegawai/dokumen/{dokumen}', [PegawaiController::class, 'dokumenShow'])->name('pegawai.dokumen.show');
    Route::delete('/pegawai/dokumen/{dokumen}', [PegawaiController::class, 'dokumenDestroy'])->name('pegawai.dokumen.destroy');

    // Route khusus untuk menampilkan dokumen berdasarkan bidang
    // Ditempatkan di akhir agar tidak bentrok dengan route lain
    Route::get('/dokumen/bidang/{nama_bidang}', [DokumenController::class, 'showByBidang'])->name('dokumen.bidang');
    Route::get('/pegawai/export/new', [PegawaiController::class, 'export'])->name('pegawai.export');
    Route::get('/peta-sebaran', [MapController::class, 'index'])->name('map.index');
    Route::get('/rtlh/export/new', [RumahTidakLayakHuniController::class, 'export'])->name('rtlh.export');
    Route::get('/jalan-lingkungan/export/new', [JalanLingkunganController::class, 'export'])->name('jalanlingkungan.export');

});


Route::get('/', function () {
    if (auth()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->middleware('auth')->name('password.form');
Route::post('/change-password', [AuthController::class, 'changePassword'])->middleware('auth')->name('password.change');
