<?php

use Pastebin\Controllers\LoginController;
use Pastebin\Controllers\PostController;
use Pastebin\Controllers\ProfileController;
use Pastebin\Controllers\RegisterController;
use Pastebin\Controllers\SettingsController;
use Pastebin\Kernel\Router\Route;
use Pastebin\Middlewares\AuthMiddleware;
use Pastebin\Middlewares\SessionMiddleware;

return [
    Route::get(uri: '/', action: [PostController::class, 'index'], middlewares: [SessionMiddleware::class]),
    Route::get(uri: '/settings', action: [SettingsController::class, 'index'], middlewares: [SessionMiddleware::class, AuthMiddleware::class]),
    Route::get(uri: '/profile', action: [ProfileController::class, 'index'], middlewares: [SessionMiddleware::class]),
    Route::get(uri: '/signup', action: [RegisterController::class, 'index'], middlewares: [SessionMiddleware::class]),
    Route::post(uri: '/signup', action: [RegisterController::class, 'register']),
    Route::get(uri: '/resend-link', action: [RegisterController::class, 'showResend'], middlewares: [SessionMiddleware::class]),
    Route::post(uri: '/resend-link', action: [RegisterController::class, 'resend']),
    Route::get(uri: '/verify', action: [RegisterController::class, 'verify']),
    Route::get(uri: '/signin', action: [LoginController::class, 'index'], middlewares: [SessionMiddleware::class]),
    Route::post(uri: '/signin', action: [LoginController::class, 'login']),
    Route::post(uri: '/forgot-name', action: [LoginController::class, 'forgotName']),
    Route::post(uri: '/forgot-password', action: [LoginController::class, 'forgotPassword']),
    Route::get(uri: '/reset-password', action: [LoginController::class, 'resetPasswordShow']),
    Route::post(uri: '/reset-password', action: [LoginController::class, 'resetPassword']),
    Route::post(uri: '/logout', action: [LoginController::class, 'logout'])
];
