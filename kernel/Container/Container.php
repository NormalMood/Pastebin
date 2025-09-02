<?php

namespace App\Kernel\Container;

use App\Kernel\Http\Request;
use App\Kernel\Http\RequestInterface;

class Container
{
    public readonly RequestInterface $request;

    public function __construct()
    {
        $this->registerServices();
    }

    private function registerServices(): void
    {
        $this->request = Request::createFromGlobals();
    }
}
