<?php

use App\Http\Controllers\BlizzardAPI\OAuthController;
use App\Http\Controllers\Frontend\HomepageController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Middleware\WowUserToken;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/test', [HomepageController::class, 'test'])->middleware(WowUserToken::class)->name('test');

//User
Route::get('/user', [UserController::class, 'index'])->name('user.index');


Route::get('/oauth', OAuthController::class)->name('oauth');
