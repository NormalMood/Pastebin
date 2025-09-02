<?php

use App\Controllers\PostController;
use App\Kernel\Router\Route;

return [
    Route::get(uri: '/', action: [PostController::class, 'index'])
];
