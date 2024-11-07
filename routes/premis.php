<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Premis\PenyewaanController;
use App\Http\Controllers\Premis\BayaranController;
use App\Http\Controllers\PremisController;

Route::prefix('/premis')->group(function(){
    Route::get('/dashboard', [PenyewaanController::class, 'dashboard'])->name('premis-dashboard')->middleware('isLoggedIn');
    Route::any('/senarai', [PenyewaanController::class, 'senarai'])->name('premis-senarai')->middleware('isLoggedIn');
    Route::any('/kontrak', [PenyewaanController::class, 'kontrak'])->name('premis-senarai')->middleware('isLoggedIn');
    Route::get('/view/{tanah}',[PenyewaanController::class, 'papar'])->middleware('isLoggedIn');
    Route::get('/sewa/{sewaan}',[PenyewaanController::class, 'sewa'])->middleware('isLoggedIn');
    Route::get('/kontrak/tambah',[PenyewaanController::class, 'addKontrak'])->middleware('isLoggedIn');
    Route::post('/kontrak/simpan',[PenyewaanController::class, 'simpanSewa'])->middleware('isLoggedIn');
    Route::post('/sewa/bayar',[PenyewaanController::class, 'simpanBayar'])->middleware('isLoggedIn');
});
