<?php
// File: routes/web.php
// Route definitions for web interface

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth'])->group(function(){
  Route::prefix('user')->name('user.')->group(function(){
    // Halaman Blade index
    Route::get('/', [UserController::class, 'index'])->name('index');
    // DataTables JSON
    Route::get('/list', [UserController::class, 'list'])->name('list');
    // AJAX create/edit/delete
    Route::get('/create_ajax', [UserController::class, 'create_ajax'])->name('create_ajax');
    Route::post('/store_ajax', [UserController::class, 'store_ajax'])->name('store_ajax');
    Route::get('/edit_ajax/{id}', [UserController::class, 'edit_ajax'])->name('edit_ajax');
    Route::put('/update_ajax/{id}', [UserController::class, 'update_ajax'])->name('update_ajax');
    Route::get('/confirm_ajax/{id}', [UserController::class, 'confirm_ajax'])->name('confirm_ajax');
    Route::delete('/delete_ajax/{id}', [UserController::class, 'delete_ajax'])->name('delete_ajax');
  });
});

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
// Route::get('/', function () {
//     return redirect()->route('login');
// });

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/login', function () {
    return view('auth.login');
});


Route::get('/signin', [siginController::class, 'showRegistrationForm'])->name('signin');
Route::post('/signin', [siginController::class, 'register']);

