<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AkademikController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route Management Jurusan
    Route::get('/akademik', [AkademikController::class, 'index'])->name('akademik.index');

    Route::post('/jurusan/store', [JurusanController::class, 'store'])->name('jurusan.store');
    Route::put('/jurusan/update/{id}', [JurusanController::class, 'update'])->name('jurusan.update'); // <-- UPDATE
    Route::delete('/jurusan/delete/{id}', [JurusanController::class, 'destroy'])->name('jurusan.destroy'); // <-- DELETE

    Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas.store');
    Route::put('/kelas/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/delete/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
    Route::put('/siswa/update/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/delete/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

    Route::get('/riwayat-absensi', [AbsensiController::class, 'riwayat'])->name('absensi.riwayat');
    Route::put('/riwayat-absensi/update/{tanggal}/{id}', [AbsensiController::class, 'updateStatus'])->name('absensi.update');

    Route::get('/pengaturan-jadwal', [AbsensiController::class, 'pengaturanJadwal'])->name('absensi.jadwal');
    Route::post('/pengaturan-jadwal', [AbsensiController::class, 'simpanJadwal'])->name('absensi.jadwal.simpan');

    Route::get('/qr-generator', [QrController::class, 'index'])->name('qr.index');
    Route::get('/api/qr-generate-baru', [QrController::class, 'generateBaru'])->name('api.qr.generate');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
