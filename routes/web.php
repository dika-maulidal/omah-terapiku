<?php

use App\Events\StatusRekamUpdate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\IcdController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\RekamAssessmentController;
use App\Http\Controllers\RekamController;
use App\Http\Controllers\RekamPemeriksaanController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\LaporanController;

// Public / Guest Routes
Route::get('/', [AuthController::class, 'page_login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('login.auth');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('test', function () {
    StatusRekamUpdate::dispatch("5", "REG002", "INI TEST AJA", "http://sss", "25 05 1993");
    return "Event has been sent!";
});

Route::get('/loaddata', [RekamPemeriksaanController::class, 'insertToTableNew'])->name('loaddata');

// Authenticated Routes
Route::group(['middleware' => 'auth'], function () {

    // --- Global Shared Routes (Semua Role: Admin, Dokter, Pendaftaran) ---
    Route::get('/set-global-upt', function (\Illuminate\Http\Request $request) {
        $upt = $request->get('upt');
        if ($upt === 'all' || empty($upt)) {
            session()->forget('selected_upt');
        } else {
            session(['selected_upt' => $upt]);
        }
        return redirect()->back();
    })->name('set.global.upt');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/jadwal-terapi', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal-terapi/events', [JadwalController::class, 'eventsJson'])->name('jadwal.events');
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/password', [SettingController::class, 'updatePassword'])->name('setting.password');
    Route::post('/setting/profile', [SettingController::class, 'updateProfile'])->name('setting.profile');
    Route::post('/gantipassword/{id}', [AuthController::class, 'updatepassword'])->name('gantipassword');
    Route::post('/ai-assistant/chat', [AiAssistantController::class, 'chat'])->name('ai.chat');

    // Laporan Eksekutif & Statistik Dinas Sosial (Executive Dashboard & Rekap PDF)
    Route::get('/laporan/eksekutif', [LaporanController::class, 'index'])->name('laporan.eksekutif');
    Route::get('/laporan/eksekutif/print', [LaporanController::class, 'printPdf'])->name('laporan.eksekutif.print');

    // AJAX dropdown helpers (Accessible by all logged in users)
    Route::get('/getDokter', [DokterController::class, 'getDokter'])->name('getDokter');
    Route::get('/getTerapis', [DokterController::class, 'getDokter'])->name('getTerapis');
    Route::get('/getNoRM', [PasienController::class, 'getLastRM'])->name('getNoRM');
    Route::get('/icd/data', [IcdController::class, 'data'])->name('icd.data');

    // Notifications (Global Shared for Logged-in Users)
    Route::get('/notifications/{id}/read', [RekamController::class, 'readNotification'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [RekamController::class, 'markAllNotificationsRead'])->name('notifications.markAllRead');
    Route::get('/notifications/unread-json', [RekamController::class, 'getUnreadNotificationsJson'])->name('notifications.unreadJson');

    // Rekam Medis & Pasien (View / Read-Only Detail & Cetak for all authorized roles)
    Route::get('/rekam', [RekamController::class, 'index'])->name('rekam');
    Route::get('/rekam/export-csv', [RekamController::class, 'exportCsv'])->name('rekam.export-csv');
    Route::get('/rekam/pasien/{id}', [RekamController::class, 'detail'])->name('rekam.detail');
    Route::get('/rekam/file/{id}/{type}', [RekamPemeriksaanController::class, 'file'])->name('pem.file');
    Route::get('/rekam/{id}/assessment/show', [RekamAssessmentController::class, 'show'])->name('rekam.assessment.show');
    Route::get('/rekam/{id}/assessment/print', [RekamAssessmentController::class, 'print'])->name('rekam.assessment.print');
    Route::get('/rekam/{id}/soap/print', [RekamController::class, 'printSoap'])->name('rekam.soap.print');
    Route::get('/rekam/{id}/home-program/print', [RekamController::class, 'printHomeProgram'])->name('rekam.home-program.print');
    Route::get('/rekam/status/{id}/{status}/update', [RekamController::class, 'rekam_status'])->name('rekam.status');

    Route::get('/penerima-manfaat', [PasienController::class, 'index'])->name('penerima-manfaat');
    Route::get('/penerima-manfaat/export-csv', [PasienController::class, 'exportCsv'])->name('penerima-manfaat.export-csv');
    Route::get('/penerima-manfaat/json', [PasienController::class, 'json'])->name('penerima-manfaat.json');
    Route::get('/penerima-manfaat/{id}/file', [PasienController::class, 'file'])->name('penerima-manfaat.file');

    // --- Role: Admin & Pendaftaran (Front-Office Management) ---
    Route::group(['middleware' => 'role:Admin,Pendaftaran'], function () {
        Route::get('/penerima-manfaat/add', [PasienController::class, 'add'])->name('penerima-manfaat.add');
        Route::post('/penerima-manfaat/store', [PasienController::class, 'store'])->name('penerima-manfaat.store');
        Route::get('/penerima-manfaat/{id}/edit', [PasienController::class, 'edit'])->name('penerima-manfaat.edit');
        Route::post('/penerima-manfaat/{id}/update', [PasienController::class, 'update'])->name('penerima-manfaat.update');

        Route::get('/rekam/add', [RekamController::class, 'add'])->name('rekam.add');
        Route::post('/rekam/pasie/store', [RekamController::class, 'store'])->name('rekam.store');
        Route::get('/rekam/{id}/edit', [RekamController::class, 'edit'])->name('rekam.edit');
        Route::post('/rekam/pasien/{id}/update', [RekamController::class, 'update'])->name('rekam.update');
    });

    // --- Role: Admin & Dokter (Clinical Operations - Assessment, SOAP, Tindakan, Diagnosa) ---
    Route::group(['middleware' => 'role:Admin,Dokter'], function () {
        // Assessment Terapis (Form & Simpan)
        Route::get('/rekam/{id}/assessment', [RekamAssessmentController::class, 'form'])->name('rekam.assessment');
        Route::post('/rekam/{id}/assessment', [RekamAssessmentController::class, 'store'])->name('rekam.assessment.store');

        // Pemeriksaan, Tindakan, Diagnosa
        Route::post('/rekam/pemeriksaan/update', [RekamPemeriksaanController::class, 'pemeriksaan'])->name('pemeriksaan.update');
        Route::post('/rekam/tindakan/update', [RekamPemeriksaanController::class, 'tindakan'])->name('tindakan.update');
        Route::post('/rekam/diagnosa/update', [RekamPemeriksaanController::class, 'diagnosa'])->name('diagnosa.update');
        Route::get('/rekam/diagnosa/delete/{id}', [RekamPemeriksaanController::class, 'diagnosa_delete'])->name('rekam.diagnosa.delete');
    });

    // --- Role: Admin Only (Master Data & Deletion) ---
    Route::group(['middleware' => 'role:Admin'], function () {
        // Master Omah Terapiku / Poli
        Route::get('/omahterapiku', [PoliController::class, 'index'])->name('omahterapiku');
        Route::post('/omahterapiku', [PoliController::class, 'store'])->name('omahterapiku.store');
        Route::post('/omahterapiku/{id}/update', [PoliController::class, 'update'])->name('omahterapiku.update');
        Route::get('/omahterapiku/{id}/delete', [PoliController::class, 'delete'])->name('omahterapiku.delete');

        // Master Dokter / Terapis
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

        // Master Petugas
        Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas');
        Route::post('/petugas/store', [PetugasController::class, 'store'])->name('petugas.store');
        Route::post('/petugas/{id}/update', [PetugasController::class, 'update'])->name('petugas.update');
        Route::get('/petugas/{id}/delete', [PetugasController::class, 'delete'])->name('petugas.delete');

        // Master Tindakan
        Route::get('/tindakan', [TindakanController::class, 'index'])->name('tindakan');
        Route::post('/tindakan/store', [TindakanController::class, 'store'])->name('tindakan.store');
        Route::post('/tindakan/{id}/update', [TindakanController::class, 'update'])->name('master.tindakan.update');
        Route::get('/tindakan/{id}/delete', [TindakanController::class, 'delete'])->name('tindakan.delete');

        // Master ICD-10
        Route::get('/icd', [IcdController::class, 'index'])->name('icd');
        Route::post('/icd/store', [IcdController::class, 'store'])->name('icd.store');
        Route::post('/icd/{id}/update', [IcdController::class, 'update'])->name('icd.update');
        Route::get('/icd/{id}/delete', [IcdController::class, 'delete'])->name('icd.delete');

        // Deletion of Core Records
        Route::get('/penerima-manfaat/{id}/delete', [PasienController::class, 'delete'])->name('penerima-manfaat.delete');
        Route::get('/rekam/{id}/delete', [RekamController::class, 'delete'])->name('rekam.delete');
    });
});
