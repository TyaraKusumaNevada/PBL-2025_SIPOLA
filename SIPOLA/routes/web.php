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

Route::get('/mahasiswa/profil', function () {
    return view('mahasiswa.profil');
});

Route::get('/mahasiswa/prestasi', function () {
    return view('mahasiswa.prestasi');
});

Route::get('/login', function () {
    return view('akses.login');
});

