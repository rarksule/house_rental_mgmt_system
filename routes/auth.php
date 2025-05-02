<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\SMSMessageController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [UserController::class, 'register'])
        ->name('register');

    Route::post('register', [UserController::class, 'store']);

    Route::get('login', [UserController::class, 'create'])
        ->name('login');

    Route::post('login', [UserController::class, 'login']);

    Route::post('login', [UserController::class, 'login'])->name('password.request');

    Route::post('/otpverify', [SMSMessageController::class, 'update'])->name('otpverify');
    Route::get('/phoneVerify', [SMSMessageController::class, 'show'])->name('phoneVerify');
    Route::post('/sendotp', [SMSMessageController::class, 'store'])->name('sendotp');


    Route::post('resetpassword', [PasswordController::class, 'resetpassword'])
    ->name('resetpassword');
});

Route::middleware('auth')->group(function () {
    

    Route::post('/messages', [MessageController::class, 'store'])->name('messagesSend');

    Route::patch('/change', [ProfileController::class, 'update'])->name('change-password');


    Route::post('confirm-password', [PasswordController::class, 'store'])->name('confirm-password');


    Route::post('delete-my-account', [UserController::class, 'destroy'])
        ->name('delete-my-account');

    Route::patch('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('logout', [UserController::class, 'logout'])
        ->name('logout');
});
