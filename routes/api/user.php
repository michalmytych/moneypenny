<?php

use App\Moneypenny\User\Http\Controller\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user', [UserController::class, 'user'])->name('user');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
