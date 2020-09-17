<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StatusController;


Auth::routes();

Route::view('/','home');

Route::get('statuses', [StatusController::class, 'index'])->name('statuses.index');
Route::post('statuses', [StatusController::class, 'store'])->name('statuses.store')->middleware('auth');

