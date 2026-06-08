<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlizzardAPI\OAuthController;
use App\Http\Controllers\Frontend\HomepageController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\TwitchAPI\OAuthController as TwitchOAuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\WowUserToken;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index'])->name('home');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});
Route::post('/logout', LogoutController::class)->name('logout')->middleware('auth');
Route::get('/test', [HomepageController::class, 'test'])->middleware(WowUserToken::class)->name('test');

//User
Route::middleware('auth')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::put('/user', [UserController::class, 'update'])->name('user.update');
});


Route::get('/oauth', OAuthController::class)->name('oauth');

// Twitch OAuth
Route::middleware('auth')->group(function () {
    Route::get('/twitch/redirect', [TwitchOAuthController::class, 'redirect'])->name('twitch.oauth.redirect');
    Route::get('/twitch/callback', [TwitchOAuthController::class, 'callback'])->name('twitch.oauth.callback');
});

// Admin
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::resource('users', AdminUserController::class)->except('show');
});
