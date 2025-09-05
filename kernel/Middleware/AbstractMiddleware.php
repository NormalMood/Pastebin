<?php

namespace Pastebin\Kernel\Middleware;

abstract class AbstractMiddleware
{
    public function __construct(
    ) {
    }

    abstract public function handle(): void;
}
