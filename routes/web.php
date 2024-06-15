<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;



Route::get('/', HomeController::class)->name('home');

Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/signin', [AuthController::class, 'store'])->name('signin');
Route::get('/change_password',[AuthController::class, 'edit'])->name('auth.edit');
Route::post('/change_password',[AuthController::class, 'update'])->name('auth.update');
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

Route::get('/email/verify', [VerificationController::class, 'showVerificationScreen'])
    ->name('verification.notice')->middleware('auth');

Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [VerificationController::class, 'resendVerificationEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/terms',[TermsController::class,'index'])->name('terms.index');
Route::post('/terms',[TermsController::class,'store'])->name('terms.store');


Route::middleware(['auth', 'verified','termsAccepted'])->group(function () {
    Route::get('/dashboard', function () {
        return view('Dashboard.dashoboard_screen');
    })->name('dashboard');


    Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('role:admin');

    Route::resource('clients', \App\Http\Controllers\ClientController::class);

    Route::resource('projects', \App\Http\Controllers\ProjectController::class);

    Route::resource('tasks', \App\Http\Controllers\TaskController::class);

    Route::group(['prefix' => '/media', 'as' => 'media.'], function () {
        Route::post('/{model}/{id}/upload', [\App\Http\Controllers\MediaController::class, 'store'])->name('upload');
        Route::get('/{media}/download', [\App\Http\Controllers\MediaController::class, 'download'])->name('download');
        Route::delete('/{media}/delete', [\App\Http\Controllers\MediaController::class, 'destroy'])->name('delete');
    });
    // Route::post('/media/{model}/{id}/upload', [\App\Http\Controllers\MediaController::class, 'store'])->name('media.upload');
    // Route::get('/media/{media}/download', [\App\Http\Controllers\MediaController::class, 'download'])->name('media.download');
    // Route::delete('/media/{media}/delete', [\App\Http\Controllers\MediaController::class, 'destroy'])->name('media.delete');

    Route::prefix('/notifications')->name('notifications.')->group(function () {
        Route::get('', [NotificationController::class, 'index'])->name('index');
        Route::put('/{notification}', [NotificationController::class, 'update'])->name('update');
        Route::delete('/destroy', [NotificationController::class, 'destroy'])->name('destroy');
    });

    // Route::get('/notifications',[NotificationController::class,'index'])->name('notifications.index');
    // Route::put('/notifications/{notification}',[NotificationController::class,'update'])->name('notifications.update');
    // Route::delete('/notifications/destroy',[NotificationController::class,'destroy'])->name('notifications.destroy');


});
