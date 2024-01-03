<?php

use App\Http\Controllers\Api\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PendidikanController;
use App\Http\Controllers\Api\admin\AuthController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\admin\AdminProfileController;
use Illuminate\Http\Request;
use App\Http\Controllers\API\admin\ReportController;
use App\Http\Controllers\Api\LaporanController;
use App\Models\Laporan;

// user magang

Route::auth();
Route::post('/login', [LoginController::class, 'login']);
Route::post('/index', [HomeController::class, 'index']);

// user
Route::post('register',[AuthController::class,'Register']);
Route::post('login', [AuthController::class,'Login']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// pendidikan
Route::post('/pendidikans', [PendidikanController::class, 'create']);
Route::get('/pendidikans', [PendidikanController::class, 'getAll']);
Route::put('/pendidikans/{id}', [PendidikanController::class, 'update']);
Route::delete('/pendidikans/{id}', [PendidikanController::class, 'delete']);



//Login Admin
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
Route::post('/admin/logout', [AuthController::class, 'logout']);


Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/permissions', [ReportController::class, 'getPermissions']);
    Route::post('/admin/permissions/approve/{id}', [ReportController::class, 'approvePermission']);
    Route::post('/admin/permissions/reject/{id}', [ReportController::class, 'rejectPermission']);
});

//Laporan
Route::get('/presensi', [LaporanController::class, 'getall']);
Route::post('/presensi/izin/{id_pemagang}', [LaporanController::class, 'izin']);
Route::get('/presensi/tidak_hadir/', [LaporanController::class, 'tidak_hadir']);
Route::get('/presensi/tidak_masuk/{id}', [LaporanController::class, 'tidak_masuk']);

//admin
Route::get('/admin/profile/{id}', [AdminProfileController::class, 'editAdmin'])->name('profile.edit.admin');
Route::post('/admin/update/{id}', [AdminProfileController::class, 'updateAdmin'])->name('profile.update.admin');
Route::get('/admin/profile', [AdminProfileController::class, 'seeAdmin']);

