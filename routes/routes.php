<?php

use App\Controllers\LoginController;
use App\Controllers\PostController;
use App\Controllers\RegisterController;
use App\Controllers\SettingsController;
use App\Kernel\Router\Route;

return [
    Route::get(uri: '/', action: [PostController::class, 'index']),
    Route::get(uri: '/settings', action: [SettingsController::class, 'index']),
    Route::get('/signup', [RegisterController::class, 'index']),
    Route::get(uri: '/signin', action: [LoginController::class, 'index'])
];
