<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WilayahController;

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

// API Wilayah (Proxy Wilayah.id bebas CORS, SSL & Cached 24 Jam)
Route::get('/wilayah/provinces', [WilayahController::class, 'provinces'])->name('api.wilayah.provinces');
Route::get('/wilayah/regencies/{provCode}', [WilayahController::class, 'regencies'])->name('api.wilayah.regencies');
Route::get('/wilayah/districts/{regCode}', [WilayahController::class, 'districts'])->name('api.wilayah.districts');
Route::get('/wilayah/villages/{distCode}', [WilayahController::class, 'villages'])->name('api.wilayah.villages');
