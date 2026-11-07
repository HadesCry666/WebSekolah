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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeroSliderController;
use App\Http\Controllers\ProgramUnggulanController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\SiswaPortalController;

/* =======================================================
|  LANDING PAGE & AUTH
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
|  HALAMAN PUBLIK (FRONTEND)
======================================================= */

// Profil Sekolah
Route::get('/profil-sekolah', [ProfilSekolahController::class, 'front'])
    ->name('profil-sekolah');

// Informasi / Berita
Route::get('/informasi', [ArtikelController::class, 'informasiAll'])
    ->name('informasi.index');

Route::get('/informasi/kategori/{kategori}', [ArtikelController::class, 'informasiByKategori'])
    ->whereIn('kategori', ['berita', 'prestasi'])
    ->name('informasi.kategori');

Route::get('/informasi/detail/{id}', [ArtikelController::class, 'detail'])
    ->name('informasi.detail');

// Tenaga Pendidik
Route::get('/tenaga-pendidik', [TenagaPendidikController::class, 'frontIndex'])
    ->name('tenaga-pendidik.index');

Route::get('/tenaga-pendidik/detail/{id}', [TenagaPendidikController::class, 'detail'])
    ->name('tenaga-pendidik.detail');

// Ekstrakurikuler
Route::get('/ekstrakulikuler/{id}', [EkstrakurikulerController::class, 'detail'])
    ->name('ekstrakulikuler.detail');

// Pengaduan
Route::get('/pengaduan', [PengaduanController::class, 'front'])
    ->name('pengaduan.front');
Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');

// Galeri
Route::get('/galeri', [GaleriController::class, 'frontIndex'])
    ->name('galeri.index');

// Agenda
Route::get('/agenda', [AgendaController::class, 'frontIndex'])
    ->name('agenda.index');

// Pengumuman
Route::get('/pengumuman', [PengumumanController::class, 'frontIndex'])
    ->name('pengumuman.index');
Route::get('/pengumuman/{id}', [PengumumanController::class, 'frontDetail'])
    ->name('pengumuman.detail');

// Kurikulum
Route::get('/kurikulum', [KurikulumController::class, 'index'])
    ->name('kurikulum.index');

// Panduan & Edukasi Raport
Route::get('/raport', [RaportController::class, 'panduan'])
    ->name('raport.panduan');


