<?php

use Pastebin\Controllers\LoginController;
use Pastebin\Controllers\PostController;
use Pastebin\Controllers\RegisterController;
use Pastebin\Controllers\SettingsController;
use Pastebin\Kernel\Router\Route;

return [
    Route::get(uri: '/', action: [PostController::class, 'index']),
    Route::get(uri: '/settings', action: [SettingsController::class, 'index']),
    Route::get(uri: '/signup', action: [RegisterController::class, 'index']),
    Route::post(uri: '/signup', action: [RegisterController::class, 'register']),
    Route::get(uri: '/resend-link', action: [RegisterController::class, 'showResend']),
    Route::post(uri: '/resend-link', action: [RegisterController::class, 'resend']),
    Route::get(uri: '/verify', action: [RegisterController::class, 'verify']),
    Route::get(uri: '/signin', action: [LoginController::class, 'index']),
    Route::post(uri: '/signin', action: [LoginController::class, 'login'])
];
