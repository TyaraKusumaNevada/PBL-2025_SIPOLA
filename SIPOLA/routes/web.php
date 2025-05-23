<?php
// File: routes/web.php
// Route definitions for web interface

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\siginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TambahLombaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Redirect root to login
// Route::get('/', function () {
//     return redirect()->route('login');
// });

// Tampilan Welcome
Route::get('/', function () {
    return view('welcome');
});

// ROUTE MAHASISWA
Route::prefix('mahasiswa')->group(function () {
    Route::get('/profil', function () {
        return view('mahasiswa.profil');
    });

    Route::get('/prestasi', function () {
        return view('mahasiswa.prestasi');
    });
});

    Route::get('/prestasi', function () {       //ini masih belum pakai controller yaa, tapi aman kok ^-^
        return view('prestasi.index');
    });

// ----------------------------------------------------------------------------------------
// ROUTE ADMIN (Manajemen Program Studi)
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
// ----------------------------------------------------------------------------------------


// ----------------------------------------------------------------------------------------
// ROUTE ADMIN (Manajemen Periode Semester)
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
// ----------------------------------------------------------------------------------------


// ----------------------------------------------------------------------------------------
// ROUTE ADMIN (Manajemen Pengguna)
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
// ----------------------------------------------------------------------------------------

// ROUTE LOMBA
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
// ROUTE LOGIN dan REGISTER
Route::get('/', function () {       // Redirect root to login
    return redirect()->route('login');
});

Route::get('/auth/login', function () {
    return view('auth.login');
});

Route::get('/signin', [siginController::class, 'showRegistrationForm'])->name('signin');
Route::post('/signin', [siginController::class, 'register']);
// ----------------------------------------------------------------------------------------