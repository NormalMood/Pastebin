<?php

namespace App\Kernel\Controller;

use App\Kernel\View\ViewInterface;

abstract class Controller
{
    private ViewInterface $view;

    public function view(string $name): void
    {
        $this->view->page($name);
    }

    public function setView(ViewInterface $view): void
    {
        $this->view = $view;
    }
}
