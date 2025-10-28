<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\InputHafalanController;
use App\Http\Controllers\DashboardTahfidzController;
use App\Http\Controllers\ProgressTahfidzController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PresensiController;

// 🟢 Hilangkan route welcome ini (karena sudah diganti HomeController)
Route::get('/', [HomeController::class, 'index'])->name('home');

// 🟢 CRUD Anggota & Hafalan
Route::resource('anggota', AnggotaController::class)->parameters([
    'anggota' => 'anggota'
]);

Route::resource('hafalan', InputHafalanController::class);
Route::get('/hafalan/rekap', [InputHafalanController::class, 'rekap'])->name('hafalan.rekap');

// 🟢 Dashboard & Progress
Route::get('/dashboard-tahfidz', [DashboardTahfidzController::class, 'index'])->name('dashboard.tahfidz');
Route::get('/tahfidz/progress/{id}', [ProgressTahfidzController::class, 'show'])->name('tahfidz.progress');

Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
Route::post('/presensi', [PresensiController::class, 'store'])->name('presensi.store');

Route::get('/presensi/rekap', [PresensiController::class, 'rekap'])->name('presensi.rekap');

Route::get('/presensi/riwayat/{anggota_id}', [PresensiController::class, 'riwayat'])->name('presensi.riwayat');
