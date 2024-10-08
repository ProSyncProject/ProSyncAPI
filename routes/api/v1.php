<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'auth',
    'as' => 'auth.',
    'controller' => \App\Http\Controllers\AuthenticationController::class
], function() {
    Route::post('/login', 'login')->name('login');
    Route::post('/forgot-password', 'forgotPassword')->name('forgot-password');
    Route::post('/reset-password', 'resetPassword')->name('reset-password');

    Route::post('/github', 'github')->name('github');

    Route::group([
        'middleware' => 'auth:sanctum'
    ], function() {
        Route::get('/echo', 'echo')->name('echo');
        Route::get('/profile', 'profile')->name('profile');
        Route::get('/refresh', 'refresh')->name('refresh');
        Route::post('/change-password', 'changePassword')->name('change-password');
        Route::post('/logout', 'logout')->name('logout');
    });
});

Route::group([
    'middleware' => 'auth:sanctum'
], function() {
});
