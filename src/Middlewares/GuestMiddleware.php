<?php

namespace Pastebin\Middlewares;

use Pastebin\Kernel\Middleware\AbstractMiddleware;

class GuestMiddleware extends AbstractMiddleware
{
    public function handle(): void
    {
        if ($this->auth->check()) {
            $this->redirect->to('/');
        }
    }
}
