<?php

namespace Pastebin\Kernel\Middleware;

use Pastebin\Kernel\Auth\AuthInterface;
use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Kernel\Http\RedirectInterface;
use Pastebin\Kernel\Http\RequestInterface;
use Pastebin\Kernel\Session\SessionCookieInterface;
use Pastebin\Kernel\Session\SessionInterface;
use Pastebin\Kernel\Validator\ValidatorInterface;

abstract class AbstractMiddleware
{
    public function __construct(
        protected DatabaseInterface $database,
        protected RedirectInterface $redirect,
        protected AuthInterface $auth,
        protected SessionInterface $session,
        protected SessionCookieInterface $sessionCookie,
        protected RequestInterface $request,
        protected ValidatorInterface $validator
    ) {
    }

    abstract public function handle(): void;
}
