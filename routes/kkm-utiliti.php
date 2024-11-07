<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardkkmController;

Route::prefix("/kkm-utiliti")->group(function(){
    Route::any('/',[DashboardkkmController::class, 'index']);
    Route::any('/dashboard',[DashboardkkmController::class, 'index']);
    Route::post('/hospital',[DashboardkkmController::class, 'ajaxHospital']);
});

