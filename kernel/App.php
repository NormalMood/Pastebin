<?php

namespace App\Kernel;

use App\Kernel\Container\Container;
use App\Kernel\Router\Router;

class App
{
    private Container $container;
    public function __construct()
    {
        $this->container = new Container();
    }
    public function run(): void
    {
        $router = new Router();
        $router->dispatch(
            uri: $this->container->request->uri(),
            method: $this->container->request->method()
        );
    }
}
