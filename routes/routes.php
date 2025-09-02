<?php

use App\Controllers\LoginController;
use App\Controllers\PostController;
use App\Controllers\RegisterController;
use App\Controllers\SettingsController;
use App\Kernel\Router\Route;

return [
    Route::get(uri: '/', action: [PostController::class, 'index']),
    Route::get(uri: '/settings', action: [SettingsController::class, 'index']),
    Route::get(uri: '/signup', action: [RegisterController::class, 'index']),
    Route::post(uri: '/signup', action: [RegisterController::class, 'register']),
    Route::get(uri: '/signin', action: [LoginController::class, 'index']),
    Route::post(uri: '/signin', action: [LoginController::class, 'login'])
];
