<?php

use App\Moneypenny\User\Http\Controller\Web\AuthenticatedSessionController;
use App\Moneypenny\User\Http\Controller\Web\ConfirmablePasswordController;
use App\Moneypenny\User\Http\Controller\Web\DeviceController;
use App\Moneypenny\User\Http\Controller\Web\EmailVerificationNotificationController;
use App\Moneypenny\User\Http\Controller\Web\EmailVerificationPromptController;
use App\Moneypenny\User\Http\Controller\Web\NewPasswordController;
use App\Moneypenny\User\Http\Controller\Web\PasswordController;
use App\Moneypenny\User\Http\Controller\Web\PasswordResetLinkController;
use App\Moneypenny\User\Http\Controller\Web\RegisteredUserController;
use App\Moneypenny\User\Http\Controller\Web\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest', 'deny_blocked'])->group(function () {
    Route::middleware('one_time_registration')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('register');
        Route::post('register', [RegisteredUserController::class, 'store']);
    });

    Route::get('one-time-registration-error', [RegisteredUserController::class, 'oneTimeRegistrationError'])
        ->name('one_time_registration_error');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware(['auth', 'deny_blocked'])->group(function () {
    Route::get('devices', [DeviceController::class, 'index'])
        ->name('devices');

    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
