<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TentorController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\AbsensiController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// --- Group Auth Umum ---
Route::middleware(['auth'])->group(function () {
    Route::get('/absensi/form/{kelas_id}', [AbsensiController::class, 'form'])->name('absensi.form');
    Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::get('/absensi/cetak/{kelas_id}', [AbsensiController::class, 'cetakPresensi'])->name('absensi.cetak');
});

// --- Group Siswa ---
Route::middleware('auth')->group(function () {
    Route::get('/dashboard-siswa', [DashboardController::class, 'dashboardSiswa'])->name('dashboard-siswa');
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    
    // [RESTORED] Kembalikan ke nama asli biar View gak error
    Route::get('/profil/edit', [SiswaController::class, 'editProfil'])->name('edit.profil'); 
    Route::put('/profil/{id}/update', [SiswaController::class, 'updateProfil'])->name('profil.update');
    
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa/gabung-kelas', [DashboardController::class, 'storeKelas'])->name('siswa.store.kelas');
    Route::get('/siswa/pilih-kelas', [DashboardController::class, 'pilihKelas'])->name('siswa.pilih.kelas');
    Route::post('/siswa/store-kelas', [DashboardController::class, 'storeKelas'])->name('siswa.storeKelas');
    Route::get('/siswa/rincian-kelas/{id}', [DashboardController::class, 'rincianKelas'])->name('siswa.rincian.kelas');
    Route::delete('/siswa/kelas/{jadwal_id}', [DashboardController::class, 'destroyKelas'])->name('siswa.destroyKelas');
});

// --- Group Tentor ---
Route::middleware(['auth'])->group(function() {
     Route::get('/dashboard-tentor',[DashboardController::class,'dashboardTentor'])->name('dashboard-tentor');
    Route::get('/tentor', [tentorcontroller::class, 'index'])->name('tentor.index');
    Route::get('/tentor/create', [TentorController::class, 'create'])->name('tentor.create');
    Route::post('/tentor', [TentorController::class, 'store'])->name('tentor.store');
    Route::get('/tentor/edit/{id}', [TentorController::class, 'edit'])->name('tentor.edit.by.admin');
    Route::put('/tentor/update/{id}', [TentorController::class, 'update'])->name('tentor.update.by.admin'); 
    Route::delete('/tentor/{id}', [tentorcontroller::class, 'destroy'])->name('tentor.destroy');
    Route::get('/profil/edit', [DashboardController::class, 'editProfil'])->name('tentor.edit.profil');
    Route::put('/profil/update', [DashboardController::class, 'updateProfil'])->name('tentor.update.profil');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard-admin', [DashboardController::class, 'dashboardAdmin'])->name('dashboard-admin'); 
});

Route::middleware(['auth'])->group(function() {
    Route::get('/matapelajaran', [MataPelajaranController::class, 'index'])->name('matapelajaran.index');
    Route::get('/matapelajaran/create', [MataPelajaranController::class, 'create'])->name('matapelajaran.create'); 
    Route::post('/matapelajaran', [MataPelajaranController::class, 'store'])->name('matapelajaran.store'); 
    Route::get('/matapelajaran/{id}/edit', [MataPelajaranController::class, 'edit'])->name('matapelajaran.edit');
    Route::put('/matapelajaran/{id}', [MataPelajaranController::class, 'update'])->name('matapelajaran.update');
    Route::delete('/matapelajaran/{id}', [MataPelajaranController::class, 'destroy'])->name('matapelajaran.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('kelas')->name('kelas.')->group(function () {
    Route::get('/', [KelasController::class, 'index'])->name('index');
    Route::get('/create', [KelasController::class, 'create'])->name('create');
    Route::post('/', [KelasController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [KelasController::class, 'edit'])->name('edit');
    Route::put('/{id}', [KelasController::class, 'update'])->name('update');
    Route::delete('/{id}', [KelasController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth'])->group(function() {
    Route::resource('jadwal', JadwalController::class);
});

Route::middleware(['auth'])->prefix('informasi')->name('informasi.')->group(function () {
    Route::get('/', [InformasiController::class, 'index'])->name('index');
    Route::get('/create', [InformasiController::class, 'create'])->name('create');
    Route::post('/store', [InformasiController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [InformasiController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [InformasiController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [InformasiController::class, 'destroy'])->name('delete');
});

Route::middleware(['auth', 'verified'])
    ->prefix('pembayaran')
    ->name('pembayaran.')
    ->group(function () {
        Route::get('/', [PembayaranController::class, 'index'])->name('index');
        Route::get('/create', [PembayaranController::class, 'create'])->name('create');
        Route::post('/', [PembayaranController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PembayaranController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PembayaranController::class, 'update'])->name('update');
        Route::delete('/{id}', [PembayaranController::class, 'destroy'])->name('destroy');
        Route::get('/get-siswa-data/{siswaId}', [PembayaranController::class, 'getSiswaData'])->name('getSiswaData');
    });

Route::get('/absensi/kelas/{kelas}/rekap', [AbsensiController::class, 'rekap'])->name('absensi.rekap');

require __DIR__.'/auth.php';