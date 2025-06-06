<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardMahasiswaController;
use App\Http\Controllers\InfoLombaController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\PrestasiMahasiswaController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\siginController;
use App\Http\Controllers\TambahLombaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifikasiPrestasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- LANDING ---
Route::get('/', [LandingController::class, 'index']);
Route::get('/landing', [LandingController::class, 'index']);

// --- INFO LOMBA ---
Route::get('/infolomba', [InfoLombaController::class, 'index'])->name('infolomba');

// --- REKOMENDASI LOMBA ---
Route::get('/rekomendasi', [RekomendasiController::class, 'form'])->name('rekomendasi.form');
Route::post('/rekomendasi', [RekomendasiController::class, 'hitung'])->name('rekomendasi.hitung');

// --- LOGIN / AUTH ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// --- REGISTER / SIGNIN ---
Route::get('/signin', [siginController::class, 'showRegistrationForm'])->name('signin');
Route::post('/signin', [siginController::class, 'register']);

// --- WELCOME / HOME PAGE ---
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('welcome');
});

// --- DASHBOARD MAHASISWA ---
Route::prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [DashboardMahasiswaController::class, 'index'])->name('mahasiswa.dashboard.data');
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
});

// --- MANAJEMEN LOMBA (ADMIN) ---
Route::prefix('lomba')->group(function () {
    Route::get('/', [TambahLombaController::class, 'index']);
    Route::post('/list', [TambahLombaController::class, 'list']);
    Route::get('/create_ajax', [TambahLombaController::class, 'create_ajax']);
    Route::post('/ajax', [TambahLombaController::class, 'store_ajax']);
    Route::get('{id}/show_ajax', [TambahLombaController::class, 'show_ajax']);
    Route::get('{id}/edit_ajax', [TambahLombaController::class, 'edit_ajax']);
    Route::put('{id}/update_ajax', [TambahLombaController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [TambahLombaController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [TambahLombaController::class, 'delete_ajax']);
});

// --- PROFIL MAHASISWA/ADMIN/DOSEN ---
Route::get('/profilMahasiswa', [ProfilController::class, 'index'])->name('profil.index');
Route::get('/profilAdmin', [ProfilController::class, 'indexAdmin'])->name('profilAdmin.index');
Route::get('/profilDosen', [ProfilController::class, 'indexDosen'])->name('profilDosen.index');

// --- AKSI PROFIL (Update & Hapus Akademik) ---
Route::post('/profil/update-profile', [ProfilController::class, 'updateProfile'])->name('profil.update.profile')->middleware('auth');
Route::post('/profil/update-username', [ProfilController::class, 'updateUsername'])->name('profil.update.username')->middleware('auth');
Route::post('/profil/update-academic', [ProfilController::class, 'updateAcademicProfile'])->name('profil.update.academic')->middleware('auth');
Route::post('/profil/delete-academic', [ProfilController::class, 'deleteAcademicItem'])->name('profil.delete.academic');
