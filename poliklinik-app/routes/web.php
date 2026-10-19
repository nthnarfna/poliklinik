<?php

use App\Http\Controllers\Admin\AdminPoliController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 1. ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::resource('polis', AdminPoliController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class);

    // Route untuk mengatasi Route [polis.index] not defined
    Route::get('/poli', function () {
        return "Halaman Data Poli";
    })->name('polis.index');

    // Route pendukung admin lainnya (jika ada di menu)
    Route::get('/dokter', function () { return "Kelola Dokter"; })->name('dokter.index');
    Route::get('/pasien', function () { return "Kelola Pasien"; })->name('pasien.index');
    Route::get('/obat', function () { return "Kelola Obat"; })->name('obat.index');
});

// 2. DOKTER
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');
    Route::resource('jadwal-periksa', JadwalPeriksaController::class);

    // Route Jadwal Periksa
    Route::get('/jadwal-periksa', function () {
        return "Halaman Jadwal Periksa Dokter";
    })->name('jadwal-periksa.index');

    // Route Periksa Pasien (untuk mengatasi error di atas)
    Route::get('/periksa-pasien', function () {
        return "Halaman Periksa Pasien";
    })->name('periksa-pasien.index');

    // Jaga-jaga menu Riwayat Pasien jika ada di sidebar
    Route::get('/riwayat-pasien', function () {
        return "Halaman Riwayat Pasien";
    })->name('riwayat-pasien.index');
});

// Di dalam group pasien:
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    // Tambahkan ini agar tidak error lagi:
    Route::get('/daftar', function () {
        return "Halaman Pendaftaran";
    })->name('pasien.daftar');
});