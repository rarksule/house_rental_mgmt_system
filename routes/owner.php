<?php

use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Owner\HouseController;
use App\Http\Controllers\MessageController;
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



Route::group(['prefix' => 'owner', 'as' => 'owner.', 'middleware' => ['auth', 'owner']], function () {
    
    
    Route::group(['prefix' => 'tenant', 'as' => 'tenant.'], function () {

        Route::get('/index', [ProfileController::class, 'edit'])->name('index');
    });

    Route::delete('/delete-image/{image}', function ($image) {
        
        $imagemedia = (object)$image;
        $imagemedia->delete();
    
        return response()->json(['message' => 'Image deleted successfully']);
    });
    
    
    Route::get('/addHouse', [HouseController::class, 'create'])->name('addHouse');
    Route::post('/addHouse', [HouseController::class, 'store'])->name('storeHouse');
    Route::get('/allHouse', [HouseController::class, 'index'])->name('allHouse');
    Route::get('/rentedHouse', [HouseController::class, 'rented'])->name('rentedHouse');
    Route::get('/editHouse/{id}', [HouseController::class, 'edit'])->name('editHouse');
    Route::patch('/update/{id}', [HouseController::class, 'update'])->name('update');
    Route::delete('/deleteHouse/{id}', [HouseController::class, 'destroy'])->name('deleteHouse');
    Route::get('/setting', [OwnerController::class, 'index'])->name('setting');
    Route::get('/dashboard', [OwnerController::class, 'index'])->name('dashboard');
    Route::get('/message', [MessageController::class, 'index'])->name('notification');
    Route::get('/profile', [ProfileController::class, 'index'])->name(name: 'profile');
    
    
    Route::get('/tenantsHistory', [OwnerController::class, 'tenatHistory'])->name('tenantsHistory');
    
    Route::get('/tenants', [UserController::class, 'tenants'])->name('tenants');
    Route::get('/messages',[MessageController::class,'index'])->name('messages');
    Route::get('/change_password', [PasswordController::class,'index'])->name('change-password');
    
Route::post('/deletemedia', [HouseController::class, 'deleteMedia'])->name('deletemedia');
});