<?php

use Pastebin\Controllers\LoginController;
use Pastebin\Controllers\PostController;
use Pastebin\Controllers\ProfileController;
use Pastebin\Controllers\RegisterController;
use Pastebin\Controllers\SettingsController;
use Pastebin\Kernel\Router\Route;
use Pastebin\Middlewares\AuthMiddleware;
use Pastebin\Middlewares\CSRFTokenMiddleware;
use Pastebin\Middlewares\GuestMiddleware;
use Pastebin\Middlewares\SessionMiddleware;

return [
    Route::get(uri: '/', action: [PostController::class, 'index'], middlewares: [SessionMiddleware::class]),
    Route::get(uri: '/settings', action: [SettingsController::class, 'index'], middlewares: [SessionMiddleware::class, AuthMiddleware::class]),
    Route::get(uri: '/profile', action: [ProfileController::class, 'index'], middlewares: [SessionMiddleware::class]),
    Route::get(uri: '/signup', action: [RegisterController::class, 'index'], middlewares: [SessionMiddleware::class]),
    Route::post(uri: '/signup', action: [RegisterController::class, 'register'], middlewares: [CSRFTokenMiddleware::class, GuestMiddleware::class]),
    Route::get(uri: '/resend-link', action: [RegisterController::class, 'showResend'], middlewares: [SessionMiddleware::class]),
    Route::post(uri: '/resend-link', action: [RegisterController::class, 'resend'], middlewares: [CSRFTokenMiddleware::class, GuestMiddleware::class]),
    Route::get(uri: '/verify', action: [RegisterController::class, 'verify']),
    Route::get(uri: '/signin', action: [LoginController::class, 'index'], middlewares: [SessionMiddleware::class]),
    Route::post(uri: '/signin', action: [LoginController::class, 'login'], middlewares: [CSRFTokenMiddleware::class, GuestMiddleware::class]),
    Route::post(uri: '/forgot-name', action: [LoginController::class, 'forgotName'], middlewares: [CSRFTokenMiddleware::class, GuestMiddleware::class]),
    Route::post(uri: '/forgot-password', action: [LoginController::class, 'forgotPassword'], middlewares: [CSRFTokenMiddleware::class, GuestMiddleware::class]),
    Route::get(uri: '/reset-password', action: [LoginController::class, 'resetPasswordShow']),
    Route::post(uri: '/reset-password', action: [LoginController::class, 'resetPassword'], middlewares: [CSRFTokenMiddleware::class]),
    Route::post(uri: '/logout', action: [LoginController::class, 'logout'], middlewares: [AuthMiddleware::class])
];
