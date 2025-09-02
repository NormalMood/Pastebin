<?php

namespace Pastebin\Kernel\Container;

use Pastebin\Kernel\Http\Request;
use Pastebin\Kernel\Http\RequestInterface;
use Pastebin\Kernel\Router\Router;
use Pastebin\Kernel\Router\RouterInterface;
use Pastebin\Kernel\View\View;
use Pastebin\Kernel\View\ViewInterface;

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
