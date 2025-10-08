<?php

use App\Http\Controllers\Guest\AuthController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     if (auth()->check()) {
//         return auth()->user()->hasRole('admin')
//             ? redirect()->route('admin.dashboard.index')
//             : redirect()->route('member.dashboard.index');
//     }
//     return redirect()->route('login');
// });
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/', [GuruDashboardController::class, 'index'])->name('login');
// Route::middleware('guest')->group(function () {
//     Route::prefix('reset-password')->name('reset-password.')->group(function () {
//         Route::get('/', [ResetPasswordController::class, 'showRequestForm'])->name('request');
//     });
// });
