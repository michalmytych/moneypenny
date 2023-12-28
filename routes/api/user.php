<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\UserController;

Route::get('/user', [UserController::class, 'user'])->name('user');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
