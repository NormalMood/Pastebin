<?php

use App\Controllers\PostController;
use App\Controllers\SettingsController;
use App\Kernel\Router\Route;

return [
    Route::get(uri: '/', action: [PostController::class, 'index']),
    Route::get(uri: '/settings', action: [SettingsController::class, 'index'])
];
