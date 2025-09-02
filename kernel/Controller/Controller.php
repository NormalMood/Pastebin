<?php

namespace Pastebin\Kernel\Controller;

use Pastebin\Kernel\Http\RequestInterface;
use Pastebin\Kernel\View\ViewInterface;

abstract class Controller
{
    private ViewInterface $view;

    private RequestInterface $request;

    public function view(string $name): void
    {
        $this->view->page($name);
    }

    public function setView(ViewInterface $view): void
    {
        $this->view = $view;
    }

    public function request(): RequestInterface
    {
        return $this->request;
    }

    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
    }
}
