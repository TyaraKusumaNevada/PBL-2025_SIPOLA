<?php
// File: routes/web.php
// Route definitions for web interface

use App\Http\Controllers\AuthController;
use App\Http\Controllers\siginController;
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


Route::get('/signin', [siginController::class, 'showRegistrationForm'])->name('signin');
Route::post('/signin', [siginController::class, 'register']);

