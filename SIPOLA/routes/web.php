<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\loginController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/akses/login', function () {
    return view('akses.login');
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