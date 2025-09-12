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
    Route::get(uri: '/', action: [PostController::class, 'create'], middlewares: [SessionMiddleware::class]),
    Route::post(uri: '/', action: [PostController::class, 'store'], middlewares: [CSRFTokenMiddleware::class, SessionMiddleware::class]),
    Route::get(uri: '/post', action: [PostController::class, 'show'], middlewares: [SessionMiddleware::class]),
    Route::post(uri: '/post/delete', action: [PostController::class, 'destroy'], middlewares: [SessionMiddleware::class, AuthMiddleware::class]),
    Route::get(uri: '/settings', action: [SettingsController::class, 'edit'], middlewares: [SessionMiddleware::class, AuthMiddleware::class]),
    Route::get(uri: '/profile', action: [ProfileController::class, 'show'], middlewares: [SessionMiddleware::class]),
    Route::get(uri: '/signup', action: [RegisterController::class, 'showRegistrationForm'], middlewares: [SessionMiddleware::class]),
    Route::post(uri: '/signup', action: [RegisterController::class, 'register'], middlewares: [CSRFTokenMiddleware::class, GuestMiddleware::class]),
    Route::get(uri: '/resend-link', action: [RegisterController::class, 'showResendLinkForm'], middlewares: [SessionMiddleware::class]),
    Route::post(uri: '/resend-link', action: [RegisterController::class, 'resendLink'], middlewares: [CSRFTokenMiddleware::class, GuestMiddleware::class]),
    Route::get(uri: '/verify', action: [RegisterController::class, 'verify']),
    Route::get(uri: '/signin', action: [LoginController::class, 'showLoginForm'], middlewares: [SessionMiddleware::class]),
    Route::post(uri: '/signin', action: [LoginController::class, 'login'], middlewares: [CSRFTokenMiddleware::class, GuestMiddleware::class]),
    Route::post(uri: '/forgot-name', action: [LoginController::class, 'forgotName'], middlewares: [CSRFTokenMiddleware::class, GuestMiddleware::class]),
    Route::post(uri: '/forgot-password', action: [LoginController::class, 'forgotPassword'], middlewares: [CSRFTokenMiddleware::class, GuestMiddleware::class]),
    Route::get(uri: '/reset-password', action: [LoginController::class, 'showResetPasswordForm']),
    Route::post(uri: '/reset-password', action: [LoginController::class, 'resetPassword'], middlewares: [CSRFTokenMiddleware::class]),
    Route::post(uri: '/logout', action: [LoginController::class, 'logout'], middlewares: [AuthMiddleware::class])
];
