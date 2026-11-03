<?php

use App\Http\Controllers\ProgramApiController;
use Illuminate\Support\Facades\Route;

Route::get('/programs', [ProgramApiController::class, 'index'])->name('programs.index');
Route::get('/programs/{id}', [ProgramApiController::class, 'show'])->whereNumber('id')->name('programs.show');
