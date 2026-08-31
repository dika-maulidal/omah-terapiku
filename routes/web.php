<?php

use App\Events\StatusRekamUpdate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\IcdController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\RekamController;
use App\Http\Controllers\RekamPemeriksaanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TindakanController;

Route::get('/', [AuthController::class, 'page_login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('login.auth');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('test', function () {
    StatusRekamUpdate::dispatch("5","REG002","INI TEST AJA","http://sss","25 05 1993");
	// event(new App\Events\StatusRekamUpdate("082240300501"));
	return "Event has been sent!";
});

Route::get('/loaddata', [RekamPemeriksaanController::class, 'insertToTableNew'])->name('loaddata');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/omahterapiku', [PoliController::class, 'index'])->name('omahterapiku');
    Route::post('/omahterapiku', [PoliController::class, 'store'])->name('omahterapiku.store');
    Route::post('/omahterapiku/{id}/update', [PoliController::class, 'update'])->name('omahterapiku.update');
    Route::get('/omahterapiku/{id}/delete', [PoliController::class, 'delete'])->name('omahterapiku.delete');

    Route::get('/getDokter', [DokterController::class, 'getDokter'])->name('getDokter');
    Route::get('/getTerapis', [DokterController::class, 'getDokter'])->name('getTerapis');

    Route::get('/dokter', [DokterController::class, 'index'])->name('dokter');
    Route::get('/terapis', [DokterController::class, 'index'])->name('terapis');
    Route::post('/dokter/store', [DokterController::class, 'store'])->name('dokter.store');
    Route::post('/terapis/store', [DokterController::class, 'store'])->name('terapis.store');
    Route::post('/dokter/{id}/update', [DokterController::class, 'update'])->name('dokter.update');
    Route::post('/terapis/{id}/update', [DokterController::class, 'update'])->name('terapis.update');
    Route::get('/dokter/{id}/delete', [DokterController::class, 'delete'])->name('dokter.delete');
    Route::get('/terapis/{id}/delete', [DokterController::class, 'delete'])->name('terapis.delete');
    Route::post('/dokter/{id}/gantipassword', [DokterController::class, 'updatepassword'])->name('dokter.gantipassword');
    Route::post('/terapis/{id}/gantipassword', [DokterController::class, 'updatepassword'])->name('terapis.gantipassword');

    Route::post('/gantipassword/{id}', [AuthController::class, 'updatepassword'])->name('gantipassword');
    Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas');
    Route::post('/petugas/store', [PetugasController::class, 'store'])->name('petugas.store');
    Route::post('/petugas/{id}/update', [PetugasController::class, 'update'])->name('petugas.update');
    Route::get('/petugas/{id}/delete', [PetugasController::class, 'delete'])->name('petugas.delete');

    Route::get('/getNoRM', [PasienController::class, 'getLastRM'])->name('getNoRM');

    Route::get('/penerima-manfaat', [PasienController::class, 'index'])->name('penerima-manfaat');
    Route::get('/penerima-manfaat/export-csv', [PasienController::class, 'exportCsv'])->name('penerima-manfaat.export-csv');
    Route::get('/penerima-manfaat/add', [PasienController::class, 'add'])->name('penerima-manfaat.add');
    Route::get('/penerima-manfaat/{id}/edit', [PasienController::class, 'edit'])->name('penerima-manfaat.edit');
    Route::get('/penerima-manfaat/{id}/delete', [PasienController::class, 'delete'])->name('penerima-manfaat.delete');
    Route::get('/penerima-manfaat/json', [PasienController::class, 'json'])->name('penerima-manfaat.json');
    Route::get('/penerima-manfaat/{id}/file', [PasienController::class, 'file'])->name('penerima-manfaat.file');

    Route::post('/penerima-manfaat/store', [PasienController::class, 'store'])->name('penerima-manfaat.store');
    Route::post('/penerima-manfaat/{id}/update', [PasienController::class, 'update'])->name('penerima-manfaat.update');

    Route::get('/icd/json', [IcdController::class, 'data'])->name('icd.data');
    Route::get('/icd', [IcdController::class, 'index'])->name('icd');
    Route::post('/icd/store', [IcdController::class, 'store'])->name('icd.store');
    Route::post('/icd/{id}/update', [IcdController::class, 'update'])->name('icd.update');
    Route::get('/icd/{id}/delete', [IcdController::class, 'delete'])->name('icd.delete');

    Route::get('/tindakan', [TindakanController::class, 'index'])->name('tindakan');
    Route::post('/tindakan/store', [TindakanController::class, 'store'])->name('tindakan.store');
    Route::post('/tindakan/{id}/update', [TindakanController::class, 'update'])->name('master.tindakan.update');
    Route::get('/tindakan/{id}/delete', [TindakanController::class, 'delete'])->name('tindakan.delete');


    Route::get('/rekam', [RekamController::class, 'index'])->name('rekam');
    Route::get('/rekam/export-csv', [RekamController::class, 'exportCsv'])->name('rekam.export-csv');
    Route::get('/rekam/add', [RekamController::class, 'add'])->name('rekam.add');
    Route::get('/rekam/{id}/edit', [RekamController::class, 'edit'])->name('rekam.edit');

    Route::post('/rekam/pasie/store', [RekamController::class, 'store'])->name('rekam.store');
    Route::get('/rekam/pasien/{id}', [RekamController::class, 'detail'])->name('rekam.detail');

    Route::get('/rekam/{id}/delete', [RekamController::class, 'delete'])->name('rekam.delete');
    Route::post('/rekam/pasien/{id}/update', [RekamController::class, 'update'])->name('rekam.update');

    Route::post('/rekam/pemeriksaan/update', [RekamPemeriksaanController::class, 'pemeriksaan'])->name('pemeriksaan.update');
    Route::post('/rekam/tindakan/update', [RekamPemeriksaanController::class, 'tindakan'])->name('tindakan.update');
    Route::post('/rekam/diagnosa/update', [RekamPemeriksaanController::class, 'diagnosa'])->name('diagnosa.update');

    Route::get('/rekam/diagnosa/delete/{id}', [RekamPemeriksaanController::class, 'diagnosa_delete'])->name('rekam.diagnosa.delete');

    Route::get('/rekam/status/{id}/{status}/update', [RekamController::class, 'rekam_status'])->name('rekam.status');


    Route::get('/rekam/file/{id}/{type}', [RekamPemeriksaanController::class, 'file'])->name('pem.file');

    // Pengaturan Akun & Ganti Password
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/password', [SettingController::class, 'updatePassword'])->name('setting.password');
    Route::post('/setting/profile', [SettingController::class, 'updateProfile'])->name('setting.profile');

});


