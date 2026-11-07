<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');

// Program
Route::get('/program', [ProgramController::class, 'index'])->name('program.index');
Route::get('/program/{id}', [ProgramController::class, 'show'])->name('program.show');
Route::post('/program/{id}/donasi', [DonationController::class, 'store'])->name('donasi.store');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->middleware('throttle:login')->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/dashboard', [HomeController::class, 'donatur'])->middleware('auth')->name('dashboard');
Route::get('/donatur', [HomeController::class, 'donatur'])->middleware('auth')->name('donatur');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/donasi', [AdminController::class, 'donasi'])->name('donasi');
    Route::get('/program', [AdminController::class, 'program'])->name('program');
    Route::get('/penyaluran', [AdminController::class, 'penyaluran'])->name('penyaluran');
    Route::get('/donatur', [AdminController::class, 'donatur'])->name('donatur');
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
    Route::post('/program', [AdminController::class, 'storeProgram'])->name('programs.store');
    Route::put('/program/{program}', [AdminController::class, 'updateProgram'])->name('programs.update');
    Route::delete('/program/{program}', [AdminController::class, 'destroyProgram'])->name('programs.destroy');
    Route::patch('/donasi/{donation}', [AdminController::class, 'updateDonation'])->name('donations.update');
});
