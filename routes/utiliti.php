<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PTJController;
use App\Http\Controllers\NegeriController;
use App\Http\Controllers\DaerahController;
use App\Http\Controllers\BandarController;
use App\Http\Controllers\JenisIsuController;
use App\Http\Controllers\HakMilikController;

Route::prefix("/utiliti/negeri")->middleware('isLoggedIn')->group(function(){
    Route::any('/senarai',[NegeriController::class, 'index']);
    Route::post('/simpan',[NegeriController::class, 'simpan']);
    Route::post('/ubah',[NegeriController::class, 'ubah']);
});

Route::prefix("/utiliti/daerah")->middleware('isLoggedIn')->group(function(){
    Route::any('/senarai',[DaerahController::class, 'index']);
    Route::post('/simpan',[DaerahController::class, 'simpan']);
    Route::post('/ubah',[DaerahController::class, 'ubah']);
});

Route::prefix("/utiliti/ptj")->middleware('isLoggedIn')->group(function(){
    Route::any('/senarai',[PTJController::class, 'index']);
    Route::post('/simpan',[PTJController::class, 'simpan']);
    Route::post('/ubah',[PTJController::class, 'ubah']);
});

Route::prefix("/utiliti/mukim")->group(function(){
    Route::any('/senarai',[BandarController::class, 'index'])->middleware('isLoggedIn');
    Route::post('/simpan',[BandarController::class, 'simpan'])->middleware('isLoggedIn');
    Route::post('/ubah',[BandarController::class, 'ubah'])->middleware('isLoggedIn');
});

Route::prefix("/utiliti/pengguna")->group(function(){
    Route::any('/senarai',[PenggunaController::class, 'index'])->name('pengguna-senarai')->middleware('isLoggedIn');
    Route::post('/simpan',[PenggunaController::class, 'simpan'])->name('pengguna-simpan')->middleware('isLoggedIn');
    Route::post('/modul',[PenggunaController::class, 'modul'])->name('pengguna-modul')->middleware('isLoggedIn');
    Route::post('/getmodul',[PenggunaController::class, 'getmodul'])->middleware('isLoggedIn');
    Route::get('/ubah/{user_id}',[PenggunaController::class, 'ubah'])->name('pengguna-ubah')->middleware('isLoggedIn');
    Route::get('/papar',[PenggunaController::class, 'papar'])->name('pengguna-papar')->middleware('isLoggedIn');
    Route::get('/tambah',[PenggunaController::class, 'tambah'])->name('pengguna-tambah')->middleware('isLoggedIn');
    Route::post('/katalaluan',[PenggunaController::class, 'setKatalaluan'])->name('pengguna-katalaluan')->middleware('isLoggedIn');
});

Route::prefix("/utiliti/jenis/isu")->middleware('isLoggedIn')->group(function(){
    Route::any('/senarai',[JenisIsuController::class, 'index']);
    Route::post('/simpan',[JenisIsuController::class, 'simpan']);
    Route::post('/ubah',[JenisIsuController::class, 'ubah']);
    Route::any('/data',[JenisIsuController::class, 'dataIsu']);
});

Route::prefix("/utiliti/hakmilik")->middleware('isLoggedIn')->group(function(){
    Route::any('/senarai',[HakMilikController::class, 'index']);
    Route::post('/simpan',[HakMilikController::class, 'simpan']);
    Route::post('/ubah',[HakMilikController::class, 'ubah']);
    Route::any('/data',[HakMilikController::class, 'dataHakmilik']);
});