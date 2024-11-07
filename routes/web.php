<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TanahController;
use App\Http\Controllers\CetakTanahController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FasilitiController;
use App\Http\Controllers\PremisController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\IsuController;
use App\Http\Controllers\BayaranController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ProfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });
Route::get('/',[LoginController::class, 'login'])->middleware('hasLoggedIn');

Route::prefix("/profile")->group(function(){
    Route::get('/papar',[ProfilController::class, 'papar'])->middleware('hasLoggedIn');
    Route::post('/ubah',[ProfilController::class, 'simpan'])->middleware('hasLoggedIn');
});

// Route::get('/map', function () {
//     return view('map.index');
// });

Route::prefix("/auth")->group(function(){
    Route::get('/login',[LoginController::class, 'login'])->middleware('hasLoggedIn');
    Route::any('/semak-pengguna',[LoginController::class, 'authLogin'])->name('semak-pengguna')->middleware('hasLoggedIn');
    Route::get('/updatepass', [LoginController::class, 'updatePass'])->middleware('hasLoggedIn');
    Route::get('/logout', [LoginController::class, 'logout']);
});

Route::prefix("/tanah")->middleware('isLoggedIn')->group(function(){
    Route::any('/senarai',[TanahController::class, 'senarai'])->name('tanah-senarai');
    Route::get('/tambah',[TanahController::class, 'tambah'])->name('tanah-tambah');
    Route::post('/simpan',[TanahController::class, 'simpan']);
    Route::get('/view/{id}',[TanahController::class, 'papar']);
    Route::get('/ubah/{id}',[TanahController::class, 'ubah']);
    Route::get('/ajax-daerah',[TanahController::class, 'ajaxDaerah']);
    Route::get('/ajax-bandar',[TanahController::class, 'ajaxBandar']);
    Route::get('/cetak/{tanah_id}',[CetakTanahController::class, 'generatePDF'])->name('cetak-tanah');

});

//Dashboard
Route::any('/dashboard',[DashboardController::class, 'index'])->name('dashboard')->middleware('isLoggedIn');

Route::prefix("/fasiliti")->group(function(){
    Route::get('/myFormAdd/{tanah_id}', [FasilitiController::class, 'ajaxFormAdd']);
    Route::get('/myFormEdit/{tanah_id}/{fasiliti_id}', [FasilitiController::class, 'ajaxFormEdit']);
    Route::post('/simpan', [FasilitiController::class, 'simpan'])->name('simpan-fasiliti');
    Route::get('/view/{fasiliti_id}', [FasilitiController::class, 'papar']);
    Route::post('/delete', [FasilitiController::class, 'delete']);
});

Route::prefix("/penilaian")->group(function(){
    Route::get('/myFormAdd/{tanah_id}', [PenilaianController::class, 'ajaxFormAdd']);
    Route::get('/myFormEdit/{tanah_id}/{penilaian_id}', [PenilaianController::class, 'ajaxFormEdit']);
    Route::post('/simpan', [PenilaianController::class, 'simpan']);
    Route::post('/delete', [PenilaianController::class, 'delete']);
});

Route::prefix("/dokumen")->group(function(){
    Route::get('/myFormAdd/{tanah_id}', [DokumenController::class, 'ajaxFormAdd']);
    // Route::get('/myFormEdit/{tanah_id}/{dokumen_id}', [DokumenController::class, 'ajaxFormEdit']);
    Route::post('/simpan', [DokumenController::class, 'simpan']);
});

Route::prefix("/isu")->group(function(){
    Route::get('/myFormAdd/{tanah_id}', [IsuController::class, 'ajaxFormAdd']);
    Route::get('/myFormEdit/{tanah_id}/{isu_id}', [IsuController::class, 'ajaxFormEdit']);
    Route::post('/simpan', [IsuController::class, 'simpan']);
    Route::post('/delete', [IsuController::class, 'delete']);
});

Route::prefix("/bayaran")->group(function(){
    Route::get('/myFormAdd/{tanah_id}', [BayaranController::class, 'ajaxFormAdd']);
    Route::get('/myFormEdit/{tanah_id}/{bayaran_id}', [BayaranController::class, 'ajaxFormEdit']);
    Route::post('/simpan', [BayaranController::class, 'simpan']);
    Route::post('/delete', [BayaranController::class, 'delete']);
});

Route::prefix('/ajax')->group(function(){
    Route::get('ajax-ruang', [AjaxController::class, 'ajaxRuang'])->middleware('isLoggedIn');
    Route::get('ajax-fasiliti', [AjaxController::class, 'ajaxFasiliti'])->middleware('isLoggedIn');
    Route::get('/ajax-daerah', [AjaxController::class, 'ajaxDaerah'])->middleware('isLoggedIn');
    Route::get('/ajax-mukim',[AjaxController::class, 'ajaxMukim'])->middleware('isLoggedIn');
});
include 'utiliti.php';
include 'premis.php';
include 'kkm-utiliti.php';
