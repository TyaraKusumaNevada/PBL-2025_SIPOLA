<?php
// File: routes/web.php
// Route definitions for web interface

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

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

// // Protected Routes (require authentication)
// Route::middleware(['auth'])->group(function () {
//     // Dashboard routes
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');

//     // Admin routes
//     Route::middleware(['role:admin'])->prefix('admin')->group(function () {
//         Route::get('/dashboard', function () {
//             return view('admin.dashboard');
//         })->name('admin.dashboard');
//     });

//     // Student routes
//     Route::middleware(['role:student'])->prefix('student')->group(function () {
//         Route::get('/dashboard', function () {
//             return view('student.dashboard');
//         })->name('student.dashboard');
//     });
// });

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/login', function () {
    return view('auth.login');
});

Route::get('/auth/register', function () {
    return view('auth.register');
});

Route::prefix('mahasiswa')->group(function () {
    Route::get('/profil', function () {
        return view('mahasiswa.profil');
    });

    Route::get('/prestasi', function () {
        return view('mahasiswa.prestasi');
    });
});

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
});

Route::get('/lomba', function () {
    return view('lomba.index');
})->name('lomba.index');