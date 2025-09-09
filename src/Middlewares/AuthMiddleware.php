<?php

namespace Pastebin\Middlewares;

use Pastebin\Kernel\Middleware\AbstractMiddleware;

class AuthMiddleware extends AbstractMiddleware
{
    public function handle(): void
    {
        if (!$this->auth->check()) {
            $this->redirect->to('/signin');
        }
    }
}
