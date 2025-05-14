<?php
// File: routes/web.php
// Route definitions for web interface

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\siginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramStudiController;

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
Route::get('/', function () {
    return redirect()->route('login');
});

// Tampilan Welcome
Route::get('/', function () {
    return view('welcome');
});

// Tampilan Auth
Route::get('/auth/login', function () {
    return view('auth.login');
});

Route::get('/auth/register', function () {
    return view('auth.register');
});

// Tampilan Akses
Route::get('/akses/login', function () {
    return view('akses.login');
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

// ROUTE USER
Route::prefix('user')->group(function () {
    Route::get('/', function () {
        return view('user.index');
    })->name('user.index');

    Route::get('/create_ajax', function () {
        return view('user.create_ajax');
    })->name('user.create_ajax');

    Route::post('/ajax', function () {
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan (dummy testing)'
        ]);
    })->name('user.ajax.store');

    Route::get('/confirm_ajax', function () {
        return view('user.confirm_ajax');
    });
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

// ROUTE LOMBA
Route::get('/lomba', function () {
    return view('lomba.index');
})->name('lomba.index');