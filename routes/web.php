<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::view('/','pages.signin');


// return view('pages.dashboard');

Route::prefix('auth')->group(function () {

    Route::view('signup_form','pages.signup_form')->name('signup_form');
    Route::post('register',[AuthController::class,'register_user'])->name('register.user');
    Route::post('login',[AuthController::class,'login_user'])->name('login');
    Route::get('logout',[AuthController::class,'logout_user'])->name('logout')->middleware('auth');
});



Route::prefix('dashboard')->group(function () {


    Route::middleware('auth')->group(function () {
    
        Route::get('home',[DashboardController::class,'home'])->name('home');
    
    
    });
    
});
