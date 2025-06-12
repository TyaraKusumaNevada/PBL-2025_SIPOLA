<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\DashboardDospemController;
use App\Http\Controllers\InfoLombaController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\PrestasiMahasiswaController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\siginController;
use App\Http\Controllers\AdminLombaController;
use App\Http\Controllers\DospemController;
use App\Http\Controllers\MahasiswaLombaController;
use App\Http\Controllers\DospemLombaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifikasiPrestasiController;


// --- LANDING ---
Route::get('/', [LandingController::class, 'index']);
Route::get('/landing', [LandingController::class, 'index']);

// --- INFO LOMBA ---
Route::get('/infolomba', [InfoLombaController::class, 'index'])->name('infolomba');


// --- REKOMENDASI LOMBA ---
Route::get('/rekomendasi', [RekomendasiController::class, 'form'])->name('rekomendasi.form');
Route::post('/rekomendasi', [RekomendasiController::class, 'hitung'])->name('rekomendasi.hitung');

//-------------------------------------------------------------------------
//ROUTE LOGIN
// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/loginPost', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// --- REGISTER / SIGNIN ---
Route::get('/signin', [siginController::class, 'showRegistrationForm'])->name('signin');
Route::post('/signin', [siginController::class, 'register']);


// Root view
// Route::get('/', function () {
//     return view('welcome');
// });
// --- WELCOME / HOME PAGE ---
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('welcome');
});

