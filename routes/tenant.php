<?php

use App\Http\Controllers\Auth\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Owner\HouseController;
use App\Http\Controllers\Auth\PasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::group(['prefix' => 'tenant', 'as' => 'tenant.', 'middleware' => ['auth', 'tenant']], function () {
   

    Route::post('/request', [MessageController::class, 'store'])->name('request');
    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');

    Route::get('/message', [MessageController::class, 'index'])->name('notification');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    
    Route::post('/rate', [HouseController::class, 'storeRatting'])->name('rate');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages');
    Route::get('/change_password', [PasswordController::class,'index'])->name('change-password');
    Route::group(['prefix' => 'house', 'as' => 'house.'], function () {
    });
});