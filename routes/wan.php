<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SyarikatController;

Route::prefix("/utiliti/syarikat")->middleware('isLoggedIn')->group(function(){
    Route::any('/senarai',[SyarikatController::class, 'index']);
    // Route::post('/simpan',[SyarikatController::class, 'simpan']);
    // Route::post('/ubah',[SyarikatController::class, 'ubah']);
});
