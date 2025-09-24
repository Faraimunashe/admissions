<?php

use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InstituteController;
use App\Http\Controllers\Admin\PeriodController;
use App\Http\Controllers\Admin\ProgrammeController;
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
    Route::resource('programmes', ProgrammeController::class)->names('admin.programmes');
    Route::resource('periods', PeriodController::class)->names('admin.periods');
    Route::resource('applications', AdminApplicationController::class)->names('admin.applications');

});

Route::prefix('officer')->middleware(['auth', 'role:officer'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Officer\DashboardController::class, 'index'])->name('officer.dashboard');
    Route::resource('applications', ApplicationController::class)->names('officer.applications');
    Route::post('applications/{application}/accept', [ApplicationController::class, 'accept'])->name('officer.applications.accept');
    Route::post('applications/{application}/reject', [ApplicationController::class, 'reject'])->name('officer.applications.reject');
    Route::post('applications/{application}/offer', [ApplicationController::class, 'offer'])->name('officer.applications.offer');
    Route::resource('institute-programmes', \App\Http\Controllers\Officer\InstituteProgrammeController::class)->names('officer.institute-programmes');

});


Route::prefix('student')->middleware(['auth', 'role:student'])->group(function () {
    Route::resource('applications', \App\Http\Controllers\Student\ApplicationController::class)->names('student.applications');

});
