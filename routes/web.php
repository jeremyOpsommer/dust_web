<?php

use App\Http\Controllers\BlizzardAPI\OAuthController;
use App\Http\Controllers\Frontend\HomepageController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\TwitchAPI\OAuthController as TwitchOAuthController;
use App\Http\Middleware\WowUserToken;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/test', [HomepageController::class, 'test'])->middleware(WowUserToken::class)->name('test');

//User
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::put('/user', [UserController::class, 'update'])->name('user.update')->middleware('auth');


Route::get('/oauth', OAuthController::class)->name('oauth');

// Twitch OAuth
Route::middleware('auth')->group(function () {
    Route::get('/twitch/redirect', [TwitchOAuthController::class, 'redirect'])->name('twitch.oauth.redirect');
    Route::get('/twitch/callback', [TwitchOAuthController::class, 'callback'])->name('twitch.oauth.callback');
});
