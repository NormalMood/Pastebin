<?php

namespace Pastebin\Kernel\Utils;

class Token
{
    public function __construct(
        private string $token
    ) {
    }

    public function get(): string
    {
        return $this->token;
    }

    public static function random(): string
    {
        return bin2hex(string: random_bytes(length: 32));
    }
}
