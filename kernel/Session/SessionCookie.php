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
            $this->request->cookie()[
                $this->config->get(key: 'auth.cookie_field', default: 'SESSION_TOKEN')
            ]
        );
    }

    public function set(string $token, int $ttl): void
    {
        setcookie(
            $this->config->get('auth.cookie_field', 'SESSION_TOKEN'),
            $token,
            [
                'expires' => time() + $ttl,
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

    public function remove(): void
    {
        $this->set(token: '', ttl: -SESSION_COOKIE_TTL);
    }
}
