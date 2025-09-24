<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InstituteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Officer\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register');


Route::middleware('auth')->group(function () {
    Route::get('/authenticated', [AuthenticationController::class, 'index'])->name('authenticated');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');


    Route::resource('profile', ProfileController::class);
});


Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('users', UserController::class)->names('admin.users');
    Route::resource('institutes', InstituteController::class)->names('admin.institutes');

});

Route::prefix('officer')->middleware(['auth', 'role:officer'])->group(function () {
    Route::resource('applications', ApplicationController::class)->names('officer.applications');

});


Route::prefix('student')->middleware(['auth', 'role:student'])->group(function () {
    Route::resource('applications', \App\Http\Controllers\Student\ApplicationController::class)->names('student.applications');

});
