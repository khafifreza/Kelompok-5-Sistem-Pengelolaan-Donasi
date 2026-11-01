<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/donatur', [HomeController::class, 'donatur'])->name('donatur');
Route::get('/dashboard', [HomeController::class, 'donatur'])->name('dashboard');

// Program
Route::get('/program', [ProgramController::class, 'index'])->name('program.index');
Route::get('/program/{id}', [ProgramController::class, 'show'])->name('program.show');

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Admin 
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/donasi', [App\Http\Controllers\AdminController::class, 'donasi'])->name('donasi');
    Route::get('/program', [App\Http\Controllers\AdminController::class, 'program'])->name('program');
    Route::get('/penyaluran', [App\Http\Controllers\AdminController::class, 'penyaluran'])->name('penyaluran');
    Route::get('/donatur', [App\Http\Controllers\AdminController::class, 'donatur'])->name('donatur');
    Route::get('/laporan', [App\Http\Controllers\AdminController::class, 'laporan'])->name('laporan');
});