<?php

namespace Pastebin\Kernel\Middleware;

use Pastebin\Kernel\Http\RedirectInterface;

abstract class AbstractMiddleware
{
    public function __construct(
        protected RedirectInterface $redirect
    ) {
    }

    abstract public function handle(): void;
}