/* =======================================================
|  ADMIN AREA
======================================================= */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Profil Sekolah
    Route::get('profil-sekolah', [ProfilSekolahController::class, 'edit'])
        ->name('profil-sekolah.edit');
    Route::post('profil-sekolah', [ProfilSekolahController::class, 'update'])
        ->name('profil-sekolah.update');

    // Hero Slider
    Route::get('hero-slider', [HeroSliderController::class, 'index'])
        ->name('hero-slider.index');
    Route::post('hero-slider', [HeroSliderController::class, 'store'])
        ->name('hero-slider.store');
    Route::put('hero-slider/{id}', [HeroSliderController::class, 'update'])
        ->name('hero-slider.update');
    Route::delete('hero-slider/{id}', [HeroSliderController::class, 'destroy'])
        ->name('hero-slider.destroy');

    // Informasi / Artikel
    Route::get('informasi', [InformasiController::class, 'index'])
        ->name('informasi.index');
    Route::post('informasi', [InformasiController::class, 'store'])
        ->name('informasi.store');
    Route::put('informasi/{id}', [InformasiController::class, 'update'])
        ->name('informasi.update');
    Route::delete('informasi/{id}', [InformasiController::class, 'destroy'])
        ->name('informasi.destroy');

    // Pengumuman
    Route::get('pengumuman', [PengumumanController::class, 'index'])
        ->name('pengumuman.index');
    Route::post('pengumuman', [PengumumanController::class, 'store'])
        ->name('pengumuman.store');
    Route::put('pengumuman/{id}', [PengumumanController::class, 'update'])
        ->name('pengumuman.update');
    Route::delete('pengumuman/{id}', [PengumumanController::class, 'destroy'])
        ->name('pengumuman.destroy');

    // Agenda
    Route::get('agenda', [AgendaController::class, 'index'])
        ->name('agenda.index');
    Route::post('agenda', [AgendaController::class, 'store'])
        ->name('agenda.store');
    Route::put('agenda/{id}', [AgendaController::class, 'update'])
        ->name('agenda.update');
    Route::delete('agenda/{id}', [AgendaController::class, 'destroy'])
        ->name('agenda.destroy');

    // Tenaga Pendidik
    Route::get('tenaga-pendidik', [TenagaPendidikController::class, 'adminIndex'])
        ->name('tenaga-pendidik.index');
    Route::post('tenaga-pendidik', [TenagaPendidikController::class, 'store'])
        ->name('tenaga-pendidik.store');
    Route::put('tenaga-pendidik/{id}', [TenagaPendidikController::class, 'update'])
        ->name('tenaga-pendidik.update');
    Route::delete('tenaga-pendidik/{id}', [TenagaPendidikController::class, 'destroy'])
        ->name('tenaga-pendidik.destroy');

    // Ekstrakurikuler
    Route::get('ekstrakulikuler', [EkstrakurikulerController::class, 'crud'])
        ->name('ekstrakulikuler.crud');
    Route::post('ekstrakulikuler/store', [EkstrakurikulerController::class, 'store'])
        ->name('ekstrakulikuler.store');
    Route::match(['put', 'post'], 'ekstrakulikuler/update/{id}', [EkstrakurikulerController::class, 'update'])
        ->name('ekstrakulikuler.update');
    Route::delete('ekstrakulikuler/delete/{id}', [EkstrakurikulerController::class, 'delete'])
        ->name('ekstrakulikuler.delete');

    // Program Unggulan
    Route::get('program-unggulan', [ProgramUnggulanController::class, 'index'])
        ->name('program-unggulan.index');
    Route::post('program-unggulan', [ProgramUnggulanController::class, 'store'])
        ->name('program-unggulan.store');
    Route::put('program-unggulan/{id}', [ProgramUnggulanController::class, 'update'])
        ->name('program-unggulan.update');
    Route::delete('program-unggulan/{id}', [ProgramUnggulanController::class, 'destroy'])
        ->name('program-unggulan.destroy');

    // Kurikulum
    Route::get('kurikulum', [KurikulumController::class, 'adminIndex'])
        ->name('kurikulum.index');
    Route::post('kurikulum', [KurikulumController::class, 'store'])
        ->name('kurikulum.store');
    Route::put('kurikulum/{id}', [KurikulumController::class, 'update'])
        ->name('kurikulum.update');
    Route::delete('kurikulum/{id}', [KurikulumController::class, 'destroy'])
        ->name('kurikulum.destroy');
    Route::post('kurikulum/{id}/toggle', [KurikulumController::class, 'toggleActive'])
        ->name('kurikulum.toggle');
    Route::post('kurikulum/pengantar', [KurikulumController::class, 'updatePengantar'])
        ->name('kurikulum.update-pengantar');

    // Fasilitas
    Route::get('fasilitas', [FasilitasController::class, 'index'])
        ->name('fasilitas.index');
    Route::post('fasilitas', [FasilitasController::class, 'store'])
        ->name('fasilitas.store');
    Route::put('fasilitas/{id}', [FasilitasController::class, 'update'])
        ->name('fasilitas.update');
    Route::delete('fasilitas/{id}', [FasilitasController::class, 'destroy'])
        ->name('fasilitas.destroy');

    // Galeri
    Route::get('galeri', [GaleriController::class, 'index'])
        ->name('galeri.index');
    Route::post('galeri', [GaleriController::class, 'store'])
        ->name('galeri.store');
    Route::put('galeri/{id}', [GaleriController::class, 'update'])
        ->name('galeri.update');
    Route::delete('galeri/{id}', [GaleriController::class, 'destroy'])
        ->name('galeri.destroy');

    // Prestasi
    Route::get('prestasi', [PrestasiController::class, 'index'])
        ->name('prestasi.index');
    Route::post('prestasi', [PrestasiController::class, 'store'])
        ->name('prestasi.store');
    Route::put('prestasi/{id}', [PrestasiController::class, 'update'])
        ->name('prestasi.update');
    Route::delete('prestasi/{id}', [PrestasiController::class, 'destroy'])
        ->name('prestasi.destroy');

    // Pengaduan
    Route::get('pengaduan', [PengaduanController::class, 'adminIndex'])
        ->name('pengaduan.index');
    Route::delete('pengaduan/{id}', [PengaduanController::class, 'destroy'])
        ->name('pengaduan.destroy');
    Route::put('pengaduan/{id}/status', [PengaduanController::class, 'updateStatus'])
        ->name('pengaduan.updateStatus');

    // Manajemen Siswa — static routes FIRST to avoid {id} conflict
    Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('siswa/template', [SiswaController::class, 'downloadTemplate'])->name('siswa.template');
    Route::post('siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
    Route::post('siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::put('siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

    // Manajemen Raport Siswa
    Route::get('raport', [RaportController::class, 'index'])->name('raport.index');
    Route::post('raport', [RaportController::class, 'store'])->name('raport.store');
    Route::delete('raport/{id}', [RaportController::class, 'destroy'])->name('raport.destroy');
    Route::post('raport/{id}/publish', [RaportController::class, 'togglePublish'])->name('raport.publish');
    Route::get('raport/{id}/download', [RaportController::class, 'download'])->name('raport.download');
    Route::get('raport/{id}/preview', [RaportController::class, 'preview'])->name('raport.preview');
    Route::post('raport/generate-akun', [RaportController::class, 'generateAkunSiswa'])->name('raport.generateAkun');
    Route::post('raport/panduan', [RaportController::class, 'updatePanduan'])->name('raport.panduan.update');
});

/* =======================================================
|  PORTAL SISWA
======================================================= */
Route::prefix('siswa')->name('siswa.')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/', [SiswaPortalController::class, 'index'])->name('dashboard');
    Route::get('raport', [SiswaPortalController::class, 'index'])->name('raport.index');
    Route::get('raport/{id}/download', [SiswaPortalController::class, 'downloadRaport'])->name('raport.download');
    Route::get('raport/{id}/preview', [SiswaPortalController::class, 'previewRaport'])->name('raport.preview');
});
