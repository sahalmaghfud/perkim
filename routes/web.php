<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuratController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');

// Rute untuk memproses login
Route::post('/login', [AuthController::class, 'login']);

// Rute untuk logout (Middleware: auth)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute untuk halaman dashboard yang dilindungi (Middleware: auth)
Route::get('/dashboard', function () {
    return redirect()->route('surat.index');
})->name('dashboard')->middleware('auth');


// Rute default yang akan mengarahkan ke login jika belum login
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/surat', [SuratController::class, 'index'])->name('surat.index');

Route::get('/{nama_divisi}/surat', [SuratController::class, 'showByDivisi'])->name('surat.divisi');

Route::resource('surat', SuratController::class);

Route::get('/', function () {
    return view('dashboard');
});
