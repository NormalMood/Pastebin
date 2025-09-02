<?php

namespace App\Kernel\Container;

use App\Kernel\Http\Request;
use App\Kernel\Http\RequestInterface;
use App\Kernel\Router\Router;
use App\Kernel\Router\RouterInterface;
use App\Kernel\View\View;
use App\Kernel\View\ViewInterface;

class Container
{
    public readonly RequestInterface $request;

    public readonly ViewInterface $view;

    public readonly RouterInterface $router;

    public function __construct()
    {
        $this->registerServices();
    }

    private function registerServices(): void
    {
        $this->request = Request::createFromGlobals();
        $this->view = new View();
        $this->router = new Router($this->view, $this->request);
    }
}
