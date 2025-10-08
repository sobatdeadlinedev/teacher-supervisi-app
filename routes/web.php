<?php

use App\Http\Controllers\Guest\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\AdministrasiController as GuruAdministrasiController;
use App\Http\Controllers\Guru\JurnalController as GuruJurnalController;
use App\Http\Controllers\Guru\SupervisiController as GuruSupervisiController;
use App\Http\Controllers\KepalaSekolah\DashboardController as KepalaSekolahDashboardController;
use App\Http\Controllers\Pengawas\DashboardController as PengawasDashboardController;
use Illuminate\Support\Facades\Route;
// Root route dengan logic
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard.index');
        } elseif ($user->hasRole('guru')) {
            return redirect()->route('guru.dashboard.index');
        } elseif ($user->hasRole('kepala_sekolah')) {
            return redirect()->route('kepala_sekolah.dashboard.index');
        } elseif ($user->hasRole('pengawas')) {
            return redirect()->route('pengawas.dashboard.index');
        }
    }

    return redirect()->route('login');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
});

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');
});

// Guru Routes
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard.index');

    // Administrasi Route
    Route::prefix('administrasi')->name('administrasi.')->group(function () {
        Route::get('/', [GuruAdministrasiController::class, 'index'])->name('index');
        Route::post('/', [GuruAdministrasiController::class, 'store'])->name('store');
        Route::put('{id}', [GuruAdministrasiController::class, 'update'])->name('update');
        Route::delete('{id}', [GuruAdministrasiController::class, 'destroy'])->name('destroy');
    });
    // Jurnal Route
    Route::prefix('jurnal')->name('jurnal.')->group(function () {
        Route::get('/', [GuruJurnalController::class, 'index'])->name('index');
        Route::post('/', [GuruJurnalController::class, 'store'])->name('store');
        Route::put('{id}', [GuruJurnalController::class, 'update'])->name('update');
        Route::delete('{id}', [GuruJurnalController::class, 'destroy'])->name('destroy');
    });
    // Supervisi Route
    Route::prefix('supervisi')->name('supervisi.')->group(function () {
        Route::get('/', [GuruSupervisiController::class, 'index'])->name('index');
        Route::get('/history', [GuruSupervisiController::class, 'log'])->name('log');
    });
});

// Kepala Sekolah Routes
Route::middleware(['auth', 'role:kepala_sekolah'])->prefix('kepala-sekolah')->name('kepala_sekolah.')->group(function () {
    Route::get('/dashboard', [KepalaSekolahDashboardController::class, 'index'])->name('dashboard.index');
});

// Pengawas Routes
Route::middleware(['auth', 'role:pengawas'])->prefix('pengawas')->name('pengawas.')->group(function () {
    Route::get('/dashboard', [PengawasDashboardController::class, 'index'])->name('dashboard.index');
});
