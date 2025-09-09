<?php

namespace Pastebin\Kernel\Middleware;

use Pastebin\Kernel\Auth\AuthInterface;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Http\RedirectInterface;
use Pastebin\Kernel\Session\SessionCookieInterface;

abstract class AbstractMiddleware
{
    public function __construct(
        protected DatabaseInterface $database,
        protected RedirectInterface $redirect,
        protected AuthInterface $auth,
        protected SessionCookieInterface $sessionCookie
    ) {
    }

    abstract public function handle(): void;
}
