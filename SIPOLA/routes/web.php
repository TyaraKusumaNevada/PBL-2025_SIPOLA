<?php
use App\Http\Controllers\InfoLombaController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\PrestasiMahasiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\siginController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\VerifikasiPrestasiController;
use App\Http\Controllers\TambahLombaController;
use App\Http\Controllers\DashboardMahasiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//-------------------------------------------------------------------------
//ROUTE LOGIN
// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/loginPost', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
//-------------------------------------------------------------------------
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/prestasi', function () {
        return view('mahasiswa.prestasi');
    });

// Root view
Route::get('/', function () {
    return view('welcome');
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
    Route::get('/{id}/delete_ajax', [PrestasiMahasiswaController::class, 'confirm_ajax']);     
    Route::delete('/{id}/delete_ajax', [PrestasiMahasiswaController::class, 'delete_ajax']);    
}); 
// ----------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------
// ROUTE MAHASISWA (Unggah Prestasi)
Route::prefix('lomba')->group(function () {
    Route::get('/', [TambahLombaController::class, 'index']);
    Route::get('/list', [TambahLombaController::class, 'list']);
    Route::get('/create_ajax', [TambahLombaController::class, 'create_ajax']);
    Route::post('/store_ajax', [TambahLombaController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [TambahLombaController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [TambahLombaController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [TambahLombaController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [TambahLombaController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [TambahLombaController::class, 'delete_ajax']);
});
// ----------------------------------------------------------------------------------------


// --- PROFIL ---
Route::get('/profilmahasiswa', [ProfilController::class, 'index'])->name('profil.index');

// ----------------------------------------------------------------------------------------
// ROUTE ADMIN (Verifikasi Prestasi)
Route::prefix('/prestasiAdmin')->group(function () {
    Route::get('/', [VerifikasiPrestasiController::class, 'index']);
    Route::post('/list', [VerifikasiPrestasiController::class, 'list']);
    Route::get('{id}/ubahStatus', [VerifikasiPrestasiController::class, 'ubahStatus']);
    Route::post('{id}/ubahStatus', [VerifikasiPrestasiController::class, 'simpanStatus']);  
}); 
// ----------------------------------------------------------------------------------------

Route::post('/profil/update-profile', [ProfilController::class, 'updateProfile'])->name('profil.update.profile')->middleware('auth');
Route::post('/profil/update-username', [ProfilController::class, 'updateUsername'])->name('profil.update.username')->middleware('auth');
Route::post('/profil/update-academic', [ProfilController::class, 'updateAcademicProfile'])->name('profil.update.academic')->middleware('auth');

// --- LANDING & INFO LOMBA ---
Route::get('/landing', [LandingController::class, 'index']);
Route::get('/infolomba', [InfoLombaController::class, 'index'])->name('infolomba');

// -- Dashboard (Mahasiswa) --
Route::prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [DashboardMahasiswaController::class, 'index'])->name('mahasiswa.dashboard.data');
});
