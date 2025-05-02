<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Owner\OwnerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Owner\HouseController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\UserController;

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



Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
    
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/tenants', [UserController::class, 'tenants'])->name('tenants');
    Route::get('/owners', [UserController::class, 'owners'])->name('owners');
    Route::delete('/deleteUser/{id}', [UserController::class, 'destroy'])->name('deleteUser');
    Route::delete('/deleteHouse/{id}', [HouseController::class, 'destroy'])->name('deleteHouse');
    
    Route::get('/tenantsHistory', [OwnerController::class, 'History'])->name('tenantsHistory');
    Route::get('/ownersHistory', [OwnerController::class, 'History'])->name('ownersHistory');
    
    Route::patch('/activate/{id}', [UserController::class, 'activte'])->name('activate');
    Route::get('change-password', [PasswordController::class, 'index'])
                ->name('change-password');
                
    
    Route::patch('/language', [AdminController::class,'language'])->name('language');
    Route::put('/policy', [AdminController::class,'policy'])->name('policy');
    Route::get('/editUsers/{id}', [UserController::class, 'edit'])->name('editUsers');
    Route::post('/adduser', [UserController::class,'store']);
    Route::get('/adduser', [UserController::class,'create'])->name('adduser');
    Route::get('/settings', [AdminController::class, 'settings'])->name('setting');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/messages',[MessageController::class,'index'])->name('messages');
});