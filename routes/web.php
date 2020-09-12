<?php

use Illuminate\Support\Facades\Route;


Auth::routes();
Route::view('/','home');

Route::get('statuses','StatusController@index')->name('statuses.index');
Route::post('statuses','StatusController@store')->name('statuses.store')->middleware('auth');

