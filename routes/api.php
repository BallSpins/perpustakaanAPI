<?php

use App\Http\Controllers\User\GuruController;
use App\Http\Controllers\User\MuridController;
use App\Http\Controllers\User\PetugasController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix('user')->group(function() {
    Route::resource('murid', MuridController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('petugas', PetugasController::class);

});

Route::any('{any}', function () {
    return response()->json([
        'ok' => false,
        'message' => 'Endpoint not found'
    ], 404);
});