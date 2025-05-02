<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Models\User;
use Carbon\Carbon;

Route::get('/local/{ln}', function ($ln) {
    $lang = '';
    foreach (languages() as $language) {
        if ($language->code == $ln) {
            $lang = $language;
            break;
        }
    }
    $ln = $lang->code ?? 'en';
    session()->put('locale', $ln);
    if(Auth::check()){
        auth()->user()->update(['locale'=> $ln]);
    }
    return redirect()->back();

})->name('local');





Route::get('/dashboard', function () {

    return isAdmin() ? redirect(route('admin.dashboard'))
        : (isOwner() ? redirect(route('owner.dashboard')) : redirect(route('home')));

})->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/messages', [HomeController::class, 'index'])->name('messages');

Route::get('/house_detail/{id}', [HomeController::class, 'show'])->name('house_detail');

require __DIR__ . '/auth.php';