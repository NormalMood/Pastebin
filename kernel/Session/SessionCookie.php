<?php

namespace Pastebin\Kernel\Session;

use Pastebin\Kernel\Http\RequestInterface;
use Pastebin\Kernel\Utils\Token;

class SessionCookie implements SessionCookieInterface
{
    public function __construct(
        private RequestInterface $request
    ) {
    }

    public function get(): Token
    {
        return new Token(
            token: $this->request->cookie()[
                $_ENV['AUTH_COOKIE_FIELD']
            ] ?? null
        );
    }

    public function set(string $token, int $expiresAt): void
    {
        setcookie(
            $_ENV['AUTH_COOKIE_FIELD'],
            $token,
            [
                'expires' => $expiresAt,
                'path' => '/',
                'secure' => false,
                'httponly' => true,
                'samesite' => 'Strict'
            ]
        );
    }

    public function has(): bool
    {
        $token = $this->get()->get();
        return isset($token);
    }

    public function delete(): void
    {
        $this->set(token: '', expiresAt: time() - SESSION_COOKIE_TTL);
    }
}
