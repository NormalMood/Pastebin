<?php

namespace Pastebin\Kernel\Session;

use Pastebin\Kernel\Config\ConfigInterface;
use Pastebin\Kernel\Http\RequestInterface;
use Pastebin\Kernel\Utils\Token;

class SessionCookie implements SessionCookieInterface
{
    public function __construct(
        private ConfigInterface $config,
        private RequestInterface $request
    ) {
    }

    public function get(): Token
    {
        return new Token(
            token: $this->request->cookie()[
                $this->config->get(key: 'auth.cookie_field', default: 'SESSION_TOKEN')
            ] ?? null
        );
    }

    public function set(string $token, int $expiresAt): void
    {
        setcookie(
            $this->config->get('auth.cookie_field', 'SESSION_TOKEN'),
            $token,
            [
                'expires' => $expiresAt,
                'path' => '/',
                'domain' => 'localhost',
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
