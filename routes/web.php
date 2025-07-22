<?php

use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\BidanController;
use App\Http\Controllers\ClusteringController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\ImunisasiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PemeriksaanBalitaController;
use App\Http\Controllers\PerkembanganController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TempatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WelcomeController::class, 'welcome']);
Route::get('/berandajadwal', [WelcomeController::class, 'jadwal'])->name('home.jadwal');
Route::get('/berandaedukasi', [WelcomeController::class, 'edukasi'])->name('home.edukasi');
Route::get('/berandajenis', [WelcomeController::class, 'jenis'])->name('home.jenis');
// Route::get('/index', [WelcomeController::class, 'index'])->name('home.index');

require __DIR__ . '/auth.php';
Route::middleware(['auth', 'adminMiddleware'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/clustering', [ClusteringController::class, 'index'])->name('clustering.index');
    Route::get('/clustering/proses', [ClusteringController::class, 'prosesKMeans'])->name('clustering.proses');


    Route::get('/profil', [AdminProfileController::class, 'edit'])->name('admin.edit');
    Route::patch('/profil', [AdminProfileController::class, 'update'])->name('admin.update');
    Route::delete('/profil', [AdminProfileController::class, 'destroy'])->name('admin.destroy');

    Route::get('/jadwal', [JadwalController::class, 'tampil'])->name('jadwal.tampil');
    Route::get('/jadwal/tambah', [JadwalController::class, 'tambah'])->name('jadwal.tambah');
    Route::post('/jadwal/submit', [JadwalController::class, 'submit'])->name('jadwal.submit');
    Route::get('/jadwal/edit/{id}', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::post('/jadwal/update/{id}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::post('/jadwal/delete/{id}', [JadwalController::class, 'delete'])->name('jadwal.delete');

    Route::get('/tempat', [TempatController::class, 'tampil12'])->name('tempat.tampil12');
    Route::get('/tempat/tambah12', [TempatController::class, 'tambah12'])->name('tempat.tambah12');
    Route::post('/tempat/submit12', [TempatController::class, 'submit12'])->name('tempat.submit12');
    Route::get('/tempat/edit12/{id}', [TempatController::class, 'edit12'])->name('tempat.edit12');
    Route::post('/tempat/update12/{id}', [TempatController::class, 'update12'])->name('tempat.update12');
    Route::post('/tempat/delete12/{id}', [TempatController::class, 'delete12'])->name('tempat.delete12');

    Route::get('/edukasi', [PosyanduController::class, 'tampil1'])->name('edukasi.tampil1');
    Route::get('/edukasi/tambah1', [PosyanduController::class, 'tambah1'])->name('edukasi.tambah1');
    Route::post('/edukasi/submit1', [PosyanduController::class, 'submit1'])->name('edukasi.submit1');
    Route::get('/edukasi/edit1/{id}', [PosyanduController::class, 'edit1'])->name('edukasi.edit1');
    Route::post('/edukasi/update1/{id}', [PosyanduController::class, 'update1'])->name('edukasi.update1');
    Route::post('/edukasi/delete1/{id}', [PosyanduController::class, 'delete1'])->name('edukasi.delete1');

    Route::get('/jenis', [JenisController::class, 'tampil7'])->name('jenis.tampil7');
    Route::get('/jenis/tambah7', [JenisController::class, 'tambah7'])->name('jenis.tambah7');
    Route::post('/jenis/submit7', [JenisController::class, 'submit7'])->name('jenis.submit7');
    Route::get('/jenis/edit7/{id}', [JenisController::class, 'edit7'])->name('jenis.edit7');
    Route::post('/jenis/update7/{id}', [JenisController::class, 'update7'])->name('jenis.update7');
    Route::post('/jenis/delete7/{id}', [JenisController::class, 'delete7'])->name('jenis.delete7');

    Route::get('/imunisasi', [ImunisasiController::class, 'tampil2'])->name('imunisasi.tampil2');
    Route::get('/imunisasi/tambah2', [ImunisasiController::class, 'tambah2'])->name('imunisasi.tambah2');
    Route::post('/imunisasi/submit2', [ImunisasiController::class, 'submit2'])->name('imunisasi.submit2');
    Route::get('/imunisasi/lihat2/{id}', [ImunisasiController::class, 'lihat2'])->name('imunisasi.lihat2');
    Route::get('/imunisasi/edit2/{id}', [ImunisasiController::class, 'edit2'])->name('imunisasi.edit2');
    Route::post('/imunisasi/update2/{id}', [ImunisasiController::class, 'update2'])->name('imunisasi.update2');

    Route::get('/kegiatan', [PosyanduController::class, 'tampil3'])->name('kegiatan.tampil3');
    Route::get('/kegiatan/tambah3', [PosyanduController::class, 'tambah3'])->name('kegiatan.tambah3');
    Route::post('/kegiatan/submit3', [PosyanduController::class, 'submit3'])->name('kegiatan.submit3');
    Route::get('/kegiatan/edit3/{id}', [PosyanduController::class, 'edit3'])->name('kegiatan.edit3');
    Route::post('/kegiatan/update3/{id}', [PosyanduController::class, 'update3'])->name('kegiatan.update3');
    Route::post('/kegiatan/delete3/{id}', [PosyanduController::class, 'delete3'])->name('kegiatan.delete3');

    Route::get('/balita', [BalitaController::class, 'tampil4'])->name('balita.tampil4');
    Route::get('/balita/tambah4', [BalitaController::class, 'tambah4'])->name('balita.tambah4');
    Route::post('/balita/submit4', [BalitaController::class, 'submit4'])->name('balita.submit4');
    Route::get('/balita/lihat4/{id}', [BalitaController::class, 'lihat4'])->name('balita.lihat4');
    Route::get('/balita/edit4/{id}', [BalitaController::class, 'edit4'])->name('balita.edit4');
    Route::post('/balita/update4/{id}', [BalitaController::class, 'update4'])->name('balita.update4');
    Route::post('/balita/delete4/{id}', [BalitaController::class, 'delete4'])->name('balita.delete4');
    Route::post('/balita/import', [BalitaController::class, 'import'])->name('balita.import');

    Route::get('/pemeriksaan', [PemeriksaanBalitaController::class, 'tampil5'])->name('pemeriksaan.tampil5');
    Route::get('/pemeriksaan/tambah5/{id_balita}', [PemeriksaanBalitaController::class, 'tambah5'])->name('pemeriksaan.tambah5');
    Route::post('/pemeriksaan/simpan5', [PemeriksaanBalitaController::class, 'simpan5'])->name('pemeriksaan.simpan5');
    Route::get('/pemeriksaan/lihat/{id}', [PemeriksaanBalitaController::class, 'lihat5'])->name('pemeriksaan.lihat5');
    Route::get('/pemeriksaan/edit5/{id}', [PemeriksaanBalitaController::class, 'edit5'])->name('pemeriksaan.edit5');
    Route::post('/pemeriksaan/update5/{id}', [PemeriksaanBalitaController::class, 'update5'])->name('pemeriksaan.update5');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPDF'])->name('laporan.exportPDF');

    Route::get('/petugas', [PetugasController::class, 'tampil6'])->name('petugas.tampil6');
    Route::get('/petugas/tambah6', [PetugasController::class, 'tambah6'])->name('petugas.tambah6');
    Route::post('/petugas/submit6', [PetugasController::class, 'submit6'])->name('petugas.submit6');
    Route::get('/petugas/edit6/{id}', [PetugasController::class, 'edit6'])->name('petugas.edit6');
    Route::post('/petugas/update6/{id}', [PetugasController::class, 'update6'])->name('petugas.update6');
    Route::post('/petugas/delete6/{id}', [PetugasController::class, 'delete6'])->name('petugas.delete6');
});

Route::middleware(['auth', 'userMiddleware'])->group(function () {
    Route::get('/user', [UserController::class, 'tampil14'])->name('user.tampil14');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::post('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.delete'); // optional
});