// --- PRESTASI MAHASISWA (UPLOAD) ---
Route::prefix('prestasi')->group(function () {
    Route::get('/', [PrestasiMahasiswaController::class, 'index']);
    Route::post('/list', [PrestasiMahasiswaController::class, 'list']);
    Route::get('create_ajax', [PrestasiMahasiswaController::class, 'create_ajax']);
    Route::post('/ajax', [PrestasiMahasiswaController::class, 'store_ajax']);
    Route::get('{id}/show_ajax', [PrestasiMahasiswaController::class, 'show_ajax']);
    Route::get('{id}/edit_ajax', [PrestasiMahasiswaController::class, 'edit_ajax']);
    Route::put('{id}/update_ajax', [PrestasiMahasiswaController::class, 'update_ajax']);
    Route::get('/export_pdf', [PrestasiMahasiswaController::class, 'export_pdf']);
    Route::get('/{id}/delete_ajax', [PrestasiMahasiswaController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [PrestasiMahasiswaController::class, 'delete_ajax']);
});

// --- MANFAATKAN VIEW STATIS UNTUK CEK PRESTASI ---
Route::get('/prestasi', function () {
    return view('mahasiswa.prestasi');
});

// --- VERIFIKASI PRESTASI (ADMIN) ---
Route::prefix('/prestasiAdmin')->group(function () {
    Route::get('/', [VerifikasiPrestasiController::class, 'index']);
    Route::post('/list', [VerifikasiPrestasiController::class, 'list']);
    Route::get('{id}/ubahStatus', [VerifikasiPrestasiController::class, 'ubahStatus']);
    Route::post('{id}/ubahStatus', [VerifikasiPrestasiController::class, 'simpanStatus']);
    Route::get('/{id}/show_ajax', [VerifikasiPrestasiController::class, 'show_ajax']);
});

// --- MANAJEMEN PRODI (ADMIN) ---
Route::prefix('admin/ManajemenProdi')->group(function () {
    Route::get('/', [ProgramStudiController::class, 'index']);
    Route::get('list', [ProgramStudiController::class, 'list']);
    Route::get('create_ajax', [ProgramStudiController::class, 'create_ajax']);
    Route::post('store_ajax', [ProgramStudiController::class, 'store_ajax']);
    Route::get('{id}/show_ajax', [ProgramStudiController::class, 'show_ajax']);
    Route::get('{id}/edit_ajax', [ProgramStudiController::class, 'edit_ajax']);
    Route::put('{id}/update_ajax', [ProgramStudiController::class, 'update_ajax']);
    Route::get('{id}/confirm_ajax', [ProgramStudiController::class, 'confirm_ajax']);
    Route::delete('{id}/delete_ajax', [ProgramStudiController::class, 'delete_ajax']);
});

// --- MANAJEMEN PERIODE (ADMIN) ---
Route::prefix('periode')->group(function () {
    Route::get('/', [PeriodeController::class, 'index']);
    Route::post('list', [PeriodeController::class, 'list']);
    Route::get('create_ajax', [PeriodeController::class, 'create_ajax']);
    Route::post('/ajax', [PeriodeController::class, 'store_ajax']);
    Route::get('{id}/show_ajax', [PeriodeController::class, 'show_ajax']);
    Route::get('{id}/edit_ajax', [PeriodeController::class, 'edit_ajax']);
    Route::put('{id}/update_ajax', [PeriodeController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [PeriodeController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [PeriodeController::class, 'delete_ajax']);
});

// --- MANAJEMEN USER (ADMIN) ---
Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('list', [UserController::class, 'list']);
    Route::get('create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/ajax', [UserController::class, 'store_ajax']);
    Route::get('{id}/{role}/show_ajax', [UserController::class, 'show_ajax']);
    Route::get('{id}/{role}/edit_ajax', [UserController::class, 'edit_ajax']);
    Route::put('{id}/{role}/update_ajax', [UserController::class, 'update_ajax']);
    Route::get('{id}/{role}/delete_ajax', [UserController::class, 'confirm_ajax']);
    Route::delete('{id}/{role}/delete_ajax', [UserController::class, 'delete_ajax']);
    Route::post('{id}/{role}/reset_ajax', [UserController::class, 'resetPassword_ajax']);
});

// ----------------------------------------------------------------------------------------
// ROUTE MAHASISWA (Unggah Prestasi)
Route::prefix('prestasi')->group(function () {
    Route::get('/', [PrestasiMahasiswaController::class, 'index']);
    Route::post('/list', [PrestasiMahasiswaController::class, 'list']);
    Route::get('create_ajax', [PrestasiMahasiswaController::class, 'create_ajax']);
    Route::post('/ajax', [PrestasiMahasiswaController::class, 'store_ajax']);
    Route::get('{id}/show_ajax', [PrestasiMahasiswaController::class, 'show_ajax']);
    Route::get('{id}/edit_ajax', [PrestasiMahasiswaController::class, 'edit_ajax']);
    Route::put('{id}/update_ajax', [PrestasiMahasiswaController::class, 'update_ajax']);
    Route::get('/export_pdf', [PrestasiMahasiswaController::class, 'export_pdf']);      
    Route::get('/{id}/delete_ajax', [PrestasiMahasiswaController::class, 'confirm_ajax']);     
    Route::delete('/{id}/delete_ajax', [PrestasiMahasiswaController::class, 'delete_ajax']);    
}); 
// ----------------------------------------------------------------------------------------

// --- MANAJEMEN LOMBA (ADMIN) ---
Route::prefix('lomba')->group(function () {
    Route::get('/', [AdminLombaController::class, 'index']);
    Route::post('list', [AdminLombaController::class, 'list']);
    Route::get('create_ajax', [AdminLombaController::class, 'create_ajax']);
    Route::post('/ajax', [AdminLombaController::class, 'store_ajax']);
    Route::get('{id}/show_ajax', [AdminLombaController::class, 'show_ajax']);
    Route::get('{id}/edit_ajax', [AdminLombaController::class, 'edit_ajax']);
    Route::put('{id}/update_ajax', [AdminLombaController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [AdminLombaController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [AdminLombaController::class, 'delete_ajax']);
});

// --- VERIFIKASI LOMBA (ADMIN) ---
Route::prefix('lomba/verifikasi')->group(function () {
    Route::get('/', [AdminLombaController::class, 'indexVerifikasi']);
    Route::post('list', [AdminLombaController::class, 'listVerifikasi']);
    Route::get('{id}/showVerifikasi', [AdminLombaController::class, 'showVerifikasi']);
    Route::get('{id}/ubahStatus', [AdminLombaController::class, 'ubahStatus']);
    Route::post('{id}/ubahStatus', [AdminLombaController::class, 'simpanStatus']);  
    Route::get('{id}/editVerifikasi', [AdminLombaController::class, 'editVerifikasi']);
    Route::put('{id}/updateVerifikasi', [AdminLombaController::class, 'updateVerifikasi']);
    Route::get('/{id}/deleteVerifikasi', [AdminLombaController::class, 'confirmVerifikasi']);
    Route::delete('/{id}/deleteVerifikasi', [AdminLombaController::class, 'deleteVerifikasi']);
});

// ----------------------------------------------------------------------------------------
// ROUTE DOSEN PEMBIMBING (Info Lomba)
Route::prefix('lombaDospem')->group(function () {
    Route::get('/', [DospemLombaController::class, 'index']);
    Route::post('list', [DospemLombaController::class, 'list']);
    Route::get('{id}/show_info', [DospemLombaController::class, 'show_info']);
    Route::get('create_ajax', [DospemLombaController::class, 'create_ajax']);
    Route::post('ajax', [DospemLombaController::class, 'store_ajax']);
    Route::get('histori', [DospemLombaController::class, 'histori'])->name('lombaDospem.histori');
    Route::get('{id}/show_tambah', [DospemLombaController::class, 'show_tambah']);
});
// ----------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------
// ROUTE DOSPEM (Mahasiswa Bimbingan)
Route::prefix('dospem/mahasiswa_prestasi')->group(function () {
    Route::get('/', [DospemController::class, 'index'])->name('dospem.mahasiswa_prestasi.index');
    Route::get('list', [DospemController::class, 'listMahasiswaPrestasi'])->name('dospem.mahasiswa_prestasi.list');
    Route::get('{id}/detail', [DospemController::class, 'detailPrestasi'])->name('dospem.mahasiswa_prestasi.detail');
});
// ----------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------
// ROUTE MAHASISWA (Lomba)
Route::prefix('lombaMahasiswa')->group(function () {
    Route::get('/', [MahasiswaLombaController::class, 'index']);
    Route::post('list', [MahasiswaLombaController::class, 'list']);
    Route::get('{id}/show_info', [MahasiswaLombaController::class, 'show_info']);
    Route::get('create_ajax', [MahasiswaLombaController::class, 'create_ajax']);
    Route::post('ajax', [MahasiswaLombaController::class, 'store_ajax']);
    Route::get('histori', [MahasiswaLombaController::class, 'histori'])->name('lombaMahasiswa.histori');
    Route::get('{id}/show_tambah', [MahasiswaLombaController::class, 'show_tambah']);
});
// ----------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------
// ROUTE ADMIN (Verifikasi Prestasi)
Route::prefix('/prestasiAdmin')->group(function () {
    Route::get('/', [VerifikasiPrestasiController::class, 'index']);
    Route::post('/list', [VerifikasiPrestasiController::class, 'list']);
    Route::get('{id}/ubahStatus', [VerifikasiPrestasiController::class, 'ubahStatus']);
    Route::post('{id}/ubahStatus', [VerifikasiPrestasiController::class, 'simpanStatus']);  
    Route::get('/{id}/show_ajax', [VerifikasiPrestasiController::class, 'show_ajax']);
}); 
// ----------------------------------------------------------------------------------------

// --- PROFIL ---
// --- PROFIL MAHASISWA/ADMIN/DOSEN ---
Route::get('/profilMahasiswa', [ProfilController::class, 'index'])->name('profil.index');
Route::get('/profilAdmin', [ProfilController::class, 'indexAdmin'])->name('profilAdmin.index');
Route::get('/profilDosen', [ProfilController::class, 'indexDosen'])->name('profilDosen.index');

// --- AKSI PROFIL (Update & Hapus Akademik) ---
Route::post('/profil/update-profile', [ProfilController::class, 'updateProfile'])->name('profil.update.profile')->middleware('auth');
Route::post('/profil/update-username', [ProfilController::class, 'updateUsername'])->name('profil.update.username')->middleware('auth');
Route::post('/profil/update-academic', [ProfilController::class, 'updateAcademicProfile'])->name('profil.update.academic')->middleware('auth');

// --- LANDING & INFO LOMBA ---
Route::get('/', [LandingController::class, 'index']);
Route::get('/infolomba', [InfoLombaController::class, 'index'])->name('infolomba');

// -- DASHBOARD
//Mahasiswa
Route::prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [DashboardMahasiswaController::class, 'index'])->name('mahasiswa.dashboard.data');
});
//Dospem
Route::prefix('dospem')->group(function () {
    Route::get('/dashboard', [DashboardDospemController::class, 'index'])->name('dospem.dashboard.data');
});

Route::post('/profil/delete-academic', [ProfilController::class, 'deleteAcademicItem'])->name('profil.delete.academic');