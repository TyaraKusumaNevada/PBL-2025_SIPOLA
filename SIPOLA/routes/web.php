<?php
use App\Http\Controllers\InfoLombaController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\PrestasiMahasiswaController;
use App\Http\Controllers\siginController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RekomendasiController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::get('/rekomendasi', [RekomendasiController::class, 'form'])->name('rekomendasi.form');
Route::post('/rekomendasi', [RekomendasiController::class, 'hitung'])->name('rekomendasi.hitung');
// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Root view
Route::get('/welcome', function () {
    return view('welcome');
});

// --- PRESTASI ---
Route::prefix('prestasi')->group(function () {
    Route::get('/', [PrestasiMahasiswaController::class, 'index']);
    Route::post('/list', [PrestasiMahasiswaController::class, 'list']);
});

// --- ADMIN Manajemen Program Studi ---
Route::prefix('admin/ManajemenProdi')->group(function () {
    Route::get('/', [ProgramStudiController::class, 'index']);
    Route::get('list', [ProgramStudiController::class, 'list']);
    Route::get('create_ajax', [ProgramStudiController::class, 'create_ajax']);
    Route::post('store_ajax', [ProgramStudiController::class, 'store_ajax']);
    Route::get('{id}/show_ajax',[ProgramStudiController::class, 'show_ajax']);
    Route::get('{id}/edit_ajax',[ProgramStudiController::class, 'edit_ajax']);
    Route::put('{id}/update_ajax',[ProgramStudiController::class, 'update_ajax']);
    Route::get('{id}/confirm_ajax', [ProgramStudiController::class, 'confirm_ajax']);
    Route::delete('{id}/delete_ajax',[ProgramStudiController::class, 'delete_ajax']);
});

// --- ADMIN Manajemen Periode ---
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

// --- ADMIN Manajemen Pengguna ---
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

// --- LOMBA ---
Route::get('/lomba', function () {
    return view('lomba.index');
})->name('lomba.index');

// --- REGISTER/SIGNIN ---
Route::get('/signin', [siginController::class, 'showRegistrationForm'])->name('signin');
Route::post('/signin', [siginController::class, 'register']);

// --- PROFIL ---
Route::get('/profilmahasiswa', [ProfilController::class, 'index'])->name('profil.index');
Route::post('/profil/update-profile', [ProfilController::class, 'updateProfile'])->name('profil.update.profile')->middleware('auth');
Route::post('/profil/update-username', [ProfilController::class, 'updateUsername'])->name('profil.update.username')->middleware('auth');
Route::post('/profil/update-academic', [ProfilController::class, 'updateAcademicProfile'])->name('profil.update.academic')->middleware('auth');
// Tambahkan route ini ke dalam group route yang sudah ada
Route::post('/profil/delete-academic', [ProfilController::class, 'deleteAcademicItem'])->name('profil.delete.academic');
// --- LANDING & INFO LOMBA ---
Route::get('/', [LandingController::class, 'index']);
Route::get('/landing', [LandingController::class, 'index']);
Route::get('/infolomba', [InfoLombaController::class, 'index'])->name('infolomba');
