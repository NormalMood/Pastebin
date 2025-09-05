<?php

namespace Pastebin\Kernel\Session;

use Pastebin\Kernel\Utils\Token;

interface SessionCookieInterface
{
    public function get(): Token;

    public function set(string $token, int $ttl): void;

    public function has(): bool;

    public function remove(): void;
}
