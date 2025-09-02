<?php

namespace App\Kernel;

use App\Kernel\Router\Router;

class App
{
    public function run(): void
    {
        $router = new Router();
        $router->dispatch(
            uri: $_SERVER['REQUEST_URI'],
            method: $_SERVER['REQUEST_METHOD']
        );
    }
}
