<?php

use App\Http\Controllers\Book\BukuController;
use App\Http\Controllers\Book\KategoriController;
use App\Http\Controllers\Book\PenerbitController;
use App\Http\Controllers\Book\PenulisController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\GuruController;
use App\Http\Controllers\User\MuridController;
use App\Http\Controllers\User\PetugasController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::prefix('user')->group(function() {
        Route::resource('murid', MuridController::class);
        Route::resource('guru', GuruController::class);
        Route::resource('petugas', PetugasController::class);
    });
    
    Route::prefix('book')->group(function() {
        Route::resource('penerbit', PenerbitController::class);
        Route::resource('penulis', PenulisController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('buku', BukuController::class);
    });
});

Route::any('{any}', function () {
    return response()->json([
        'ok' => false,
        'message' => 'Endpoint not found'
    ], 404);
});