<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StatusController;
use App\Http\Controllers\StatusLikesController;
use App\Http\Controllers\StatusCommentsController;
use App\Http\Controllers\CommentLikesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserStatusController;
use App\Http\Controllers\FriendshipsController;
use App\Http\Controllers\AcceptFriendshipsController;

Auth::routes();


Route::view('/home','home');

// Statuses routes
Route::get('statuses', [StatusController::class, 'index'])->name('statuses.index');
Route::post('statuses', [StatusController::class, 'store'])->name('statuses.store')->middleware('auth');

// Statuses Likes routes
Route::post('statuses/{status}/likes', [StatusLikesController::class, 'store'])->name('statuses.likes.store')->middleware('auth');
Route::delete('statuses/{status}/likes', [StatusLikesController::class, 'destroy'])->name('statuses.likes.destroy')->middleware('auth');

// Comments Likes routes
Route::post('comments/{comment}/likes', [CommentLikesController::class, 'store'])->name('comments.likes.store')->middleware('auth');
Route::delete('comments/{comment}/likes', [CommentLikesController::class, 'destroy'])->name('comments.likes.destroy')->middleware('auth');

// Statuses Comments routes
Route::post('statuses/{status}/comments', [StatusCommentsController::class, 'store'])->name('statuses.comments.store')->middleware('auth');

// User routes
Route::get('@{user}', [UserController::class, 'show'])->name('users.show');

// User statuses routes
Route::get('users/{user}/statuses', [UserStatusController::class, 'index'])->name('users.statuses.index');

// Friendships routes
Route::post('friendships/{recipient}', [FriendshipsController::class, 'store'])->name('friendships.store')->middleware('auth');
Route::delete('friendships/{user}', [FriendshipsController::class, 'destroy'])->name('friendships.destroy')->middleware('auth');

// Request Friendships routes
Route::get('friends/request', [AcceptFriendshipsController::class, 'index'])->name('accept-friendships.index')->middleware('auth');
Route::post('accept-friendships/{sender}', [AcceptFriendshipsController::class, 'store'])->name('accept-friendships.store')->middleware('auth');
Route::delete('accept-friendships/{sender}', [AcceptFriendshipsController::class, 'destroy'])->name('accept-friendships.destroy')->middleware('auth');