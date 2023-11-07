<?php

use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\InfoController;
use App\Http\Controllers\Api\JadwalmapelController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Pos\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pos\JabatanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// AUTH API
Route::name('auth.')->group(function () {
    Route::post('login', [UserController::class, 'login'])->name('login');
    Route::post('register', [UserController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [UserController::class, 'logout'])->name('logout');
        Route::get('user', [UserController::class, 'fetch'])->name('fetch');
        Route::get('siswa', [SiswaController::class, 'siswaAll']);
        Route::get('absensi', [AbsensiController::class, 'absensiSiswa']);
        Route::get('absensi/data', [AbsensiController::class, 'absensiDataSiswa']);
        Route::get('jadwalmapel', [JadwalmapelController::class, 'jadwalMapel']);
    });
});

Route::get('info', [InfoController::class, 'infoAll']);

Route::get('/admin-images/{imageName}', [InfoController::class, 'show']);
