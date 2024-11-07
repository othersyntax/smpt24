<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuangSewaController;

Route::prefix("/utiliti/ruang-sewa")->middleware('isLoggedIn')->group(function(){
    Route::any('/senarai',[RuangSewaController::class, 'index']);
    // Route::post('/simpan',[PTJController::class, 'simpan']);
    // Route::post('/ubah',[PTJController::class, 'ubah']);
});