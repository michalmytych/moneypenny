<?php

use App\Http\Controllers\Api\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user', [UserController::class, 'user'])->name('user');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
