<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\TenagaPendidikController;
use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\ProfilSekolahController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\AuthController;

/* =======================================================
|  LANDING PAGE
======================================================= */
Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login.index')
    ->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post')
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


/* =======================================================
|  INFORMASI (FRONTEND)
======================================================= */
Route::get('/profil-sekolah', [ProfilSekolahController::class, 'front'])
    ->name('profil-sekolah');

Route::get('/informasi', [ArtikelController::class, 'informasiAll'])
    ->name('informasi.index');

Route::get('/informasi/kategori/{kategori}', [ArtikelController::class, 'informasiByKategori'])
    ->whereIn('kategori', ['berita', 'prestasi'])
    ->name('informasi.kategori');

// Detail artikel / berita / prestasi
Route::get('/informasi/detail/{id}', [ArtikelController::class, 'detail'])
    ->name('informasi.detail');

// Halaman daftar guru
Route::get('/tenaga-pendidik', [TenagaPendidikController::class, 'frontIndex'])
    ->name('tenaga-pendidik.index');

// Halaman detail guru
Route::get('/tenaga-pendidik/detail/{id}', [TenagaPendidikController::class, 'detail'])
    ->name('tenaga-pendidik.detail');

Route::get('/ekstrakulikuler/{id}', [EkstrakurikulerController::class, 'detail'])
    ->name('ekstrakulikuler.detail');

    //Halaman Pengaduan
 Route::get('/pengaduan', [PengaduanController::class, 'front'])
    ->name('pengaduan.front');
Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');

/* =======================================================
|  ADMIN AREA (SEMUA CRUD DALAM SATU PREFIX)
======================================================= */
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {


    /* =======================================================
    |  CRUD INFORMASI
    ======================================================= */
    Route::get('informasi', [InformasiController::class, 'index'])
        ->name('informasi.index');

    Route::post('informasi', [InformasiController::class, 'store'])
        ->name('informasi.store');

    Route::put('informasi/{id}', [InformasiController::class, 'update'])
        ->name('informasi.update');

    Route::delete('informasi/{id}', [InformasiController::class, 'destroy'])
        ->name('informasi.destroy');


    /* =======================================================
    |  CRUD TENAGA PENDIDIK
    ======================================================= */
    Route::get('tenaga-pendidik', [TenagaPendidikController::class, 'adminIndex'])
        ->name('tenaga-pendidik.index');

    Route::post('tenaga-pendidik', [TenagaPendidikController::class, 'store'])
        ->name('tenaga-pendidik.store');

    Route::put('tenaga-pendidik/{id}', [TenagaPendidikController::class, 'update'])
        ->name('tenaga-pendidik.update');

    Route::delete('tenaga-pendidik/{id}', [TenagaPendidikController::class, 'destroy'])
        ->name('tenaga-pendidik.destroy');


    /* =======================================================
    |  CRUD PROFIL SEKOLAH
    ======================================================= */
    Route::get('profil-sekolah', [ProfilSekolahController::class, 'edit'])
        ->name('profil-sekolah.edit');

    Route::post('profil-sekolah', [ProfilSekolahController::class, 'update'])
        ->name('profil-sekolah.update');

    
    /* =======================================================
    |  CRUD EKSTRAKURIKULER
    ======================================================= */        
    Route::get('ekstrakulikuler', [EkstrakurikulerController::class, 'crud'])
        ->name('ekstrakulikuler.crud');

    Route::post('ekstrakulikuler/store', [EkstrakurikulerController::class, 'store'])
        ->name('ekstrakulikuler.store');

    Route::post('ekstrakulikuler/update/{id}', [EkstrakurikulerController::class, 'update'])
        ->name('ekstrakulikuler.update');

    Route::delete('ekstrakulikuler/delete/{id}', [EkstrakurikulerController::class, 'delete'])
        ->name('ekstrakulikuler.delete');


    /* =======================================================
    |  CRUD PENGADUAN
    ======================================================= */
   Route::get('/pengaduan', [PengaduanController::class, 'adminIndex'])
        ->name('pengaduan.index');

    Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])
        ->name('pengaduan.destroy');
});
