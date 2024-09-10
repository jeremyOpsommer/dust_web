<?php

use App\Http\Controllers\BlizzardAPI\OAuthController;
use App\Http\Controllers\Frontend\HomepageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/oauth', OAuthController::class)->name('oauth');
